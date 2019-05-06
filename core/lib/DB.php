<?php
/**
 * Class DB
 * @package core\lib
 */

namespace core\lib;

use PDO;
use PDOException;
use PDOStatement;

class DB
{

    protected $pdo;
    protected $table;
    protected $fields = [];
    protected $sql = [];
    protected $error = [];

    function __construct()
    {
        $dsn = sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME);
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PWD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->exec("SET NAMES UTF8");
        } catch (PDOException $e) {
            exit('Connection failed: ' . $e->getMessage());
        }
        $this->pdo = $pdo;
    }

    // table
    function table($table)
    {
        $this->table = DB_TABLE_PRE . $table;
        $this->fields = $this->getField($this->table);
        return $this;
    }

    // 字段过滤
    function fieldFilter(array $fields)
    {
        return array_intersect_key($fields, array_flip($this->fields)); // 字段过滤
    }

    /** 插入数据
     * @param array $data
     * @return string
     */
    function insert(array $data)
    {
        $data = $this->fieldFilter($data);
        if (empty($data)) {
            return false;
        }

        $data = get_magic_quotes_gpc() ? $data : array_map('addslashes', $data); // 特殊字符转义

        $keys = [];
        $values = [];
        foreach ($data as $key => $value) {
            $keys[] = "`{$key }`";
            $values[] = "'{$value}'";
        }

        $sql = sprintf("INSERT INTO `%s` (%s) VALUES (%s)", $this->table, implode(',', $keys), implode(',', $values));
        $this->exec($sql);
        return $this->pdo->lastInsertId();
    }

    /**
     * 更新数据
     * @param array $data
     * @param string $where
     * @return bool|int
     */
    function update(array $data, $where = '')
    {
        $data = $this->fieldFilter($data);
        if (empty($data)) {
            $this->error[] = 'field is not defined';
            return false;
        }

        $data = get_magic_quotes_gpc() ? $data : array_map('addslashes', $data); //特殊字符转义

        $fields = [];
        $pri = $this->fields['pri'];
        foreach ($data as $key => $value) {
            if ($key == $pri) {
                $where = "`{$key}`={$value} LIMIT 1";
            } else {
                $fields[] = "`{$key}`='{$value}'";
            }
        }

        if (is_numeric($where)) {
            $where = "`{$pri}`={$where} LIMIT 1";
        }

        if (empty($fields) || empty($where)) {
            return false;
        }
        $sql = sprintf('UPDATE `%s` SET %s WHERE %s', $this->table, implode(',', $fields), $where);
        return $this->exec($sql);
    }

    /**
     * 字段值增长
     * @param $field string
     * @param $step int
     * @param $where int|string
     * @return bool|int
     */
    function increase($field, $step, $where)
    {
        if (is_numeric($where)) {
            $pri = $this->fields['pri'];
            $where = "`{$pri}`={$where} LIMIT 1";
        }
        $table = $this->table;
        $sql = "UPDATE `{$table}` SET `{$field}`=`{$field}`+{$step} WHERE {$where}";
        return $this->exec($sql);
    }

    /**
     * 删除数据
     * @param $where
     * @return bool|int
     */
    function delete($where)
    {
        if (is_numeric($where)) {
            $where = "WHERE `{$this->fields['pri']}` = {$where} LIMIT 1";
        }
        $sql = "DELETE FROM `{$this->table}` {$where}";
        return $this->exec($sql);
    }


    //查询数据
    function select($where = '', $field = '*')
    {
        $sql = "SELECT {$field} FROM `{$this->table}` {$where}";
        $result = $this->query($sql);
        return ($result instanceof PDOStatement) ? $result->fetchAll() : [];
    }

    //查询一条数据
    function fetch($where = '', $field = '*')
    {
        if (is_numeric($where)) {
            $where = "WHERE `{$this->fields['pri']}` = {$where}";
        }
        $where .= ' LIMIT 1';
        $sql = "SELECT {$field} FROM `{$this->table}` {$where}";
        $result = $this->query($sql);
        return ($result instanceof PDOStatement) ? $result->fetch() : [];
    }

    //查询数据总数
    function getCount($where = '', $field = '*')
    {
        $sql = sprintf("SELECT COUNT(%s) FROM `%s` %s", $field, $this->table, $where);
        $result = $this->query($sql);
        return ($result instanceof PDOStatement) ? $result->fetchColumn() : 0;
    }

    //查询字段最大值
    function getMax($field = '')
    {
        $field = in_array($field, $this->fields) ? $field : $this->fields['pri'];
        $sql = sprintf('SELECT MAX(%s) FROM `%s`', $field, $this->table);
        $result = $this->query($sql);
        return ($result instanceof PDOStatement) ? $result->fetchColumn() : 0;
    }

    //获取数据表 AUTO_INCREMENT 值
    function getAutoincrement()
    {
        $sql = "SHOW TABLE STATUS FROM `" . DB_NAME . "` LIKE '{$this->table}'";
        $result = $this->query($sql);
        if ($result instanceof PDOStatement) {
            $data = $result->fetch();
            return $data['Auto_increment'];
        } else {
            return 0;
        }
    }

    //获取字段注释
    function fieldComment()
    {
        $sql = sprintf('SHOW FULL FIELDS FROM `%s`', $this->table);
        $result = $this->query($sql);
        $fields = [];
        foreach ($result->fetchAll() as $row) {
            $fields[$row['Field']] = $row['Comment'];
        }
        return array_filter($fields);
    }

    function exec($sql)
    {
        $this->sql[] = $sql;
        $result = false;
        try {
            $result = $this->pdo->exec($sql);
        } catch (PDOException $e) {
            $this->error[] = $e->getMessage();
        }
        return $result;
    }

    //执行SQL语句
    function query($sql)
    {
        $this->sql[] = $sql;
        $result = false;
        try {
            $result = $this->pdo->query($sql);
            $result->setFetchMode(PDO::FETCH_ASSOC);//只取关联数组
        } catch (PDOException $e) {
            $this->error[] = $e->getMessage();
        }
        return $result;
    }

    //取得 MySQL 服务器版本
    function version()
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    //获取数据表字段信息
    private
    function getField($table)
    {
        $cacheFile = RUNTIME_FIELD_DIR . $table . '.php';
        if (is_file($cacheFile)) {
            return include $cacheFile;
        }
        $result = $this->query('SHOW COLUMNS FROM ' . $table);
        if (!$result) {
            return [];
        }

        $fields = [];
        foreach ($result as $row) {
            if ($row['Key'] == 'PRI') {
                $fields['pri'] = $row['Field'];
            } else {
                $fields[] = $row['Field'];
            }
        }

        $content = '<?php return ' . var_export($fields, TRUE) . ';';
        $this->writeFile($cacheFile, $content);
        return $fields;
    }

    //写入文件
    protected
    function writeFile($filename, $data)
    {
        $dir = dirname($filename);
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($filename, $data);
    }

    //debug
    function debug()
    {
        if ($this->sql) {
            L($this->sql);
        }
        if ($this->error) {
            L($this->error);
        }
    }

}
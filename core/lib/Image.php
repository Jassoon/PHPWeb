<?php
/**
 * Class Image
 * @package core\lib
 */

namespace core\lib;

class Image
{

    protected
        $image,
        $imageType,
        $bgColor;

    function __construct(array $bgColor = [255, 255, 255])
    {
        $this->bgColor = $bgColor;
    }

    /**
     * 加载图像文件
     * @param $image
     * @return $this
     */
    public function open($image)
    {
        $image_info = getimagesize($image);
        $this->imageType = $image_info[2];
        $this->image = $this->create($image, $image_info[2]);
        return $this;
    }

    /**保存
     * @param string $filename 图像文件名
     * @param int $quality 图像质量
     * @return $this
     */
    public function save($filename, $quality = 75)
    {
        if ($this->imageType == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $quality);
        } else if ($this->imageType == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } else if ($this->imageType == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        return $this;
    }

    /**
     * 输出
     * @return $this
     */
    public function output()
    {
        header("Content-Type: " . image_type_to_mime_type($this->imageType));
        if ($this->imageType == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } else if ($this->imageType == IMAGETYPE_GIF) {
            imagegif($this->image);
        } else if ($this->imageType == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
        return $this;
    }

    /**
     * 根据宽度按比例重设图像
     * @param int $width
     * @param bool $stretch 拉伸
     * @return $this
     */
    public function width($width, $stretch = false)
    {
        $image_width = imagesx($this->image);
        $w = $stretch ? $width : min($width, $image_width);
        $h = imagesy($this->image) * ($w / $image_width);
        $this->resize($w, $h);
        return $this;
    }

    /**
     * 根据高度按比例重设图像
     * @param int $height
     * @param bool $stretch
     * @return $this
     */
    public function height($height, $stretch = false)
    {
        $image_height = imagesy($this->image);
        $h = $stretch ? $height : min($height, $image_height);
        $w = imagesx($this->image) * ($h / $image_height);
        $this->resize($w, $h);
        return $this;
    }

    /**
     * 根据宽度和高度重设图像
     * @param int $width
     * @param int $height
     * @param bool $stretch
     * @return $this
     */
    public function size($width, $height, $stretch = false)
    {
        $image_width = imagesx($this->image);
        $image_height = imagesy($this->image);
        if ($stretch || $image_width > $width || $image_height > $height) {
            $image_ratio = $image_width / $image_height;
            if ($width / $height > $image_ratio) {
                $width = round($height * $image_ratio);
            } else {
                $height = round($width / $image_ratio);
            }
        } else {
            $width = $image_width;
            $height = $image_height;
        }
        $this->resize($width, $height);
        return $this;
    }

    /**
     * 根据比例调整图像
     * @param $scale
     * @return $this
     */
    public function scale($scale = 1)
    {
        $width = imagesx($this->image) * $scale;
        $height = imagesy($this->image) * $scale;
        $this->resize($width, $height);
        return $this;
    }

    /**
     * 根据宽度和高度重置图像，这个方法不会计算比例，如需计算比例请使用scale
     * @param $width
     * @param $height
     * @return $this
     */
    protected function resize($width, $height)
    {
        $dst_image = imagecreatetruecolor($width, $height);
        $bg_color = imagecolorallocate($dst_image, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
        imagefill($dst_image, 0, 0, $bg_color);
        imagecopyresampled($dst_image, $this->image, 0, 0, 0, 0, $width, $height, imagesx($this->image), imagesy($this->image));
        imagedestroy($this->image); //销毁图像资源，释放内存
        $this->image = $dst_image;
        return $this;
    }

    /**
     * 调整图像时，遇到不够的位置用底色填充
     * @param int $width
     * @param int $height
     * @return $this
     */
    public function fill($width, $height)
    {
        $src_w = imagesx($this->image);
        $src_h = imagesy($this->image);

        if ($src_w > $width || $src_h > $height) {
            $src_r = $src_w / $src_h;
            if ($width / $height > $src_r) {
                $dst_w = $height * $src_r;
                $dst_h = $height;
                $dst_x = ($width - $dst_w) / 2;
                $dst_y = 0;
            } else {
                $dst_w = $width;
                $dst_h = $width / $src_r;
                $dst_x = 0;
                $dst_y = ($height - $dst_h) / 2;
            }
        } else {
            $width = $src_w;
            $height = $src_h;
            $dst_w = $src_w;
            $dst_h = $src_h;
            $dst_x = 0;
            $dst_y = 0;
        }

        $dst_image = imagecreatetruecolor($width, $height);
        $bg_color = imagecolorallocate($dst_image, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
        imagefill($dst_image, 0, 0, $bg_color);
        imagecopyresampled($dst_image, $this->image, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
        imagedestroy($this->image); //销毁图像资源，释放内存
        $this->image = $dst_image;
        return $this;
    }

    /**
     * 根据宽高裁切图像
     * @param $width
     * @param $height
     * @return $this
     */
    public function clip($width, $height)
    {
        $ratio = $width / $height;
        $image_width = imagesx($this->image);
        $image_height = imagesy($this->image);

        if ($image_width / $image_height > $ratio) {
            $src_w = $image_height * $ratio;
            $src_h = $image_height;
            $src_x = ($image_width - $src_w) / 2;
            $src_y = 0;
        } else {
            $src_w = $image_width;
            $src_h = $image_width / $ratio;
            $src_x = 0;
            $src_y = ($image_height - $src_h) / 2;
        }

        $dst_image = imagecreatetruecolor($width, $height);
        $bg_color = imagecolorallocate($dst_image, $this->bgColor[0], $this->bgColor[1], $this->bgColor[2]);
        imagefill($dst_image, 0, 0, $bg_color);
        imagecopyresampled($dst_image, $this->image, 0, 0, $src_x, $src_y, $width, $height, $src_w, $src_h);
        imagedestroy($this->image);
        $this->image = $dst_image;
        return $this;
    }

    /**
     * 图像合并
     * @param $image
     * @param int $position
     * @return $this
     */
    function marge($image, $position = 9)
    {
        if (!is_file($image)) {
            return $this;
        }

        $src_info = getimagesize($image);
        $src_w = $src_info[0];
        $src_h = $src_info[1];
        $src_image = $this->create($image, $src_info[2]);

        $dst_w = imagesx($this->image);
        $dst_h = imagesy($this->image);

        //如果背景图小于图层则返回
        if ($dst_w < $src_w || $dst_h < $src_h) {
            return $this;
        }

        //图层定位
        switch ($position) {
            case 1: //顶部居左
                $dst_x = 0;
                $dst_y = 0;
                break;
            case 2: //顶部居中
                $dst_x = ($dst_w - $src_w) / 2;
                $dst_y = 0;
                break;
            case 3: //顶部居右
                $dst_x = $dst_w - $src_w;
                $dst_y = 0;
                break;
            case 4: //中部居左
                $dst_x = 0;
                $dst_y = ($dst_h - $src_h) / 2;
                break;
            case 5: //正中
                $dst_x = ($dst_w - $src_w) / 2;
                $dst_y = ($dst_h - $src_h) / 2;
                break;
            case 6: //中部居右
                $dst_x = $dst_w - $src_w;
                $dst_y = ($dst_h - $src_h) / 2;
                break;
            case 7: //底部居左
                $dst_x = 0;
                $dst_y = $dst_h - $src_h;
                break;
            case 8: //底部居中
                $dst_x = ($dst_w - $src_w) / 2;
                $dst_y = $dst_h - $src_h;
                break;
            case 9: //底部居右
                $dst_x = $dst_w - $src_w;
                $dst_y = $dst_h - $src_h;
                break;
            case 0: //随机
            default:
                $dst_x = rand(0, ($dst_w - $src_w));
                $dst_y = rand(0, ($dst_h - $src_h));
                break;
        }

        //合并
        imagecopy($this->image, $src_image, $dst_x, $dst_y, 0, 0, $src_w, $src_h);
        return $this;
    }

    /**
     * 创建image资源
     * @param $image
     * @param $type
     * @return resource
     */
    private function create($image, $type)
    {
        $resource = false;
        switch ($type) {
            case IMAGETYPE_GIF:
                $resource = imagecreatefromgif($image);
                break;
            case IMAGETYPE_JPEG:
                $resource = imagecreatefromjpeg($image);
                break;
            case IMAGETYPE_PNG:
                $resource = imagecreatefrompng($image);
                break;
        }
        return $resource;
    }

    /**
     * 通过添加后缀的方式给图像重命名
     * @param $image
     * @param $suffix
     * @return string
     */
    static function rename($image, $suffix)
    {
        $info = pathinfo($image);
        return $info['dirname'] . '/' . $info['filename'] . $suffix . '.' . $info['extension'];
    }

    /**
     * 十六进制的颜转换为rgb数组的方式表示
     * @param $colour
     * @return array|bool
     */
    static function hex2rgb($colour)
    {
        if ($colour [0] == '#') {
            $colour = substr($colour, 1);
        }
        if (strlen($colour) == 6) {
            list ($r, $g, $b) = [$colour [0] . $colour [1], $colour [2] . $colour [3], $colour [4] . $colour [5]];
        } elseif (strlen($colour) == 3) {
            list ($r, $g, $b) = [$colour [0] . $colour [0], $colour [1] . $colour [1], $colour [2] . $colour [2]];
        } else {
            return false;
        }
        return [hexdec($r), hexdec($g), hexdec($b)];
    }

}
<?php
/* Home 模块配置文件 */
return [
    'URL_ROUTER_ON' => 1, //路由开关

    //路由映射
    'URL_ROUTE_MAP' => [
        'aboutus' => 'page-index-1',
        'contactus' => 'page-index-2',
    ],

    //路由规则
    /*'URL_ROUTE_RULES' => [
        '/^good(.*)$-' => 'product$1',
    ],*/

    //路由反转规则
    /*'URL_ROUTE_FLIP_RULES' => [
        '/^product(.*)$-' => 'good$1',
    ],*/
];
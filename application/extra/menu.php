<?php

/**
 * @author     lxj
 * @date       2018-04-20 02:40:11
 * @filename   menu
 */
use \think\Url;

return [
    0 => [
        'title'   => '首页',
        'url'     => '/admin/index',
        'submenu' => [],
    ],
    1 => [
        'title'   => '短信通知',
        'url'     => '/admin/index',
        'submenu' => [
            0 => [
                'title' => '发送短信',
                'url'   => Url::build('admin/sendmsg_show/sendShow'),
            ],
            1 => [
                'title' => '查看已发送',
                'url'   => Url::build('admin/sendmsg_show/historyShow'),
            ],
        ],
    ],
//    2 => [
//        'title'   => '系统',
//        'url'     => 'javascript:;',
//        'submenu' => [
//            0 => [
//                'title' => '用户管理',
//                'url'   => Url::build('admin/system/user'),
//            ],
//            1 => [
//                'title' => '角色管理',
//                'url'   => Url::build('admin/system/role'),
//            ],
//            2 => [
//                'title' => '权限管理',
//                'url'   => Url::build('admin/system/power'),
//            ],
//            3 => [
//                'title' => '客户管理',
//                'url'   => Url::build('admin/system/power'),
//            ],
//            4 => [
//                'title' => '车辆管理',
//                'url'   => Url::build('admin/system/power'),
//            ],
//        ]
//    ],
//    3 => [
//        'title'   => '发货',
//        'url'     => 'javascript:;',
//        'submenu' => [
//            0 => [
//                'title' => '义乌发货',
//                'url'   => Url::build('admin/postgoods/index', 'start=yw'),
//            ],
//            1 => [
//                'title' => '上海发货',
//                'url'   => Url::build('admin/postgoods/index', 'start=sh'),
//            ],
//            2 => [
//                'title' => '永康发货',
//                'url'   => Url::build('admin/postgoods/index', 'start=yk'),
//            ],
//        ]
//    ],
//    4 => [
//        'title'   => '发车',
//        'url'     => 'javascript:;',
//        'submenu' => [
//            0 => [
//                'title' => '义乌发车',
//                'url'   => Url::build('admin/postcar/index', 'start=yw'),
//            ],
//            1 => [
//                'title' => '上海发车',
//                'url'   => Url::build('admin/postcar/index', 'start=sh'),
//            ],
//            2 => [
//                'title' => '永康发车',
//                'url'   => Url::build('admin/postcar/index', 'start=yk'),
//            ],
//        ]
//    ],
    5 => [
        'title'   => '订单',
        'url'     => 'javascript:;',
        'submenu' => [
            0 => [
                'title' => '添加订单',
                'url'   => Url::build('admin/getgoods/index', 'local=yw'),
            ],
            1 => [
                'title' => '未支付订单',
                'url'   => Url::build('admin/getgoods/index', 'local=sh'),
            ],
            2 => [
                'title' => '已支付订单',
                'url'   => Url::build('admin/getgoods/index', 'local=yk'),
            ],
        ]
    ],
    6 => [
        'title'   => '统计',
        'url'     => 'javascript:;',
        'submenu' => [
            0 => [
                'title' => '订单统计',
                'url'   => Url::build('admin/system/user'),
            ],
            1 => [
                'title' => '客户统计',
                'url'   => Url::build('admin/system/role'),
            ],
//            2 => [
//                'title' => '权限管理',
//                'url'   => Url::build('admin/system/power'),
//            ],
        ]
    ],
    
];

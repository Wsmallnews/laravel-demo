<?php

return [
    /*
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => env('WECHAT_DEBUG', false),

    /*
     * 使用 Laravel 的缓存系统
     */
    'use_laravel_cache' => true,

    /*
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'app_id'  => env('WECHAT_APPID', 'wxaf7cb4289e79322a'),         // AppID
    'secret'  => env('WECHAT_SECRET', 'bc47fdde1b16eb12517eb80acb7f2759'),     // AppSecret
    'token'   => env('WECHAT_TOKEN', 'wA1AdkxQ6ci772bQX7AbY4AYi4PO7496'),          // Token
    'aes_key' => env('WECHAT_AES_KEY', 'jrlS6rdB7wV7gveRfZf44XaSsdzemLAgF6ZSA3LwB76'),                    // EncodingAESKey


    'payment' => [
        'merchant_id'        => '1460116002',
        'key'                => 'r89ZM8ubLdd8sd3L998Imm2up3Mp8SHp',
        'cert_path'          => '/www/web/smallcode/public_html/storage/app/cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
        'key_path'           => '/www/web/smallcode/public_html/storage/app/cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
        'notify_url'         => "",       // 你也可以在下单时单独设置来想覆盖它
    ],
    /**
     * 开放平台第三方平台配置信息
     */
    // 'open_platform' => [
    //     'app_id'  => env('WECHAT_OPEN_PLATFORM_APPID', ''),
    //     'secret'  => env('WECHAT_OPEN_PLATFORM_SECRET', ''),
    //     'token'   => env('WECHAT_OPEN_PLATFORM_TOKEN', ''),
    //     'aes_key' => env('WECHAT_OPEN_PLATFORM_AES_KEY', ''),
    // ],

    /**
     * 小程序配置信息
     */
    // 'mini_program' => [
    //     'app_id'  => env('WECHAT_MINI_PROGRAM_APPID', ''),
    //     'secret'  => env('WECHAT_MINI_PROGRAM_SECRET', ''),
    //     'token'   => env('WECHAT_MINI_PROGRAM_TOKEN', ''),
    //     'aes_key' => env('WECHAT_MINI_PROGRAM_AES_KEY', ''),
    // ],

    /**
     * 路由配置
     */
    'route' => [
        'enabled' => false,         // 是否开启路由
        'attributes' => [           // 路由 group 参数
            'prefix' => null,
            'middleware' => null,
            'as' => 'easywechat::',
        ],
        'open_platform_serve_url' => 'open-platform-serve', // 开放平台服务URL
    ],

    /*
     * 日志配置
     *
     * level: 日志级别，可选为：
     *                 debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level' => env('WECHAT_LOG_LEVEL', 'debug'),
        'file'  => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
    ],

    /*
     * OAuth 配置
     *
     * only_wechat_browser: 只在微信浏览器跳转
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
     */
    'oauth' => [
        'only_wechat_browser' => true,
        'scopes'   => ['snsapi_userinfo'],
        'callback' => env('WECHAT_OAUTH_CALLBACK', '/examples/oauth_callback.php'),
    ],

    /*
     * 微信支付
     */
    // 'payment' => [
    //     'merchant_id'        => env('WECHAT_PAYMENT_MERCHANT_ID', 'your-mch-id'),
    //     'key'                => env('WECHAT_PAYMENT_KEY', 'key-for-signature'),
    //     'cert_path'          => env('WECHAT_PAYMENT_CERT_PATH', 'path/to/your/cert.pem'), // XXX: 绝对路径！！！！
    //     'key_path'           => env('WECHAT_PAYMENT_KEY_PATH', 'path/to/your/key'),      // XXX: 绝对路径！！！！
    //     // 'device_info'     => env('WECHAT_PAYMENT_DEVICE_INFO', ''),
    //     // 'sub_app_id'      => env('WECHAT_PAYMENT_SUB_APP_ID', ''),
    //     // 'sub_merchant_id' => env('WECHAT_PAYMENT_SUB_MERCHANT_ID', ''),
    //     // ...
    // ],

    /*
     * 开发模式下的免授权模拟授权用户资料
     *
     * 当 enable_mock 为 true 则会启用模拟微信授权，用于开发时使用，开发完成请删除或者改为 false 即可
     */
    'enable_mock' => env('WECHAT_ENABLE_MOCK', false),
    'mock_user' => [
        'id' => 16,
        'openid' => 'oy3YLxGqiBI07rcfGVIqLLCrMrX0',
        // 以下字段为 scope 为 snsapi_userinfo 时需要
        'name' => '小新',
        'parent_id' => '0',
        'phone' => '15737921560',
        'is_top' => 1,
        'avatar' => 'http://wx.qlogo.cn/mmopen/IArmXxGwPsKmLSvLicPUpk9MQxFyVUsXASQH9ia7GKs2L9vbkzbRJm0ecLLPPKXgmzvDvuPRre1NHWZPusuteG2PZTV5UYRpZE/0',
    ],

    'jsApiList' => [
        'checkJsApi', 'onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ',
        'onMenuShareWeibo', 'chooseImage', 'previewImage', 'uploadImage', 'downloadImage',
        'getNetworkType', 'openLocation', 'getLocation', 'editAddress', 'chooseWXPay',
        'getLatestAddress', 'openCard', 'scanQRCode'
    ],

    /**
     * cus—-menu
     */
    'cus_menu' => [
        [
            "name"       => "微风尚",
            "sub_button" => [
                [
                    "type" => "view",
                    "name" => "微风尚小程序",
                    "url"  => "http://e.eqxiu.com/s/xUVoZIvo"
                ],
                [
                    "type" => "view",
                    "name" => "小程序的一天",
                    "url"  => "http://a.eqxiu.com/s/bfv5pJji?from=timeline&isappinstalled=0"
                ],
                [
                    "type" => "click",
                    "name" => "联系我们",
                    "key"  => "contract"
                ],
            ],
        ],
        [
            "name"       => "推广中心",
            "sub_button" => [
                [
                    "type" => "view",
                    "name" => "我的二维码",
                    "url"  => env('APP_URL', 'http://weixin1.vfscms.com')."/users/qrcode"
                ],
                [
                    "type" => "click",
                    "name" => "生成海报",
                    "key"  => "create_poster"
                ],
            ],
        ],
        [
            "name"       => "商城中心",
            "sub_button" => [
                [
                    "type" => "view",
                    "name" => "商城首页",
                    "url"  => env('APP_URL', 'http://weixin1.vfscms.com')
                ],
                [
                    "type" => "view",
                    "name" => "个人中心",
                    "url"  => env('APP_URL', 'http://weixin1.vfscms.com')."/users/personal"
                ]
            ],
        ],
    ],

    /**
     * 模版消息，local 为测试号模板，production 为正式公众号使用
     * 模板中 data 为简写方式，与文档不同 请注意
     */
    'template_msg' => [
        'local' => [        // 本地测试号
            'user_in' => [
                'touser' => '',
                'template_id' => '7IOlqDsML9hKbrBnU_AJ6JRA92rRmnbLjtZWMpi_3HI',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '您有新的推广员加入',
                    'keyword1' => '',
                    'keyword2' => '',
                    'remark' => '赶快去我的团队看看吧'
                ]
            ],
            'buy_ok' => [
                'touser' => '',
                'template_id' => 'Sdi2CAGi1OpOl6iJpMajWFGmTeqxAKsB8gRUMIBSpHQ',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '您好，您以购买成功购买商品为：',
                    'keyword1' => '',       // 付款金额
                    'keyword2' => '',       // 交易单号
                    'remark' => '赶快去我的订单看看吧'
                ]
            ],
            'wallet_add' => [
                'touser' => '',
                'template_id' => 'VcopetNsAsnX1blHK3ol6vYsxdsbci9LrKaINwO16bQ',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '有新零钱进账',
                    'keyword1' => '',       // 收入增加
                    'keyword2' => '',       // 时间
                    'remark' => '赶快去我的钱包看看吧'
                ]
            ],
            'wallet_apply_result' => [
                'touser' => '',
                'template_id' => 'l2bkGl838D_XhEnkaD2FKAdeXHHf_PQ57R91T3k9cGA',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '账户最新提现信息',
                    'keyword1' => '',       // 提现状态
                    'keyword2' => '',       // 提现金额
                    'keyword3' => '',       // 提现时间
                    'keyword4' => '',       // 到账时间
                    'remark' => '赶快去我的钱包看看吧'
                ]
            ],
             'wallet_apply_add' => [
                'touser' => '',
                'template_id' => 'sLIQCuXx84b_NO4xEkdFE8dI6P8uKRIl9ANZQWokKbs',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => 'successful',
                    'keyword1' => '',       // 提现金额
                    'keyword2' => '',        // 申请时间
                    'remark' => 'please waiting!'
                ]
            ],
            // 'wallet_apply_add' => [
            //     'touser' => '',
            //     'template_id' => 'sLIQCuXx84b_NO4xEkdFE8dI6P8uKRIl9ANZQWokKbs',
            //     // 'url' => route('users.team'),
            //     'data' => [
            //         'first' => '提现申请提交成功',
            //         'keyword1' => '',       // 提现金额
            //         'keyword2' => '',        // 申请时间
            //         'remark' => '请耐心等待后台管理员审核'
            //     ]
            // ],
            'auto_up' => [
                'touser' => '',
                'template_id' => 'YYYf3ug771UDE4X5cuc4VLtxBYV5C7_Q77qy6ohKLsk',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '恭喜您的等级已升级',
                    'keyword1' => '',       // 用户昵称
                    'keyword2' => '',       // 最新等级
                    'keyword3' => '',       // 生效时间
                    'remark' => '赶快去个人中心看看吧'
                ]
            ],
        ],
        'production' => [   // 正式公众号
            'user_in' => [
                'touser' => '',
                'template_id' => 'PT3eFzpsBRxI2VRGkzhuDL81BIOo50o675yTLwgKats',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '您有新的推广员加入',
                    'keyword1' => '',
                    'keyword2' => '',
                    'remark' => '赶快去我的团队看看吧'
                ]
            ],
            'buy_ok' => [
                'touser' => '',
                'template_id' => 'Sdi2CAGi1OpOl6iJpMajWFGmTeqxAKsB8gRUMIBSpHQ',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '您好，您以购买成功购买商品为：',
                    'keyword1' => '',       // 付款金额
                    'keyword2' => '',       // 交易单号
                    'remark' => '赶快去我的订单看看吧'
                ]
            ],
            'wallet_add' => [
                'touser' => '',
                'template_id' => 'VcopetNsAsnX1blHK3ol6vYsxdsbci9LrKaINwO16bQ',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '有新零钱进账',
                    'keyword1' => '',       // 收入增加
                    'keyword2' => '',       // 时间
                    'remark' => '赶快去我的钱包看看吧'
                ]
            ],
            'wallet_apply_result' => [
                'touser' => '',
                'template_id' => 'l2bkGl838D_XhEnkaD2FKAdeXHHf_PQ57R91T3k9cGA',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '账户最新提现信息',
                    'keyword1' => '',       // 提现状态
                    'keyword2' => '',       // 提现金额
                    'keyword3' => '',       // 提现时间
                    'keyword4' => '',       // 到账时间
                    'remark' => '赶快去我的钱包看看吧'
                ]
            ],
            'wallet_apply_add' => [
                'touser' => '',
                'template_id' => 'sLIQCuXx84b_NO4xEkdFE8dI6P8uKRIl9ANZQWokKbs',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => 'successful',
                    'keyword1' => '',       // 提现金额
                    'keyword2' => '',        // 申请时间
                    'remark' => 'please waiting'
                ]
            ],
            // 'wallet_apply_add' => [
            //     'touser' => '',
            //     'template_id' => 'sLIQCuXx84b_NO4xEkdFE8dI6P8uKRIl9ANZQWokKbs',
            //     // 'url' => route('users.team'),
            //     'data' => [
            //         'first' => '提现申请提交成功',
            //         'keyword1' => '',       // 提现金额
            //         'keyword2' => '',        // 申请时间
            //         'remark' => '请耐心等待后台管理员审核'
            //     ]
            // ],
            'auto_up' => [
                'touser' => '',
                'template_id' => 'YYYf3ug771UDE4X5cuc4VLtxBYV5C7_Q77qy6ohKLsk',
                // 'url' => route('users.team'),
                'data' => [
                    'first' => '恭喜您的等级已升级',
                    'keyword1' => '',       // 用户昵称
                    'keyword2' => '',       // 最新等级
                    'keyword3' => '',       // 生效时间
                    'remark' => '赶快去个人中心看看吧'
                ]
            ],
        ]
    ],
];

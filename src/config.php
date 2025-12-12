<?php


return [
    // 是否为调试模式
    'debug'         => env('NAT_DEBUG', false),
    // 内网穿透服务鉴权token
    'token'         => env('NAT_TOKEN', '%s'),
    // 服务端channel通信服务地址
    'channel_host'  => env('NAT_CHANNEL_HOST', 'nat.gdmon.com'),
    // 服务端channel通信服务端口
    'channel_port'  => env('NAT_CHANNEL_PORT', 2209),
    // 本地内网穿透地址
    'proxy_host'    => env('NAT_PROXY_HOST', '127.0.0.1'),
    // 本地内网穿透端口，映射本地80端口，通过配置host和Nginx多域名，实现完全的内网透传
    'proxy_port'    => env('NAT_PROXY_PORT', 80),
    // 事件标识名称
    'event'         => [
        // 客户端注册事件标识
        'client_register'       => 'client_register',
        // 客户端确认注册事件标识
        'server_register'       => 'server_register',
        // 客户端代理消息事件标识
        'client_proxy_msg'      => 'client_proxy_msg',
        // 客户端代理链接断开事件标识
        'client_proxy_close'    => 'client_proxy_close',
        // 外网链接事件标识
        'out_net_connect'       => 'out_net_connect',
        // 外网请求消息标识
        'out_net_msg'           => 'out_net_msg',
        // 外网链接断开标识
        'out_net_close'         => 'out_net_close'
    ],
    // 服务器穿透服务配置
    'server'    => [
        // 监听协议端口，需要对外开放，外网访问对应的IP端口即可，tcp协议即支持http、https、tcp三种穿透方式
        // 也可以监听本地IP，通过nginx代理，防止被外部访问
        'listen'    => 'tcp://127.0.0.1:' . env('NAT_SERVER_PORT', 8087),
        // 进程数，代理服务端一般单个进程即可
        'count'     => env('NAT_SERVER_COUNT', 1),
    ]
];

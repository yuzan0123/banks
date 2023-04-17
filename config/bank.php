<?php

return [

    'ccb' => [
        // 商户号
        'pl_mid' => env('CCB_PLMID',''),
        // 服务方页面链接地址，一般为中间页面，用于对跳转参数的解密验签处理及二次跳转
        'url' => env('CCB_URL',''),
        // 公钥文件
        'public_key' => env('CCB_PUB_KEY',''),
        // 私钥文件
        'private_key' => env('CCB_PRI_KEY',''),

    ]

];

<?php

return [

    'ccb' => [
        // 商户号
        'pl_mid' => env('CCB_PLMID',''),
        // 接口地址
        'url' => env('CCB_URL',''),
        // 公钥文件
        'public_key_path' => env('CCB_PUB_KEY_PATH',''),
        // 私钥文件
        'private_key_path' => env('CCB_PRI_KEY_PATH',''),

    ]

];

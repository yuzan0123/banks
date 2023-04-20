<?php

return [

    'ccb' => [
        // 商户号
        'pl_mid' => env('CCB_PLMID',''),
        // url
        'url' => env('CCB_URL',''),
        // 服务方固定编号
        'svcid' => env('CCB_SVCID',''),
        // 公钥文件
        'public_key' => env('CCB_PUB_KEY',''),
        // 私钥文件
        'private_key' => env('CCB_PRI_KEY',''),

    ]

];

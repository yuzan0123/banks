<?php

return [

    'ccb' => [
        // 外部平台商户号
        'pl_mid' => env('CCB_PLMID',''),
        // 分行ID
        'branch_id' => env('CCB_BRANCHID',''),
        // 商户19位终端号
        'postid_19' => env('CCB_POSTID19',''),
        // 门店商户号
        'store_id' => env('CCB_STORE_ID',''),
        // 商户代码
        'mid' => env('CCB_MID',''),
        // 柜台代码
        'post_id' => env('CCB_POSID',''),
        // 建行生活后端Url
        'url' => env('CCB_URL',''),
        // 订单详情跳转url
        'web_order_url' => env('CCB_WEB_ORDER_URL',''),
        // 服务方编号
        'svcid' => env('CCB_SVCID',''),
        // 商户公钥
        'enc_pub' => env('CCB_ENCPUB',''),
        // 公钥文件
        'public_key' => env('CCB_PUB_KEY_PATH'),
        // 私钥文件
        'private_key' => env('CCB_PRI_KEY_PATH'),

    ]

];

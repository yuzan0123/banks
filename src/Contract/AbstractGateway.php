<?php

namespace Xyu\Banks\Contract;

use Xyu\Banks\BankApp;
use Xyu\Banks\Traits\HttpRequests;

abstract class AbstractGateway
{

    use HttpRequests {
        request as performRequest;
    }

    /**
     * 接口索引
     * @var string
     */
    protected $relativeUrl;

    /**
     * 服务方编号
     * @var string
     */
    protected $svcid;

    /**
     * @var BankApp
     */
    protected $app;

    public function __construct(BankApp $app)
    {
        $this->app = $app;
    }

    /**
     * @param array $body
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Throwable
     */
    public function request(array $body)
    {
        return $this->performRequest([
            'cnt' => $this->app->decrypt->publicEncrypt(json_encode($this->struct($body))),
            'mac' => md5(http_build_query($body)),
            'svcid' => $this->svcid
        ]);
    }


    public function struct(array $body): array
    {
        return [
            'CLD_HEADER' => [
                'CLD_TX_CHNL' => $this->svcid, // 服务方编号
                'CLD_TX_TIME' => date('YmdHis'), // 通讯时间
                'CLD_TX_CODE' => $this->relativeUrl, // 接口索引
                'CLD_TX_SEQ' => $this->app->getRequestId() // 全局事件流水号
            ],
            'CLD_BODY' => $body
        ];
    }


    public function getMecTime(): float
    {
        list($mec, $sec) = explode(' ', microtime());
        return  (float)sprintf('%.0f', (floatval($mec) + floatval($sec)) * 1000);
    }

}
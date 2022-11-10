<?php

namespace Xyu\Banks\Ccb;

use Xyu\Banks\Contract\AbstractGateway;

/**
 * LifeAccount
 * 建设银行生活场景相关接口
 */
class LifeAccount extends AbstractGateway
{
    /**
     * 建行生活url跳转
     * @param array $params
     * @return string
     * @throws \Throwable
     */
    public function occJumpUrl(array $params): string
    {
        try {
            $ccbParamSJ = [
                'BGCOLOR' => $params['bgcolor'] ?? null,
                'PLATFLOWNO' => $params['platflowno'],
                'TIMESTAMP' => $this->getMecTime(),
                'USERID' => $params['userId'],
                'MOBILE' => $params['mobile'],
                'CITYID' => $params['cityId'],
                'USERCITYID' => $params['userCityId'],
                'LGT' => $params['lgt'],
                'LTT' => $params['ltt'],
                'APPID' => $params['appid'] ?? null,
                'OPENID' => $params['openid'] ?? null,
                'ORDERID' => $params['orderId'],
                'TOKEN' => $params['token'] ?? null,
            ];
            return $this->app->getUrl() . '?' . http_build_query([
                    'platform' => $params['platform'] ?? 'ccblife', // 默认建行生活平台标识符
                    'channel' => $params['channel'] ?? 'mbs', // channel=mbs表示在中国建设银行App运行，如无此参数则默认为在建行生活App运行
                    'ccbParamSJ' => $this->app->decrypt->publicEncrypt(json_encode($ccbParamSJ)),
                    'CITYID' => $params['cityId'],
                    'USERCITYID' => $params['userCityId']
                ]);
        }catch (\Throwable $e) {
            throw $e;
        }
    }


    public function occLoginValidate(array $params)
    {
        try {
            $this->relativeUrl = 'svc_occLoginValidate';
            $this->svcid = '';

            $body = [
                'USERID' => $params['userId'],
                'PLAT_FLOW_NO' => $params['flowNo'], // 登陆校验流水号
            ];
            return $this->request($body);
        }catch (\Throwable $e) {
            throw $e;
        }
    }

}
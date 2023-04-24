<?php

namespace Xyu\Banks\Ccb;

use Xyu\Banks\Contract\AbstractGateway;

/**
 * Order
 * 建设银行生活场景支付相关接口
 */
class Order extends AbstractGateway
{
    /**
     * 前端访问建行生活收银台的参数
     * @param array $params
     * @return array
     * @throws \Throwable
     */
    public function orderPay(array $params)
    {
        try {
            $mac = $body = [
                'MERCHANTID' => $this->app->getMid(),
                'POSID' => $this->app->getPostId(),
                'BRANCHID' => $this->app->getBranchId(),
                'POSID19' => $this->app->getPostId19(),
                'PLATMCTID' => $this->app->getPlMid(),
                'ORDERID' => $params['orderId'],
                'PAYMENT' => $params['price'],
                'CURCODE' => '01',
                'TXCODE' => '520100',
                'REMARK1' => $params['remark1'] ?? 'ccbpay',
                'REMARK2' => $this->app->getSvcid(), // 服务方编号
                'TYPE' => '1',
                'GATEWAY' => '0',
                'CLIENTIP' => $params['clientIp'] ?? '',
                'REGINFO' => $params['reginfo'] ?? '',
                'PROINFO' => $params['proinfo'] ?? '',
                'REFERER' => $params['referer'] ?? '',
                'INSTALLNUM' => $params['installNum'] ?? '',
                'THIRDAPPINFO' => $params['thirdAppInfo'],
                'TIMEOUT' => $params['timeout'] ?? date('YmdHis', time() + 1800),
                'USERID' => $params['userId'] ?? '',
                'TOKEN' => $params['token'] ?? '',
                'PAYSUCCESSURL' => $params['payUrl'] ?? '',
                'PAYBITMAP' => $params['bitmap'] ?? '',
                'POINTAVYID' => $params['pointAvyid'] ?? '',
                'DCEPDEPACCNO' => $params['dcepdep'] ?? '',
                'COUPONAVYID' => $params['coupon'] ?? '',
                'ONLY_CREDIT_PAY_FLAG' => $params['onlyPayFlag'] ?? '',
                'FIXEDPOINTVAL' => $params['fixedpoin'] ?? '',
                'EXTENDPARAMS' => $params['extend'] ?? '',
                'PLATFORMPUB' => $this->app->getPublicKey(), // 服务方公钥
                'MAC' => '',
                'PLATFORMID' => $this->app->getSvcid(), // 服务方编号
                'ENCPUB' => $this->app->getEncPub(), // 商户公钥密文
                'SCNID' => $params['scanId'] ?? '',
                'SCN_PLTFRM_ID' => $params['scnPltId'] ?? '',
            ];

            /* body 参数定义*/
            if(isset($body['MERCHANTID']) && ! $body['MERCHANTID']) unset($body['MERCHANTID']);
            if(isset($body['POSID']) && ! $body['POSID']) unset($body['POSID']);
            if(isset($body['POSID19']) && ! $body['POSID19']) unset($body['POSID19']);
            if(isset($body['INSTALLNUM']) && ! $body['INSTALLNUM']) unset($body['INSTALLNUM']);
            if(isset($body['TOKEN']) && ! $body['TOKEN']) unset($body['TOKEN']);
            if(isset($body['PAYSUCCESSURL']) && ! $body['PAYSUCCESSURL']) unset($body['PAYSUCCESSURL']);
            if(isset($body['PAYBITMAP']) && ! $body['PAYBITMAP']) unset($body['PAYBITMAP']);
            if(isset($body['POINTAVYID']) && ! $body['POINTAVYID']) unset($body['POINTAVYID']);
            if(isset($body['DCEPDEPACCNO']) && ! $body['DCEPDEPACCNO']) unset($body['DCEPDEPACCNO']);
            if(isset($body['COUPONAVYID']) && ! $body['COUPONAVYID']) unset($body['COUPONAVYID']);
            if(isset($body['ONLY_CREDIT_PAY_FLAG']) && ! $body['ONLY_CREDIT_PAY_FLAG']) unset($body['ONLY_CREDIT_PAY_FLAG']);
            if(isset($body['FIXEDPOINTVAL']) && ! $body['FIXEDPOINTVAL']) unset($body['FIXEDPOINTVAL']);
            if(isset($body['EXTENDPARAMS']) && ! $body['EXTENDPARAMS']) unset($body['EXTENDPARAMS']);
            if(isset($body['SCNID']) && ! $body['SCNID']) unset($body['SCNID']);
            if(isset($body['SCN_PLTFRM_ID']) && ! $body['SCN_PLTFRM_ID']) unset($body['SCN_PLTFRM_ID']);
            if(isset($body['BRANCHID']) && ! $body['BRANCHID']) unset($body['BRANCHID']);
            if(isset($body['PLATMCTID']) && ! $body['PLATMCTID']) unset($body['PLATMCTID']);
            if(isset($body['PLATFORMPUB']) && ! $body['PLATFORMPUB']) unset($body['PLATFORMPUB']);
            if(isset($body['ENCPUB']) && ! $body['ENCPUB']) unset($body['ENCPUB']);
            /* body */

            /* mac 参数定义*/
            unset($mac['POSID19'],$mac['PLATFORMID'],$mac['ENCPUB'],$mac['SCNID'],$mac['SCN_PLTFRM_ID'],$mac['MAC']);
            if(! $mac['PLATMCTID']) unset($mac['PLATMCTID']);
            if(! $mac['TIMEOUT']) unset($mac['TIMEOUT']);
            if(! $mac['USERID']) unset($mac['USERID']);
            if(! $mac['TOKEN']) unset($mac['TOKEN']);
            if(! $mac['PAYSUCCESSURL']) unset($mac['PAYSUCCESSURL']);
            if(! $mac['PAYBITMAP']) unset($mac['PAYBITMAP']);
            if(! $mac['INSTALLNUM']) unset($mac['INSTALLNUM']);
            if(! $mac['POINTAVYID']) unset($mac['POINTAVYID']);
            if(! $mac['DCEPDEPACCNO']) unset($mac['DCEPDEPACCNO']);
            if(! $mac['COUPONAVYID']) unset($mac['COUPONAVYID']);
            if(! $mac['ONLY_CREDIT_PAY_FLAG']) unset($mac['ONLY_CREDIT_PAY_FLAG']);
            if(! $mac['FIXEDPOINTVAL']) unset($mac['FIXEDPOINTVAL']);
            if(! $mac['EXTENDPARAMS']) unset($mac['EXTENDPARAMS']);
//            $mac = strtoupper(md5(http_build_query($mac)));
            $mac = md5(http_build_query($mac));
            /* mac */

            $body['MAC'] = $mac;

//            $cnt = $this->app->decrypt->publicEncrypt(json_encode($this->struct($body)));

            return [
                'txcode' => 'A3341OM01', // 收银固定交易码
                'svcid' => $this->app->getSvcid(),
                'cnt' => $body,
                'mac' => $mac,
            ];

        }catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * 推送建行生活订单
     * @param array $params
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Throwable
     */
    public function orderCreate(array $params)
    {
        try {
            $body = [
                'USER_ID' => $params['userId'],
                'ORDER_ID' => $params['orderId'],
                'ORDER_DT' => $params['orderDate'] ?? date('YmdHis'),
                'TOTAL_AMT' => $params['price'],
                'PAY_AMT' => $params['payPrice'] ?? '',
                'DISCOUNT_AMT' => $params['discountPrice'] ?? '',
                'DISCOUNT_AMT_DESC' => $params['discountDesc'] ?? '',
                'ORDER_STATUS' => $params['orderStatus'] ?? 0,
                'REFUND_STATUS' => $params['refundStatus'] ?? 0,
                'INV_DT' => $params['timeout'] ?? date('YmdHis', time() + 1800),
                'MCT_NM' => $params['mctName'],
                'CUS_ORDER_URL' => $params['orderUrl'] ?? '',
                'OCC_MCT_LOGO_URL' => $params['logoOrderUrl'] ?? '',
                'PAY_FLOW_ID' => $params['payFlowId'] ?? '',
                'PAY_USER_ID' => $params['payUserId'] ?? '',
                'TOTAL_REFUND_AMT' => $params['totalRefundPrice'] ?? '',
                'PREFTL_MRCH_ID' => '',
                'PAY_MRCH_ID' => '',
                'PLAT_MCT_ID' => $this->app->getPlMid(),
                'OCCCOUP_DISCOUNT_AMT' => '',
                'OCCCOUP_DISCOUNT_AMT_DESC' => '',
                'SPECIAL_STATUS' => '',
                'PLAT_ORDER_TYPE' => '',
            ];

            $this->relativeUrl = 'A3341O031';

            return $this->request($body);
        }catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * 批量推送建行生活订单
     * @param array $params
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Throwable
     */
    public function orderCreateBatch(array $params)
    {
        try {
            $body = [];
            foreach ($params as $val) {
                $body[] = [
                    'USER_ID' => $val['userId'],
                    'ORDER_ID' => $val['orderId'],
                    'ORDER_DT' => $val['orderDate'] ?? date('YmdHis'),
                    'TOTAL_AMT' => $val['price'],
                    'PAY_AMT' => $val['payPrice'] ?? '',
                    'DISCOUNT_AMT' => $val['discountPrice'] ?? '',
                    'DISCOUNT_AMT_DESC' => $val['discountDesc'] ?? '',
                    'ORDER_STATUS' => $val['orderStatus'] ?? 0,
                    'REFUND_STATUS' => $val['refundStatus'] ?? 0,
                    'INV_DT' => $val['timeout'] ?? date('YmdHis', time() + 1800),
                    'MCT_NM' => $val['mctName'],
                    'CUS_ORDER_URL' => $val['orderUrl'] ?? '',
                    'OCC_MCT_LOGO_URL' => $val['logoOrderUrl'] ?? '',
                    'PAY_FLOW_ID' => $val['payFlowId'] ?? '',
                    'PAY_USER_ID' => $val['payUserId'] ?? '',
                    'TOTAL_REFUND_AMT' => $val['totalRefundPrice'] ?? '',
                    'PREFTL_MRCH_ID' => '',
                    'PAY_MRCH_ID' => '',
                    'PLAT_MCT_ID' => $this->app->getPlMid(),
                    'OCCCOUP_DISCOUNT_AMT' => '',
                    'OCCCOUP_DISCOUNT_AMT_DESC' => '',
                    'SPECIAL_STATUS' => '',
                ];
            }

            $this->relativeUrl = 'A3341O032';

            return $this->request([
                'ORDER_LIST' => $body
            ]);
        }catch (\Throwable $e) {
            throw $e;
        }
    }


    /**
     * 更新建行生活订单状态
     * @param array $params
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Throwable
     */
    public function orderUpdate(array $params)
    {
        try {
            $body = [
                'ORDER_ID' => $params['orderId'],
                'INFORM_ID' => $params['informId'] ?? 0,
                'PAY_STATUS' => $params['payStatus'] ?? 1,
                'REFUND_STATUS' => $params['refundStatus'] ?? 0,
                'PAY_AMT' => $params['price'],
                'DISCOUNT_AMT' => $params['discountPrice'] ?? '',
                'DISCOUNT_AMT_DESC' => $params['discountDesc'] ?? '',
                'CUS_ORDER_URL' => $params['orderUrl'] ?? '',
                'OCC_MCT_LOGO_URL' => $params['logoOrderUrl'] ?? '',
                'PAY_FLOW_ID' => $params['payFlowId'] ?? '',
                'PAY_USER_ID' => $params['payUserId'] ?? '',
                'TOTAL_REFUND_AMT' => $params['totalRefundPrice'] ?? '',
                'PREFTL_MRCH_ID' => '',
                'PAY_MRCH_ID' => $this->app->getPlMid(),
                'PLAT_MCT_ID' => '',
                'OCCCOUP_DISCOUNT_AMT' => '',
                'OCCCOUP_DISCOUNT_AMT_DESC' => '',
                'SPECIAL_STATUS' => '',
                'PLAT_ORDER_TYPE' => '',
            ];

            $this->relativeUrl = 'A3341O033';

            return $this->request($body);
        }catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * 批量更新建行生活订单状态
     * @param array $params
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Throwable
     */
    public function orderUpdateBatch(array $params)
    {
        try {
            $body = [];
            foreach ($params as $val) {
                $body[] = [
                    'ORDER_ID' => $val['orderId'],
                    'INFORM_ID' => $val['informId'] ?? 0,
                    'PAY_STATUS' => $val['payStatus'] ?? 1,
                    'REFUND_STATUS' => $val['refundStatus'] ?? 0,
                    'PAY_AMT' => $val['price'],
                    'DISCOUNT_AMT' => $val['discountPrice'] ?? '',
                    'DISCOUNT_AMT_DESC' => $val['discountDesc'] ?? '',
                    'CUS_ORDER_URL' => $val['orderUrl'] ?? '',
                    'OCC_MCT_LOGO_URL' => $val['logoOrderUrl'] ?? '',
                    'PAY_FLOW_ID' => $val['payFlowId'] ?? '',
                    'PAY_USER_ID' => $val['payUserId'] ?? '',
                    'TOTAL_REFUND_AMT' => $val['totalRefundPrice'] ?? '',
                    'PREFTL_MRCH_ID' => '',
                    'PAY_MRCH_ID' => $this->app->getPlMid(),
                    'PLAT_MCT_ID' => '',
                    'OCCCOUP_DISCOUNT_AMT' => '',
                    'OCCCOUP_DISCOUNT_AMT_DESC' => '',
                    'SPECIAL_STATUS' => '',
                ];
            }

            $this->relativeUrl = 'A3341O034';

            return $this->request([
                'ORDER_LIST' => $body
            ]);
        }catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * 查询建行生活订单
     * @param array $params
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Throwable
     */
    public function orderQuery(array $params)
    {
        try {
            $body = [
                'TX_TYPE' => $params['type'],
                'TXN_PRD_TPCD' => $params['protpcd'] ?? '06',
                'STDT_TM' => $params['startDate'],
                'EDDT_TM' => $params['endDate'],
                'ONLN_PY_TXN_ORDR_ID' => $params['orderId'] ?? '',
                'SCN_IDR' => $params['scnId'] ?? '',
                'PLAT_MCT_ID' => $this->app->getPlMid(),
                'CUSTOMERID' => '',
                'BRANCHID' => '',
                'POS_CODE' => '',
                'POS_ID' => '',
                'TXN_STATUS' => $params['orderStatus'],
                'MSGRP_JRNL_NO' => $params['jrnlNo'] ?? '',
                'PAGE' => $params['page'] ?? 1,
            ];

            $this->relativeUrl = 'A3341O035';

            return $this->request($body);
        }catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * 建行生活订单退款
     * @param array $params
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Throwable
     */
    public function orderRefund(array $params)
    {
        try {
            $body = [
                'PLAT_MCT_ID' => $this->app->getPlMid(),
                'CUSTOMERID' => '',
                'BRANCHID' => '',
                'MONEY' => $params['price'],
                'ORDER' => $params['orderId'],
                'STDT_TM' => $params['startDate'],
                'EDDT_TM' => $params['endDate'],
            ];

            $this->relativeUrl = 'A3341O036';

            return $this->request($body);
        }catch (\Throwable $e) {
            throw $e;
        }
    }
}
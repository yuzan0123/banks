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
                'USER_ORDERID' => $params['orderId'],
                'PAYMENT' => $params['price'],
                'CURCODE' => $params['curcode'] ?? '01',
                'TXCODE' => $params['txcode'] ?? '520100',
                'REMARK1' => $params['remark1'] ?? '',
                'REMARK2' => $this->app->getSvcid(), // 服务方编号
                'TYPE' => $params['type'] ?? '1',
                'GATEWAY' => $params['gateway'] ?? '0',
                'CLIENTIP' => $params['clientIp'] ?? '',
                'REGINFO' => $params['reginfo'] ?? '',
                'PROINFO' => $params['proinfo'] ?? '',
                'REFERER' => $params['referer'] ?? '',
                'INSTALLNUM' => $params['installNum'] ?? '',
                'THIRDAPPINFO' => $params['thirdAppInfo'] ?? 'comccbpay1234567890cloudmerchant',
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
                'MAC' => '', // 排序的加密参数
                'PLATFORMID' => $this->app->getSvcid(), // 服务方编号
                'ENCPUB' => $this->app->getEncPub(), // 商户公钥密文
                'SCNID' => $params['scanId'] ?? '',
                'SCN_PLTFRM_ID' => $params['scnPltId'] ?? '',
            ];

            /* body 参数定义*/
            if(isset($body['MERCHANTID']) && ! $body['MERCHANTID']) unset($body['MERCHANTID']);
            if(isset($body['POSID']) && ! $body['POSID']) unset($body['POSID']);
            if(isset($body['USERID']) && ! $body['USERID']) unset($body['USERID']);
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
            unset($body['PLATFORMPUB']); // 仅作为源串参加MD5摘要，不作为参数传递
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
            /* mac */

            return [
                'body' => $body,
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
                'ORDER_STATUS' => $params['orderStatus'] ?? '0',
                'REFUND_STATUS' => $params['refundStatus'] ?? '0',
                'INV_DT' => $params['timeout'] ?? date('YmdHis', time() + 1800),
                'MCT_NM' => $params['mctName'],
                'CUS_ORDER_URL' => $params['orderUrl'] ?? '',
                'OCC_MCT_LOGO_URL' => $params['logoOrderUrl'] ?? '',
                'PAY_FLOW_ID' => $params['payFlowId'] ?? $params['orderId'],
                'PAY_USER_ID' => $params['payUserId'] ?? '',
                'TOTAL_REFUND_AMT' => $params['totalRefundPrice'] ?? '',
                'PREFTL_MRCH_ID' => $this->app->getStoreId(),
                'PAY_MRCH_ID' => $this->app->getMid(),
                'PLAT_MCT_ID' => $this->app->getPlMid(),
                'OCCCOUP_DISCOUNT_AMT' => $params['occ_discount_amt'] ?? '',
                'OCCCOUP_DISCOUNT_AMT_DESC' => $params['occ_discount_amt_desc'] ?? '',
                'SPECIAL_STATUS' => $params['special_status'] ?? '',
                'PLAT_ORDER_TYPE' => $params['plat_order_type'] ?? '',
            ];

            $this->relativeUrl = '?txcode=A3341O031';

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
                    'ORDER_STATUS' => $val['orderStatus'] ?? '0',
                    'REFUND_STATUS' => $val['refundStatus'] ?? '0',
                    'INV_DT' => $val['timeout'] ?? date('YmdHis', time() + 1800),
                    'MCT_NM' => $val['mctName'],
                    'CUS_ORDER_URL' => $val['orderUrl'] ?? '',
                    'OCC_MCT_LOGO_URL' => $val['logoOrderUrl'] ?? '',
                    'PAY_FLOW_ID' => $val['payFlowId'] ?? $val['orderId'],
                    'PAY_USER_ID' => $val['payUserId'] ?? '',
                    'TOTAL_REFUND_AMT' => $val['totalRefundPrice'] ?? '',
                    'PREFTL_MRCH_ID' => $this->app->getStoreId(),
                    'PAY_MRCH_ID' => $this->app->getMid(),
                    'PLAT_MCT_ID' => $this->app->getPlMid(),
                    'OCCCOUP_DISCOUNT_AMT' => $val['occ_discount_amt'] ?? '',
                    'OCCCOUP_DISCOUNT_AMT_DESC' => $val['occ_discount_amt_desc'] ?? '',
                    'SPECIAL_STATUS' => $val['special_status'] ?? '',
                ];
            }

            $this->relativeUrl = '?txcode=A3341O032';

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
                'INFORM_ID' => $params['informId'] ?? '0',
                'PAY_STATUS' => $params['payStatus'] ?? '0',
                'REFUND_STATUS' => $params['refundStatus'] ?? '0',
                'PAY_AMT' => $params['price'] ?? '',
                'DISCOUNT_AMT' => $params['discountPrice'] ?? '',
                'DISCOUNT_AMT_DESC' => $params['discountDesc'] ?? '',
                'CUS_ORDER_URL' => $params['orderUrl'] ?? '',
                'OCC_MCT_LOGO_URL' => $params['logoOrderUrl'] ?? '',
                'PAY_FLOW_ID' => $params['payFlowId'] ?? $params['orderId'],
                'PAY_USER_ID' => $params['payUserId'] ?? '',
                'TOTAL_REFUND_AMT' => $params['totalRefundPrice'] ?? '',
                'PREFTL_MRCH_ID' => $this->app->getStoreId(),
                'PAY_MRCH_ID' => $this->app->getMid(),
                'PLAT_MCT_ID' => $this->app->getPlMid(),
                'OCCCOUP_DISCOUNT_AMT' => $params['occ_discount_amt'] ?? '',
                'OCCCOUP_DISCOUNT_AMT_DESC' => $params['occ_discount_amt_desc'] ?? '',
                'SPECIAL_STATUS' => $params['special_status'] ?? '',
                'PLAT_ORDER_TYPE' => $params['plat_order_type'] ?? '',
            ];

            $this->relativeUrl = '?txcode=A3341O033';

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
                    'INFORM_ID' => $val['informId'] ?? '0',
                    'PAY_STATUS' => $val['payStatus'] ?? '0',
                    'REFUND_STATUS' => $val['refundStatus'] ?? '0',
                    'PAY_AMT' => $val['price'] ?? '',
                    'DISCOUNT_AMT' => $val['discountPrice'] ?? '',
                    'DISCOUNT_AMT_DESC' => $val['discountDesc'] ?? '',
                    'CUS_ORDER_URL' => $val['orderUrl'] ?? '',
                    'OCC_MCT_LOGO_URL' => $val['logoOrderUrl'] ?? '',
                    'PAY_FLOW_ID' => $val['payFlowId'] ?? $val['orderId'],
                    'PAY_USER_ID' => $val['payUserId'] ?? '',
                    'TOTAL_REFUND_AMT' => $val['totalRefundPrice'] ?? '',
                    'PREFTL_MRCH_ID' => $this->app->getStoreId(),
                    'PAY_MRCH_ID' => $this->app->getMid(),
                    'PLAT_MCT_ID' => $this->app->getPlMid(),
                    'OCCCOUP_DISCOUNT_AMT' => $val['occ_discount_amt'] ?? '',
                    'OCCCOUP_DISCOUNT_AMT_DESC' => $val['occ_discount_amt_desc'] ?? '',
                    'SPECIAL_STATUS' => $val['special_status'] ?? '',
                ];
            }

            $this->relativeUrl = '?txcode=A3341O034';

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
                'TX_TYPE' => $params['type'], // 0-支付，包括所有的支付/消费类功能 1-退款，包括所有的退款/退货/撤销类功能
                'TXN_PRD_TPCD' => $params['protpcd'] ?? '99', // 06-近24小时内交易，99-自定义时间段查询 备注：06查询近24小时内交易，仅返回符合条件的最近一笔记录
                'STDT_TM' => $params['startDate'] ?? '', // TXN_PRD_TPCD 99必填
                'EDDT_TM' => $params['endDate'] ?? '', // TXN_PRD_TPCD 99必填
                'ONLN_PY_TXN_ORDR_ID' => $params['orderId'] ?? '', // TXN_PRD_TPCD 06必填
                'SCN_IDR' => $params['scnId'] ?? '',
                'PLAT_MCT_ID' => $this->app->getPlMid(),
                'CUSTOMERID' => $this->app->getMid(),
                'BRANCHID' => $this->app->getBranchId(),
                'POS_CODE' => $this->app->getPostId(),
                'POS_ID' => $this->app->getPostId19(),
                'TXN_STATUS' => $params['orderStatus'], // 00-交易成功标志；01-交易失败；02-不确定
                'MSGRP_JRNL_NO' => $params['jrnlNo'] ?? '', // TXN_PRD_TPCD 06必填
                'PAGE' => $params['page'] ?? 1,
            ];

            $this->relativeUrl = '?txcode=A3341O035';

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
                'CUSTOMERID' => $this->app->getMid(),
                'BRANCHID' => $this->app->getBranchId(),
                'MONEY' => $params['price'],
                'ORDER' => $params['orderId'],
                'STDT_TM' => $params['startDate'],
                'EDDT_TM' => $params['endDate'],
            ];

            $this->relativeUrl = '?txcode=A3341O036';

            return $this->request($body);
        }catch (\Throwable $e) {
            throw $e;
        }
    }
}
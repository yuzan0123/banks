<?php

namespace Xyu\Banks\Traits;

trait HttpRequests
{

    /**
     * @param array $body
     * @return array|string
     * @throws \Exception
     */
    public function request(array $body)
    {
        try {
            $resp = $this->app->http
                ->json($this->app->getUrl(), $body)
                ->getBody()->getContents();
            if ($resp) {
                return $resp;
            }
            return [];
        } catch (\Throwable $e) {
            throw new \Exception('建设银行生活请求失败：' . $e->getMessage());
        }
    }

}
<?php

namespace Xyu\Banks\Traits;

trait HttpRequests
{

    /**
     * @param array $body
     * @return array|\Psr\Http\Message\StreamInterface
     * @throws \Exception
     */
    public function request(array $body)
    {
        try {
            $resp = $this->app->http
                ->json($this->app->getUrl() . $this->relativeUrl, $body)
                ->getBody();
            if ($resp) {
                return $resp;
            }
            return [];
        } catch (\Throwable $e) {
            throw new \Exception('建设银行生活请求失败：' . $e->getMessage());
        }
    }

}
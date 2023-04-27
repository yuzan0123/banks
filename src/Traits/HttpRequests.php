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
                ->request('POST',$this->app->getUrl() . $this->relativeUrl, [
                    \GuzzleHttp\RequestOptions::HEADERS => [
                        'Content-Type' => 'application/json',
                    ],
                    \GuzzleHttp\RequestOptions::JSON => $body
                ])->getBody();
            if ($resp) {
                return json_decode((string)$resp, true);
            }
            return [];
        } catch (\Throwable $e) {
            throw new \Exception('建设银行生活请求失败：' . $e->getMessage());
        }
    }

}
<?php

namespace FacebookAds;

use FacebookAds\Http\Client;
use FacebookAds\Http\Headers;
use FacebookAds\Http\Adapter\CurlAdapter;
class MyApi extends Api
{
    /**
     * @param string $access_token
     * @param string $socks
     * @return static
     */
    public static function getApi($access_token, $socks) {
        $session = new MySession(1, 1, $access_token);
        $client = new Client();
        $client->setDefaultRequestHeaders(new Headers(array(
            'User-Agent' => 'fb-php-'.Api::VERSION,
            'Accept-Encoding' => '*',
        )));
        $curlAdapter = new CurlAdapter($client);
        $curlAdapter->setOpts(new \ArrayObject(array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_CAINFO => $curlAdapter->getCaBundlePath(),
            CURLOPT_PROXY => $socks,
            CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5_HOSTNAME,
        )));
        $client->setAdapter($curlAdapter);
        $api = new static($client, $session);
        return $api;
    }

}
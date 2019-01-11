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
        $opts = array(
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_CAINFO => $curlAdapter->getCaBundlePath()
        );
        if($socks) {
            $opts[CURLOPT_PROXY] = $socks;
            $opts[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS5_HOSTNAME;
        }
        $curlAdapter->setOpts(new \ArrayObject($opts));
        $client->setAdapter($curlAdapter);
        $api = new static($client, $session);
        self::setInstance($api);
        return $api;
    }

}
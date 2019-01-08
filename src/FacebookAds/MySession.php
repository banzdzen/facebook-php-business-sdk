<?php

namespace FacebookAds;

class MySession extends Session
{
    /**
     * @return array
     */
    public function getRequestParameters() {
        if ($this->getAppSecretProof() !== null) {
            return array(
                'access_token' => $this->getAccessToken()
            );
        } else {
            return array(
                'access_token' => $this->getAccessToken(),
            );
        }
    }
}
<?php

class CurlLibrary {

    public $curl;

    /**
     * Construct
     *
     * @access public
     * @param  $base_url
     * @throws \ErrorException
     */
    public function __construct() {
        if (!extension_loaded('curl')) {
            throw new \ErrorException('cURL library is not loaded');
        }
        $this->curl = curl_init();
    }

    /**
     * Set curl options
     * Execute curl
     * @return type
     */
    function setCurl($url, $curlHeader, $curlPostFields, $curlPost) {
        curl_setopt_array($this->curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_VERBOSE => 1,
            CURLOPT_HEADER => 1,
            CURLOPT_URL => $url,
            CURLOPT_HTTPHEADER => $curlHeader
        ));
        if (!is_null($curlPostFields) && !is_null($curlPost)) {
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $curlPost);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $curlPostFields);
        }
        $response = curl_exec($this->curl);
        $header_size = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        curl_close($this->curl);
        return array(
            'response' => $response,
            'header_size' => $header_size,
            'header' => $header,
            'body' => $body
        );
    }

    /**
     * Gets session id from cookie
     * @param type $headerInfo
     * @return type
     */
    function getSessionId($headerInfo) {
        $headers = explode(";", $headerInfo);
        $getSession = '';
        foreach ($headers as $val) {
            if (strpos($val, 'sessionid') !== false) {
                $getSession = $val;
            }
        }
        $explodeSession = explode('=', $getSession);
        return end($explodeSession);
    }

}

<?php

require('curl_library.php');
require('simple_html_dom.php');

class InstaFunction {

    public $sessionId;

    /**
     * Authentication
     * @return $sessionId
     */
    function setInstaLogin() {
        $curl = new CurlLibrary();
        $url = 'https://www.instagram.com/accounts/login/ajax/';
        $curlPostFields = array(
            'username' => 'your_instagram_username',
            'password' => 'your_instagram_password'
        );
        $curlHeader = array(
            "Cookie: csrftoken=6vJv7IVuMrOvcaLQCPXEkcZkVJjbmCj1; rur=PRN; mid=W0tXzQAEAAFQOSIarVsT1QtpLu3z; ig_cb=1; mcd=3",
            "x-csrftoken:6vJv7IVuMrOvcaLQCPXEkcZkVJjbmCj1",
            "x-instagram-ajax:f5ca59f6b92c",
            "x-requested-with:XMLHttpRequest"
        );
        $response = $curl->setCurl($url, $curlHeader, $curlPostFields, 1);
        $sessionId = $curl->getSessionId($response['header']);
        return $sessionId;
    }

    /**
     * Loads Instagram Page
     * @return $instaQueryUrl
     */
    function loadInstaPage() {
        $curlInsta = new CurlLibrary();
        $urlInsta = 'https://www.instagram.com/';
        $headers = array();
        $sessionId = $this->setInstaLogin();
        $cookie = "sessionid=$sessionId";
        $headers[] = 'Cookie: ' . $cookie;
        $responseInsta = $curlInsta->setCurl($urlInsta, $headers, NULL, NULL);
        $html = new simple_html_dom();
        $html->load($responseInsta['response']);
        foreach ($html->find('link') as $link) {
            $linkHref = $link->attr['href'];
            if (strpos($linkHref, 'graphql') !== false && strpos($linkHref, 'only_stories') == false) {
                $instaQueryUrl = $link->attr['href'];
            }
        }
        return $instaQueryUrl;
    }

    /**
     * Gets Instagram contents
     * @return $timelineFeeds
     */
    function getInstaContents() {
        $curlContents = new CurlLibrary();
        $sessionId = $this->setInstaLogin();
        $instaQueryUrl = $this->loadInstaPage();
        $headers = array();
        $cookie = "sessionid=$sessionId";
        $headers[] = 'Cookie: ' . $cookie;
        $responseContents = $curlContents->setCurl('https://www.instagram.com' . $instaQueryUrl, $headers, NULL, NULL);
        $contents = json_decode($responseContents['body']);
        $timelineFeeds = $contents->data->user->edge_web_feed_timeline->edges;
        return $timelineFeeds;
    }

}

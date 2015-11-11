<?php namespace Pubsubhubbub;

/**
 * Pubsubhubbub PHP Client
 *
 * @namespace Pubsubhubbub
 * @class Publish
 * @author Yoshiaki Sugimoto
 * Pub
 */
class Publisher {

    /**
     * Library version
     *
     * @constant
     */
    const VERSION = "1.0";

    /**
     * Default pubsubhubbub url
     *
     * @constant
     */
    const GOOGLE_APPSROPT_URL = "http://pubsubhubbub.appspot.com/";

    /**
     * Stack hub URL
     *
     * @protected
     * @property $hubUrl
     * @type string
     */
    protected $hubUrl = "";

    /**
     * Constructor
     *
     * @public
     * @param string $url
     */
    public function __construct($url = "") {
        $this->hubUrl = ( $url === "" )
                          ? static::GOOGLE_APPSROPT_URL
                          : $url;
    }

    /**
     * Create instance statically
     *
     * @public
     * @static
     * @param string $url
     * @return Pubsubhubbub\Publisher
     */
    public static function make($url = "") {
        return new static($url);
    }

    /**
     * Publish
     *
     * @public
     * @param mixed array|string $topicUrl
     * @return bool
     * @throws Pubsubhubbub\Exception
     */
    public function publish($topicUrl) {
        if ( ! filter_var($this->hubUrl, FILTER_VALIDATE_URL) ) {
            throw new Exception("Hub url \"{$this->hubUrl}\" is invalid url format");
        }

        if ( ! is_array($topicUrl) ) {
            $topicUrl = [$topicUrl];
        }

        foreach ( $topicUrl as $url ) {
            if ( ! filter_var($url, FILTER_VALIDATE_URL) ) {
                throw new Exception("Topic url \"{$url}\" is invalid url format");
            }
        }

        return $this->request($topicUrl);
    }

    /**
     * Send request
     *
     * @protected
     * @param array<string> $topicUrl
     * @return bool
     */
    protected function request(array $topicUrl) {
        $handle = curl_init();

        curl_setopt_array($handle, [
            CURLOPT_URL        => $this->hubUrl,
            CURLOPT_POST       => true,
            CURLOPT_POSTFIELDS => $this->generatePostData($topicUrl),
            CURLOPT_USERAGENT  => "Pubsubhubbub-Publisher/" . static::VERSION
        ]);

        $response   = curl_exec($handle);
        $statusCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);

        return ( (int)$statusCode === 204 ) ? true : false;
    }

    /**
     * Generate post parameter
     *
     * @protected
     * @param array<string> $topicUrls
     * @return string
     */
    protected function generatePostData(array $topicUrls) {
        $post = array_map(function($url) {
            return "hub.url=" . rawurlencode($url);
        }, $topicUrls);

        return "hub.mode=publish&" . implode("&", $post);
    }
}

<?php

namespace app\helpers;

/**
 * Class UrlMixer
 *
 * @package app\helpers
 */
class UrlMixer
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * UrlMixer constructor.
     *
     * @param string $url
     */
    public function __construct($url = '/')
    {
        $this->parse($url);
    }

    /**
     * @param string $url
     */
    public function parse($url)
    {
        $parts = explode('?', $url);
        $this->path = $parts[0];
        if (isset($parts[1])) {
            parse_str($parts[1], $this->params);
        }
    }

    /**
     * @param array $params
     *
     * @return string
     */
    public function mix($params)
    {
        $params = array_merge($this->params, $params);

        return $this->path . '?' . http_build_query($params);
    }
}
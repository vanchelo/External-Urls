<?php namespace Vanchelo\ExternalUrls\Transport;

interface TransportInterface
{
    /**
     * @param string $url
     *
     * @return string
     */
    public function get($url);
}

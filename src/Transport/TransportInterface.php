<?php

namespace Vanchelo\ExternalUrls\Transport;

interface TransportInterface
{
    /**
     * Get content as string from url
     *
     * @param string $url
     *
     * @return string
     */
    public function get($url);
}

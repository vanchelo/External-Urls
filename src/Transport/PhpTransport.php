<?php

namespace Vanchelo\ExternalUrls\Transport;

class PhpTransport implements TransportInterface
{
    /**
     * @param string $url
     *
     * @return string
     */
    public function get($url)
    {
        return file_get_contents($url);
    }
}

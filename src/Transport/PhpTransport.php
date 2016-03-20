<?php

namespace Vanchelo\ExternalUrls\Transport;

class PhpTransport implements TransportInterface
{
    /**
     * {@inheritdoc}
     */
    public function get($url)
    {
        return file_get_contents($url);
    }
}

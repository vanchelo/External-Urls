<?php

namespace Vanchelo\ExternalUrls\Transport;

class CurlTransport implements TransportInterface
{
    /**
     * Send Request
     *
     * @param string $url
     *
     * @throws \InvalidArgumentException if $url argument is not of type 'string'
     *
     * @return mixed
     */
    public function get($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('Url must be a string');
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, ltrim($url, '/'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0');

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}


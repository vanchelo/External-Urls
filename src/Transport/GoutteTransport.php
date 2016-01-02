<?php

namespace Vanchelo\ExternalUrls\Transport;

use Goutte\Client;

class GoutteTransport implements TransportInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * GoutteTransport constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $url
     *
     * @return string
     */
    public function get($url)
    {
        $request = $this->client->request('GET', $url);

        return $request->html();
    }
}

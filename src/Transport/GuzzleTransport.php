<?php namespace Vanchelo\ExternalUrls\Transport;

use GuzzleHttp\Client;

class GuzzleTransport implements TransportInterface
{
    protected $client;

    function __construct()
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
        $request = $this->client->get($url);

        return $request->getBody()->getContents();
    }
}

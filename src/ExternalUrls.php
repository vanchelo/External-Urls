<?php

namespace Vanchelo\ExternalUrls;

use Vanchelo\ExternalUrls\Transport\CurlTransport;
use Vanchelo\ExternalUrls\Transport\TransportInterface;

class ExternalUrls
{
    /**
     * External links
     *
     * @var Collection
     */
    public $links;
    /**
     * Working URL
     *
     * @var string
     */
    protected $url;
    /**
     * Current Domain
     *
     * @var string
     */
    protected $domain;
    /**
     * Transport
     *
     * @var TransportInterface
     */
    protected $transport;

    /**
     * ExternalUrls constructor.
     *
     * @param TransportInterface $transport
     * @param string|null        $url
     */
    public function __construct(TransportInterface $transport = null, $url = null)
    {
        if (!$transport) {
            $transport = new CurlTransport;
        }

        $this->setTransport($transport);

        if ($url) {
            $this->prepare($url);
        }
    }

    /**
     * Set transport
     *
     * @param TransportInterface $transport
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Prepare URL
     *
     * @param string $url
     */
    protected function prepare($url)
    {
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0) {
            $url = 'http://' . ltrim($url, '/');
        }

        $this->links = [];
        $this->url = $url;
        $this->setDomain($url);
    }

    /**
     * Go Go Go...
     *
     * @param string|null $url
     *
     * @return Collection
     */
    public function go($url = null)
    {
        if ($url) {
            $this->prepare($url);
        }

        if (!$url && !$this->url) {
            throw new \InvalidArgumentException('Please set url before go.');
        }

        $content = $this->transport->get($this->url);

        $links = [];
        foreach ($this->getAllLinks($content) as $link) {
            if ($this->externalLink($link)) {
                $links[] = $link;
            }
        }

        $this->links = $this->buildCollection($links);

        return $this->links;
    }

    /**
     * Build collection of links
     *
     * @param array $items
     *
     * @return Collection
     */
    protected function buildCollection($items)
    {
        return Collection::make($items);
    }

    /**
     * Get all external links from string
     *
     * @param string $content
     *
     * @return array
     */
    public function getAllLinks($content)
    {
        $matches = [];

        preg_match_all('/href=\"((https?:)?\/\/.+)"/U', $content, $matches);

        if (!isset($matches[1])) {
            return [];
        }

        $links = array_map(function ($link) {
            return trim($link, '/');
        }, $matches[1]);

        return $links;
    }

    /**
     * Determine if link is external
     *
     * @param string $link
     *
     * @return bool
     */
    protected function externalLink($link)
    {
        return !preg_match('/^(https?:)?(\/\/)?(www\.)?' . $this->domain . '/Ui', $link);
    }

    /**
     * Set domain
     *
     * @param string $url
     */
    protected function setDomain($url)
    {
        $this->domain = parse_url($url, PHP_URL_HOST);
    }
}

<?php namespace Vanchelo\ExternalUrls;

use Vanchelo\ExternalUrls\Collection;
use Vanchelo\ExternalUrls\Transport\CurlTransport;
use Vanchelo\ExternalUrls\Transport\TransportInterface;

class ExternalUrls
{
    /**
     * Коллекция найденных внешних ссылок
     *
     * @var Collection
     */
    public $links;

    /**
     * Рабочий URL
     *
     * @var
     */
    protected $url;

    /**
     * Домен
     *
     * @var
     */
    protected $domain;

    /**
     * Транспорт
     *
     * @var TransportInterface
     */
    protected $transport;

    /**
     * Конструктор
     *
     * @param TransportInterface $transport
     * @param string|null $url
     */
    function __construct(TransportInterface $transport = null, $url = null)
    {
        if (!$transport) {
            $transport = new CurlTransport;
        }

        $this->setTransport($transport);

        if ($url) $this->prepare($url);
    }

    /**
     * Установка транспорта
     *
     * @param TransportInterface $transport
     */
    public function setTransport(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    /**
     * Подготовка URL
     *
     * @param string $url
     */
    protected function prepare($url)
    {
        $this->links = [];
        $this->url = $url;
        $this->setDomain($url);
    }

    /**
     * @param string|null $url
     *
     * @return Collection
     */
    public function go($url = null)
    {
        if ($url) $this->prepare($url);

        $content = $this->transport->get($this->url);

        $links = [];
        foreach ($this->getAllLinks($content) as $link) {
            if ($this->externalLink($link)) $links[] = $link;
        }

        $this->links = $this->buildCollection($links);

        return $this->links;
    }

    protected function buildCollection($items)
    {
        return Collection::make($items);
    }

    /**
     * @param $content
     *
     * @return array
     */
    public function getAllLinks($content)
    {
        $matches = [];

        preg_match_all('/href=\"(https?:\/\/.+)"/U', $content, $matches);

        return isset($matches[1]) ? $matches[1] : [];
    }

    /**
     * @param $link
     *
     * @return bool
     */
    protected function externalLink($link)
    {
        return !preg_match('/^https?:\/\/' . $this->domain . '/', $link);
    }

    /**
     * @param string $url
     */
    protected function setDomain($url)
    {
        $this->domain = parse_url($url, PHP_URL_HOST);
    }
}
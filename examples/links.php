<?php

// composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

use Vanchelo\ExternalUrls\ExternalUrls;
use Vanchelo\ExternalUrls\Transport\PhpTransport;

//use Vanchelo\ExternalUrls\Transport\CurlTransport;
//use Vanchelo\ExternalUrls\Transport\GoutteTransport;
//use Vanchelo\ExternalUrls\Transport\GuzzleTransport;

$externalLinks = new ExternalUrls(/*new PhpTransport()*/);
$links = $externalLinks->go(($_ = filter_input(INPUT_GET, 'link')) ?: 'https://sparkpage.com');

echo '<ul>';
array_map(function ($link) {
    echo "<li>{$link}</li>";
}, $links->unique()->all());
echo '</ul>';

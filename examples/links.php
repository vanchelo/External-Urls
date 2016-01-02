<?php

// composer autoloader
require_once '../vendor/autoload.php';

use Vanchelo\ExternalUrls\ExternalUrls;
use Vanchelo\ExternalUrls\Transport\PhpTransport;

//use Vanchelo\ExternalUrls\Transport\CurlTransport;
//use Vanchelo\ExternalUrls\Transport\GoutteTransport;
//use Vanchelo\ExternalUrls\Transport\GuzzleTransport;

$externalLinks = new ExternalUrls(new PhpTransport());
$links = $externalLinks->go('http://www.example.com');

print_r($links->unique()->all());

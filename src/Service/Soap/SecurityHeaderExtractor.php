<?php
declare(strict_types=1);

namespace App\Service\Soap;

use Symfony\Component\DomCrawler\Crawler;

class SecurityHeaderExtractor
{
    public function extract(string $xml): string
    {
        $crawler = new Crawler($xml);

        $crawler->registerNamespace('S11 ', 'http://schemas.xmlsoap.org/soap/envelope/');
        $crawler->registerNamespace('wsse', 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd');
        $crawler->registerNamespace('wsu', 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd');
        $crawler = $crawler->filterXPath('//wsse:Security/wsse:UsernameToken/wsse:Username');
        dump($crawler);
        var_dump($crawler->text());
        die;
        $crawler->text();
    }
}
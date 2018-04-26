<?php
declare(strict_types=1);

namespace App\Service\Soap;

use Symfony\Component\DomCrawler\Crawler;

class SecurityHeaderExtractor
{
    public const USERNAME_XPATH = '//wsse:Security/wsse:UsernameToken/wsse:Username';
    public const PASSWORD_XPATH = '//wsse:Security/wsse:UsernameToken/wsse:Password';

    /**
     * Extract username, password from xml.
     *
     * @param string $xml
     *
     * @return SecurityHeader
     *
     * @throws \InvalidArgumentException
     */
    public function extract(string $xml): SecurityHeader
    {
        $crawler = $this->registerNamespaces(new Crawler($xml));
        $username = $crawler->filterXPath(self::USERNAME_XPATH)->text();

        if (empty($username)) {
            throw new \InvalidArgumentException('Username should not be empty');
        }

        $password = $crawler->filterXPath(self::PASSWORD_XPATH)->text();

        if (empty($password)) {
            throw new \InvalidArgumentException('Password should not be empty');
        }

        return new SecurityHeader($username, $password);
    }

    /**
     * Register header namespaces.
     *
     * @param Crawler $crawler
     *
     * @return Crawler
     */
    private function registerNamespaces(Crawler $crawler): Crawler
    {
        $crawler->registerNamespace(SecurityHeader::PREFIX_S11, SecurityHeader::NS_S11);
        $crawler->registerNamespace(SecurityHeader::PREFIX_WSSE, SecurityHeader::NS_WSSE);
        $crawler->registerNamespace(SecurityHeader::PREFIX_WSU, SecurityHeader::NS_WSU);

        return $crawler;
    }
}
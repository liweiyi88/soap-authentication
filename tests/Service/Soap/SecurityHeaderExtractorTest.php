<?php
declare(strict_types=1);

namespace App\Tests\Service\Soap;

use App\Service\Soap\SecurityHeader;
use App\Service\Soap\SecurityHeaderExtractor;
use PHPUnit\Framework\TestCase;

class SecurityHeaderExtractorTest extends TestCase
{
    /**
     * @var SecurityHeaderExtractor $extractor
     */
    private $extractor;

    public function setUp()
    {
        parent::setUp();
        $this->extractor = new SecurityHeaderExtractor();
    }

    /**
     * Test extract xml request successfully.
     */
    public function testExtract(): void
    {
        $xml = $this->getTestXml('julian', '123');

        $securityHeader = $this->extractor->extract($xml);

        $this->assertInstanceOf(SecurityHeader::class, $securityHeader);
        $this->assertSame('julian', $securityHeader->getUsername());
        $this->assertSame('123', $securityHeader->getPassword());
    }

    /**
     * Make sure extract method throw proper exception when receiving xml request.
     *
     * @return void
     */
    public function testExtractWithInvalidXml(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $xml = 'fsdfsdf';
        $this->extractor->extract($xml);
    }

    /**
     * Make sure extract method throw proper exception with empty username request.
     *
     * @return void
     */
    public function testExtractWithEmptyUsername(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Username should not be empty');

        $xml = $this->getTestXml('', '123');
        $this->extractor->extract($xml);
    }

    /**
     * Make sure extract method throw proper exception with empty password request.
     *
     * @return void
     */
    public function testExtractWithEmptyPassword(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Password should not be empty');

        $xml = $this->getTestXml('julian', '');
        $this->extractor->extract($xml);
    }

    /**
     * Get a valid soap request header.
     *
     * @param string $username
     * @param string $password
     *
     * @return string
     */
    private function getTestXml(string $username, string $password): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="urn:hellowsdl" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:ns2="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Header>
<wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
    <wsse:UsernameToken>
        <wsse:Username>'.$username.'</wsse:Username>
        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$password.'</wsse:Password>
        <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">fdsfs</wsse:Nonce>
        <wsu:Created>2015-08-06T07:22:39.464Z</wsu:Created>
    </wsse:UsernameToken>
</wsse:Security>
</SOAP-ENV:Header></SOAP-ENV:Envelope>';
        return $xml;
    }
}

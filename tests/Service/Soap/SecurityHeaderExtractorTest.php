<?php
declare(strict_types=1);

namespace App\Tests\Service\Soap;

use App\Service\Soap\SecurityHeaderExtractor;
use PHPUnit\Framework\TestCase;

class SecurityHeaderExtractorTest extends TestCase
{
    public function testExtract()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="urn:hellowsdl" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:ns2="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"><SOAP-ENV:Header>
<wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
    <wsse:UsernameToken>
        <wsse:Username>julian</wsse:Username>
        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">123</wsse:Password>
        <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">fdsfs</wsse:Nonce>
        <wsu:Created>2015-08-06T07:22:39.464Z</wsu:Created>
    </wsse:UsernameToken>
</wsse:Security>
</SOAP-ENV:Header><SOAP-ENV:Body><ns1:hello><name xsi:type="xsd:string">Scott</name></ns1:hello></SOAP-ENV:Body></SOAP-ENV:Envelope>';

        $extractor = new SecurityHeaderExtractor();

        dump($extractor->extract($xml));
        die;

        $this->assertTrue(true);
    }
}
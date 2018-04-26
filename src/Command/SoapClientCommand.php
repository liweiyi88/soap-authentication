<?php

namespace App\Command;

use App\Service\Soap\SecurityHeader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SoapClientCommand extends Command
{
    protected static $defaultName = 'create:token';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $soapClient = new \SoapClient('http://localhost:8888/soap?wsdl', ['cache_wsdl' => WSDL_CACHE_NONE, 'trace' => 1]);

        $headers[] = $this->generateSecurityHeader('julian', '123', 'fdsfs', '2015-08-06T07:22:39.464Z');
        $soapClient->__setSoapHeaders($headers);

        $token = $soapClient->__call('getToken', ['client_code', 'action', 'programcode', 'isvalid', true, false]);
        dump($token);
        dump($soapClient->__getLastRequest());
    }

    /**
     * @param $username
     * @param $password
     * @param $nonce
     * @param $createdAt - 2015-08-06T07:22:39.464Z
     * @return \SoapHeader
     */
    private function generateSecurityHeader($username, $password, $nonce, $createdAt): \SoapHeader
    {
        $xml = '
<wsse:Security soapenv:mustUnderstand="1" xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd" xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd">
    <wsse:UsernameToken>
        <wsse:Username>'.$username.'</wsse:Username>
        <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">'.$password.'</wsse:Password>
        <wsse:Nonce EncodingType="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-soap-message-security-1.0#Base64Binary">'.$nonce.'</wsse:Nonce>
        <wsu:Created>'.$createdAt.'</wsu:Created>
    </wsse:UsernameToken>
</wsse:Security>
';
        return new \SoapHeader(SecurityHeader::NS_WSSE,
            'Security',
            new \SoapVar($xml, XSD_ANYXML),
            true
        );
    }
}

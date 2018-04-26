<?php

namespace App\Controller;

use App\Service\HelloService;
use App\Service\SoapAuthenticator;
use SoapServer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SoapController extends Controller
{
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    /**
     * @Route("/soap", name="soap")
     */
    public function index(SoapAuthenticator $authenticator, HelloService $helloService, Request $request)
    {
       $soapServer = new SoapServer($this->projectDir.'/resource/auth.wsdl');
       //$soapServer->setObject($authenticator);
       $soapServer->setObject($helloService);

       $response = new Response();

       $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}

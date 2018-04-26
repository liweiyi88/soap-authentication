<?php
declare(strict_types=1);

namespace App\Service;

use App\Service\Soap\SecurityHeaderExtractor;
use Symfony\Component\HttpFoundation\RequestStack;

class HelloService
{
    private $request;
    private $extractor;

    public function __construct(RequestStack $request, SecurityHeaderExtractor $extractor)
    {
        $this->extractor = $extractor;
        $this->request = $request;
    }

    public function hello($header): string
    {
        $xml = $this->request->getCurrentRequest()->getContent();

        //$this->extractor->extract($xml);
        return $xml;
    }
}

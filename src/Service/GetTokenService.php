<?php
declare(strict_types=1);

namespace App\Service;

class GetTokenService
{
    public function getToken(
        string $action,
        string $clientCode,
        string $programCode,
        string $siteCode,
        string $externalRefernce,
        bool $isValid
    ): string {
        return $action.$clientCode.$programCode.$siteCode.$externalRefernce.$isValid;
    }

}
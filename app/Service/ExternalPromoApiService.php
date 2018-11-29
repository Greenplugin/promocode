<?php
declare(strict_types=1);

namespace App\Service;


class ExternalPromoApiService
{

    public function registerPromocodeAtExternalSystem(string $email, string $promocode): bool
    {
        $codes = [true, false];
        sleep(rand(1, 2));
        return $codes[array_rand($codes)];
    }


}
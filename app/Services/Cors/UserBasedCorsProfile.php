<?php

namespace App\Services\Cors;

use Spatie\Cors\CorsProfile\DefaultProfile;

class UserBasedCorsProfile extends DefaultProfile
{
    public function allowOrigins(): array
    {
        return Auth::user()->allowed_domains;
    }
}

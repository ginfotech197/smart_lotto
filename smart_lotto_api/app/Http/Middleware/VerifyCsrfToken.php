<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'https://playsmartwin.com/smart_lotto_api_api/public/api/*',
        'https://playsmartwin.com/smart_lotto_api_api/public/api/*'
    ];
}

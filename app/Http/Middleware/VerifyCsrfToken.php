<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'panel/payment',
        'panel/payment/*',
        'token',
        'weepay_cb',
        'weepay_cb/*',
        'paytr_callback',
        'paytr_callback/',
        'paytr_callback/*',
        'valletpay_callback',
        'valletpay_callback/',
        'valletpay_callback/*',
        'payid19call',
        'payid19call/',
        'payid19pay/*',
        '/dapi',
        '/dapi/',
        '/dapi/*',
        'dapi/*',
        'dapi/',
    ];
}

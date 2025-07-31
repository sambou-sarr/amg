<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;


class TrustProxies extends Middleware
{
    /**
     * Les proxies de confiance.
     *
     * @var array|string|null
     */
    protected $proxies = '*'; // accepte toutes les adresses proxy (Render, Cloudflare...)

    /**
     * Les en-têtes à utiliser pour détecter la requête originale.
     *
     * @var int
     */
    protected $headers =  Request::HEADER_X_FORWARDED_FOR | Request::HEADER_X_FORWARDED_HOST | Request::HEADER_X_FORWARDED_PROTO | Request::HEADER_X_FORWARDED_PORT;

}

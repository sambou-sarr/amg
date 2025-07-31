<?php

use Symfony\Component\HttpFoundation\Request;

return [

    /*
    |--------------------------------------------------------------------------
    | Proxies de confiance
    |--------------------------------------------------------------------------
    |
    | "*" pour faire confiance à tous les proxys (comme Render, Cloudflare, etc.).
    |
    */
    'proxies' => '*',

    /*
    |--------------------------------------------------------------------------
    | En-têtes à utiliser pour détecter la requête originale
    |--------------------------------------------------------------------------
    |
    | Utilise les constantes de Symfony (Laravel 9+).
    |
    */
    'headers' =>
        Request::HEADER_X_FORWARDED_FOR
        | Request::HEADER_X_FORWARDED_HOST
        | Request::HEADER_X_FORWARDED_PORT
        | Request::HEADER_X_FORWARDED_PROTO,
];

<?php

namespace Dynamix\PesoPay;

use LordDashMe\StaticClassInterface\Facade;

class Base
{
    protected static $required_parameters = [
        'merchantId',
        'amount',
        'orderRef',
        'currCode',
        'mpsMode',
        // 'successUrl', // Can be set in admin portal
        // 'failUrl', // Can be set in admin portal
        // 'cancelUrl', // Can be set in admin portal
        'payType',
        'lang',
        'payMethod',
        'secureHashSecret',
    ];

    protected static function FallbackUrl()
    {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    }
}

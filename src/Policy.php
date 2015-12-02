<?php

namespace FreezyBee\MojeId;

use Nette\Object;

/**
 * Class Policy
 * @package FreezyBee\MojeId
 */
class Policy extends Object
{
    const CERTIFICATE = 'certificate';
    const PASSWORD = 'password';
    const PHYSICAL = 'physical';

    public static $pape = [
        self::PASSWORD => 'http://schemas.openid.net/pape/policies/2007/06/multi-factor',
        self::CERTIFICATE => 'http://schemas.openid.net/pape/policies/2007/06/phishing-resistant',
        self::PHYSICAL => 'http://schemas.openid.net/pape/policies/2007/06/multi-factor-physical'
    ];
}

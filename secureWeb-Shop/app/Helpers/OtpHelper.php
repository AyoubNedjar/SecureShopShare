<?php

namespace App\Helpers;

use RobThree\Auth\TwoFactorAuth;

class OtpHelper
{
    public static function generateSecret()
    {
        $tfa = new TwoFactorAuth('MyApp');
        return $tfa->createSecret();
    }

    public static function verifyOtp($secret, $otp)
    {
        $tfa = new TwoFactorAuth('MyApp');
        return $tfa->verifyCode($secret, $otp);
    }
}
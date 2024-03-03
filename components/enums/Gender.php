<?php

namespace app\components\enums;

class Gender
{
    const MALE = 'male';
    const FEMALE = 'female';
    const UNDEFINED = 'undefined';

    public static function values()
    {
        return [
            self::MALE,
            self::FEMALE,
            self::UNDEFINED,
        ];
    }
}
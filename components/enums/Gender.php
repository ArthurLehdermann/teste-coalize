<?php

namespace app\components\enums;

class Gender
{
    private const MALE = 'male';
    private const FEMALE = 'female';
    private const UNDEFINED = 'undefined';

    public static function values()
    {
        return [
            self::MALE,
            self::FEMALE,
            self::UNDEFINED,
        ];
    }
}
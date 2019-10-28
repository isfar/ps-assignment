<?php

namespace App\Document;

final class CountryCode
{
    const GERMAN        = 'de';
    const SPANISH       = 'es';
    const FRENCH        = 'fr';
    const POLISH        = 'pl';
    const ITALIAN       = 'it';
    const BRITISH       = 'uk';
    const LITHUANIAN    = 'lt';

    public static $list = [
        self::GERMAN,
        self::SPANISH,
        self::FRENCH,
        self::POLISH,
        self::ITALIAN,
        self::BRITISH,
        self::LITHUANIAN,
    ];
}

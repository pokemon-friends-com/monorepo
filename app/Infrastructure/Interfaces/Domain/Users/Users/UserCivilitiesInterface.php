<?php

namespace template\Infrastructure\Interfaces\Domain\Users\Users;

interface UserCivilitiesInterface
{
    public const CIVILITY_MADAM = 'madam';
    public const CIVILITY_MISS = 'miss';
    public const CIVILITY_MISTER = 'mister';
    public const CIVILITY_UNDEFINED = 'undefined';
    public const CIVILITIES = [
        self::CIVILITY_MADAM,
        self::CIVILITY_MISS,
        self::CIVILITY_MISTER,
    ];
    public const GENDER_MALE_CIVILITIES = [
        self::CIVILITY_MISTER,
    ];
    public const GENDER_FEMALE_CIVILITIES = [
        self::CIVILITY_MADAM,
        self::CIVILITY_MISS,
    ];
}

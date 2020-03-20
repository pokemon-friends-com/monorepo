<?php

namespace template\Infrastructure\Interfaces\Domain\Users\Users;

interface UserCivilitiesInterface
{
    const CIVILITY_MADAM = 'madam';
    const CIVILITY_MISS = 'miss';
    const CIVILITY_MISTER = 'mister';
    const CIVILITY_UNDEFINED = 'undefined';

    const CIVILITIES = [
        self::CIVILITY_MADAM,
        self::CIVILITY_MISS,
        self::CIVILITY_MISTER,
    ];

    const GENDER_MALE_CIVILITIES = [
        self::CIVILITY_MISTER,
    ];

    const GENDER_FEMALE_CIVILITIES = [
        self::CIVILITY_MADAM,
        self::CIVILITY_MISS,
    ];
}

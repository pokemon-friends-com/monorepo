<?php

namespace template\Infrastructure\Interfaces\Domain\Users\Profiles;

interface ProfileFamiliesSituationsInterface
{
    public const FAMILY_SITUATION_SINGLE = 'single';
    public const FAMILY_SITUATION_MARRIED = 'married';
    public const FAMILY_SITUATION_CONCUBINAGE = 'concubinage';
    public const FAMILY_SITUATION_DIVORCEE = 'divorcee';
    public const FAMILY_SITUATION_WIDOW_ER = 'widow_er';
    public const FAMILY_SITUATIONS_WHIT_MAIDEN_NAME = [
        self::FAMILY_SITUATION_MARRIED,
        self::FAMILY_SITUATION_DIVORCEE,
        self::FAMILY_SITUATION_WIDOW_ER,
    ];
    public const FAMILY_SITUATIONS = [
        self::FAMILY_SITUATION_SINGLE,
        self::FAMILY_SITUATION_MARRIED,
        self::FAMILY_SITUATION_CONCUBINAGE,
        self::FAMILY_SITUATION_DIVORCEE,
        self::FAMILY_SITUATION_WIDOW_ER,
    ];
}

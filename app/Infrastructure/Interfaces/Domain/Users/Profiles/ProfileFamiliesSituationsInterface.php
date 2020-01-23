<?php

namespace template\Infrastructure\Interfaces\Domain\Users\Profiles;

interface ProfileFamiliesSituationsInterface
{
    const FAMILY_SITUATION_SINGLE = 'single';
    const FAMILY_SITUATION_MARRIED = 'married';
    const FAMILY_SITUATION_CONCUBINAGE = 'concubinage';
    const FAMILY_SITUATION_DIVORCEE = 'divorcee';
    const FAMILY_SITUATION_WIDOW_ER = 'widow_er';
    const FAMILY_SITUATIONS_WHIT_MAIDEN_NAME = [
        self::FAMILY_SITUATION_MARRIED,
        self::FAMILY_SITUATION_DIVORCEE,
        self::FAMILY_SITUATION_WIDOW_ER,
    ];
    const FAMILY_SITUATIONS = [
        self::FAMILY_SITUATION_SINGLE,
        self::FAMILY_SITUATION_MARRIED,
        self::FAMILY_SITUATION_CONCUBINAGE,
        self::FAMILY_SITUATION_DIVORCEE,
        self::FAMILY_SITUATION_WIDOW_ER,
    ];
}

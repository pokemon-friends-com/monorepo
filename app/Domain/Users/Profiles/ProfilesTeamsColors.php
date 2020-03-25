<?php

namespace template\Domain\Users\Profiles;

interface ProfilesTeamsColors
{
    const RED = 'red';
    const BLUE = 'blue';
    const YELLOW = 'yellow';
    const DEFAULT = 'default';
    const COLORS = [
        self::DEFAULT,
        self::RED,
        self::BLUE,
        self::YELLOW,
    ];
}

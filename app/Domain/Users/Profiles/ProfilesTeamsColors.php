<?php

namespace pkmnfriends\Domain\Users\Profiles;

interface ProfilesTeamsColors
{
    public const RED = 'red';
    public const BLUE = 'blue';
    public const YELLOW = 'yellow';
    public const DEFAULT = 'default';
    public const COLORS = [
        self::DEFAULT,
        self::RED,
        self::BLUE,
        self::YELLOW,
    ];
}

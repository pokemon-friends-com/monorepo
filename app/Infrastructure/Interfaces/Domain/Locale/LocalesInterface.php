<?php

namespace pkmnfriends\Infrastructure\Interfaces\Domain\Locale;

interface LocalesInterface
{
    public const ENGLISH = 'en';
    public const CHINESE = 'zh-CN';
    public const FRENCH = 'fr';
    public const GERMAN = 'de';
    public const SPANISH = 'es';
    public const RUSSIAN = 'ru';
    public const DEFAULT_LOCALE = self::ENGLISH;
    public const LOCALES = [
        self::ENGLISH,
        // self::CHINESE,
        // self::FRENCH,
        // self::GERMAN,
        // self::SPANISH,
        // self::RUSSIAN,
    ];
}

<?php

namespace template\Infrastructure\Interfaces\Domain\Locale;

interface LocalesInterface
{
    const ENGLISH = 'en';
    const CHINESE = 'zh-CN';
    const FRENCH = 'fr';
    const GERMAN = 'de';
    const SPANISH = 'es';
    const RUSSIAN = 'ru';

    const DEFAULT_LOCALE = self::ENGLISH;

    const LOCALES = [
        self::ENGLISH,
        self::CHINESE,
        self::FRENCH,
        self::GERMAN,
        self::SPANISH,
        self::RUSSIAN,
    ];
}

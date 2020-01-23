<?php

namespace template\Infrastructure\Interfaces\Domain\Locale;

interface LocalesInterface
{
    const FRENCH = 'fr';
    const ENGLISH = 'en';
    const DEFAULT_LOCALE = self::FRENCH;
    const LOCALES = [
        self::FRENCH,
        self::ENGLISH,
    ];
}

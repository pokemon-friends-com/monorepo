<?php

namespace template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens;

interface ProvidersInterface
{
    public const TWITTER = 'twitter';
    public const LINKEDIN = 'linkedin';
    public const GOOGLE = 'google';
    public const PROVIDERS = [
        self::TWITTER,
        self::LINKEDIN,
        self::GOOGLE,
    ];
}

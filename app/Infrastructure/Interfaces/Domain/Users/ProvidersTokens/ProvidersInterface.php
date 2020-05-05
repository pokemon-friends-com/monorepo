<?php

namespace template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens;

interface ProvidersInterface
{
    public const TWITTER = 'twitter';
    public const GOOGLE = 'google';
    public const PROVIDERS = [
        self::TWITTER,
        self::GOOGLE,
    ];
}

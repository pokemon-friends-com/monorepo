<?php

namespace template\Infrastructure\Interfaces\Domain\Users\ProvidersTokens;

interface ProvidersInterface
{
    const TWITTER = 'twitter';
    const LINKEDIN = 'linkedin';
    const GOOGLE = 'google';
    const PROVIDERS = [
        self::TWITTER,
        self::LINKEDIN,
        self::GOOGLE,
    ];
}

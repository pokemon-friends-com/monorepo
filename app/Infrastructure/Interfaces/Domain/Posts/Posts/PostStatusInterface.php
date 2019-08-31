<?php

namespace obsession\Infrastructure\Interfaces\Domain\Posts\Posts;

interface PostStatusInterface
{
    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    const STATUS = [
        self::STATUS_DRAFT,
        self::STATUS_PUBLISHED,
    ];
}

<?php

namespace template\Infrastructure\Interfaces\Domain\Users\Users;

interface UserRolesInterface
{
    public const ROLE_ADMINISTRATOR = 'administrator';
    public const ROLE_CUSTOMER = 'customer';
    public const ROLES = [
        self::ROLE_ADMINISTRATOR,
        self::ROLE_CUSTOMER,
    ];
}

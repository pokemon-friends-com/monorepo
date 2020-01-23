<?php

namespace template\Infrastructure\Interfaces\Domain\Users\Users;

interface UserRolesInterface
{
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_CUSTOMER = 'customer';
    const ROLE_ACCOUNTANT = 'accountant';

    const ROLES = [
        self::ROLE_ADMINISTRATOR,
        self::ROLE_CUSTOMER,
        self::ROLE_ACCOUNTANT,
    ];
}

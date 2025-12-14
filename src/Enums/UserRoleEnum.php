<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case ROLE_USER = 'ROLE_USER';
    case ROLE_ADMIN = 'ROLE_ADMIN';
    case ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public static function getRoles(): array
    {
        return [
            self::ROLE_USER,
            self::ROLE_ADMIN,
            self::ROLE_SUPER_ADMIN,
        ];
    }

    public static function getAdminRole(): array
    {
        return [
            self::ROLE_ADMIN,
            self::ROLE_SUPER_ADMIN,
        ];
    }

}

<?php

namespace App\Enum\Role;

enum RoleEnum : string
{
    case ROLE_ADMIN = "ROLE_ADMIN";
    /*
     * METTRE DANS LE CONTROLLER OU AUTRE
     * '' => $this->>isgranted(roleEnum::ROLE_ADMIN->value)
     */
}

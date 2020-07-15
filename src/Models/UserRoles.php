<?php

namespace MedSchoolCoach\LumenAuth0\Models;

use Illuminate\Support\Arr;

class UserRoles
{
    /**
     * @var array
     */
    private $roles;

    /**
     * UserRoles constructor.
     * @param array $roles
     */
    public function __construct(array $roles)
    {
        $this->roles = $roles;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        foreach ($this->roles as $role) {
            if (Arr::get($role, 'name') === 'admin') {
                return true;
            }
        }

        return false;
    }
}

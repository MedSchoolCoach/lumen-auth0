<?php

namespace MedSchoolCoach\LumenAuth0\Models;

use Illuminate\Auth\GenericUser;

/**
 * Class User
 * @package App\Models
 */
class User extends GenericUser
{
    const ID_NAME = 'sub';

    /**
     * @inheritDoc
     */
    public function getAuthIdentifierName()
    {
        return self::ID_NAME;
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->getAuthIdentifier();
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}

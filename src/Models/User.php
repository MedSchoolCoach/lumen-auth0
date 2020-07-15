<?php

namespace MedSchoolCoach\LumenAuth0\Models;

use Illuminate\Auth\GenericUser;
use MedSchoolCoach\LumenAuth0\Auth0Service;

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

    /**
     * @throws \Auth0\SDK\Exception\EmptyOrInvalidParameterException
     * @throws \Throwable
     */
    public function initRoles()
    {
        /** @var Auth0Service $service */
        $service = app(Auth0Service::class);

        $this->roles = $service->getUserRoles($this->getId());
    }
}

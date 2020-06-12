<?php

namespace MedSchoolCoach\LumenAuth0\Exceptions;

/**
 * Class Auth0ClientConfigNotFoundException
 * @package MedSchoolCoach\LumenAuth0\Exceptions
 */
class Auth0ClientConfigNotFoundException extends \Exception
{

    /**
     * Auth0ClientConfigNotFoundException constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        parent::__construct("Can't find '$key' key in the auth0 config.", 500);
    }
}

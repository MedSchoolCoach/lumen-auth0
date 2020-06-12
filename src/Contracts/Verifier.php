<?php

namespace MedSchoolCoach\LumenAuth0\Contracts;

use Auth0\SDK\Exception\InvalidTokenException;

interface Verifier
{
    /**
     * @param string $token
     * @return bool
     * @throws InvalidTokenException
     */
    public function check(string $token);

    /**
     * @param string $token
     * @return array
     * @throws InvalidTokenException
     */
    public function getInfo(string $token);
}

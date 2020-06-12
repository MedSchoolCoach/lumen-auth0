<?php

namespace MedSchoolCoach\LumenAuth0;

use MedSchoolCoach\LumenAuth0\Contracts\TokenVerifier;
use MedSchoolCoach\LumenAuth0\Contracts\Verifier;
use Auth0\SDK\Exception\InvalidTokenException;

/**
 * Class Auth0Verifier
 * @package MedSchoolCoach\LumenAuth0
 */
class Auth0Verifier implements Verifier
{
    /**
     * @var TokenVerifier
     */
    private $verifier;

    /**
     * Auth0Verifier constructor.
     * @param TokenVerifier $verifier
     */
    public function __construct(TokenVerifier $verifier)
    {
        $this->verifier = $verifier;
    }

    /**
     * @param string $token
     * @return bool
     * @throws InvalidTokenException
     */
    public function check(?string $token)
    {
        return ! is_null($token)
            && null !== $this->getInfo($token);
    }

    /**
     * @param string $token
     * @return array
     * @throws InvalidTokenException
     */
    public function getInfo(string $token)
    {
        try {
            return $this->verifier->verify($token);
        } catch (InvalidTokenException $e) {
            throw $e;
        }
    }
}

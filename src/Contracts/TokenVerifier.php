<?php

namespace MedSchoolCoach\LumenAuth0\Contracts;

use Auth0\SDK\Exception\InvalidTokenException;

interface TokenVerifier
{
    const BASE_URI_KEY = 'base_uri';

    /**
     * Verifies and decodes a JWT.
     *
     * @param string $token Raw JWT string.
     * @param array $options Options to adjust the verification. Can be:
     *      - "leeway" clock tolerance in seconds for the current check only. See $leeway above for default.
     *
     * @return array
     *
     * @throws InvalidTokenException Thrown if:
     *      - Token is missing (expected but none provided)
     *      - Signature cannot be verified
     *      - Token algorithm is not supported
     *      - Any claim-based test fails
     */
    public function verify(string $token, array $options = []): array;
}

<?php

namespace MedSchoolCoach\LumenAuth0;

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Token;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;


/**
 * Class Auth0Verifier
 * @package MedSchoolCoach\LumenAuth0
 */
class Auth0Verifier
{
    private Auth0 $auth0;
    private Token|null $token = null;

    public function __construct()
    {
        $this->auth0 = new \Auth0\SDK\Auth0([
            'strategy' => \Auth0\SDK\Configuration\SdkConfiguration::STRATEGY_API,
            'domain' => auth0_config('domain'),
            'clientId' => auth0_config_client('client_id'),
            'clientSecret' => auth0_config_client('client_api_secret'),
            'audience' => [auth0_config('audience')],
        ]);

        $tokenCache = new \Symfony\Component\Cache\Adapter\FilesystemAdapter();
        $auth0->configuration()->setTokenCache($tokenCache);
    }

    /**
     * @param  string  $token
     * @return bool
     * @throws InvalidTokenException
     */
    public function check(?string $token): bool
    {
        if (!$token) {
            return false;
        }

        try {
            // Trim whitespace from token string.
            $token = trim($token);

            // Remove the 'Bearer ' prefix, if present, in the event we're getting an Authorization header that's using it.
            if (substr($token, 0, 7) === 'Bearer ') {
                $token = substr($token, 7);
            }

            $this->decoded = $this->auth0->decode($token, null, null, null, null, null, null,
                \Auth0\SDK\Token::TYPE_TOKEN);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    public function getInfo(string $token): ?array
    {
        $token = $this->check($token);

        return [
            'id' => $this->decoded->getSubject(),
            'roles' => $this->decoded->toArray()['https://'.auth0_config('domain').'/roles'] ?? [],
            'sub' => $this->decoded->getSubject(),
        ];
    }
}

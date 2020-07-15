<?php

namespace MedSchoolCoach\LumenAuth0;

use MedSchoolCoach\HttpClient\Request;
use Auth0\SDK\Exception\InvalidTokenException;
use Illuminate\Support\Facades\Cache;
use Auth0\SDK\API\Helpers\ApiClient;
use MedSchoolCoach\LumenAuth0\Models\UserRoles;

/**
 * Class Auth0Service
 * @package MedSchoolCoach\LumenAuth0
 */
class Auth0Service
{
    const GRANT_TYPE_CLIENT_CREDENTIALS = 'client_credentials';
    const OAUTH_TOKEN_SEGMENT = 'oauth/token';
    const CACHE_AUTH0_OAUTH_TOKEN_KEY = 'auth0.api.oauth.token';
    const API_SEGMENT = 'api/v2/';

    /**
     * @var Request
     */
    private $httpRequest;

    /**
     * Auth0Service constructor.
     * @param Request $httpRequest
     */
    public function __construct(Request $httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function getOauthToken(): string
    {
        if (Cache::has(self::CACHE_AUTH0_OAUTH_TOKEN_KEY)) {
            return Cache::get(self::CACHE_AUTH0_OAUTH_TOKEN_KEY);
        }

        $response = $this->httpRequest->post(auth0_config('api_domain').self::OAUTH_TOKEN_SEGMENT, [
            "client_id" => auth0_config_client('client_api_id'),
            "client_secret" => auth0_config_client('client_api_secret'),
            "audience" => auth0_config('api_audience'),
            "grant_type" => self::GRANT_TYPE_CLIENT_CREDENTIALS
        ]);

        throw_if(! $response->has('access_token') || ! $response->has('expires_in'),
            new InvalidTokenException());

        return Cache::remember(
            self::CACHE_AUTH0_OAUTH_TOKEN_KEY,
            $response->get('expires_in') - 90,
            function () use ($response) {
                return $response->get('access_token');
            });
    }

    /**
     * @return ApiClient
     * @throws \Throwable
     */
    protected function getApiClient(): ApiClient
    {
        $authHeader = new \Auth0\SDK\API\Header\Header('Authorization', 'Bearer '.$this->getOauthToken());

        return new ApiClient([
            'basePath' => '',
            'domain' => auth0_config('domain').self::API_SEGMENT,
            'headers' => [$authHeader]
        ]);
    }

    /**
     * @param string $userId
     * @return UserRoles
     * @throws \Auth0\SDK\Exception\EmptyOrInvalidParameterException
     * @throws \Throwable
     */
    public function getUserRoles(string $userId)
    {
        $users = new \Auth0\SDK\API\Management\Users($this->getApiClient());

        return new UserRoles($users->getRoles($userId));
    }
}

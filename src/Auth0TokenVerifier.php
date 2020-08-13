<?php

namespace MedSchoolCoach\LumenAuth0;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use MedSchoolCoach\LumenAuth0\Contracts\TokenVerifier;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;

/**
 * Class Auth0TokenVerifier
 * @package MedSchoolCoach\LumenAuth0
 */
class Auth0TokenVerifier extends \Auth0\SDK\Helpers\Tokens\TokenVerifier implements TokenVerifier
{
    /**
     * @var string
     */
    private $domain;

    /**
     * @var string
     */
    protected $audience;

    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $jwksUri;

    /**
     * @var CacheRepository
     */
    private $cache;

    /**
     * Auth0TokenVerifier constructor.
     * @param string $domain
     * @param string $clientId
     * @param string $jwksUri
     * @param CacheRepository $cache
     */
    public function __construct(string $domain, string $audience, string $clientId, string $jwksUri, CacheRepository $cache)
    {
        $this->domain = $domain;
        $this->clientId = $clientId;
        $this->audience = $audience;
        $this->jwksUri = $jwksUri;
        $this->cache = $cache;

        $sig = new AsymmetricVerifier(
            new JWKFetcher($this->cache, $this->getFetcherOptions()));

        parent::__construct($this->domain, $this->audience, $sig);
    }

    /**
     * @return array
     */
    protected function getFetcherOptions()
    {
        return [self::BASE_URI_KEY => $this->jwksUri];
    }
}

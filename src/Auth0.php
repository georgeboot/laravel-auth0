<?php

declare(strict_types=1);

namespace Auth0\Laravel;

/**
 * Service that provides access to the Auth0 SDK.
 */
final class Auth0
{
    public const SDK_VERSION = '7.0.0';

    private ?\Auth0\SDK\Auth0 $sdk = null;

    private ?\Auth0\SDK\Configuration\SdkConfiguration $configuration = null;

    /**
     * Auth0 service constructor.
     *
     * @param \Auth0\SDK\Configuration\SdkConfiguration|array<string, mixed> $configuration
     *
     * @throws \Auth0\SDK\Configuration\SdkConfiguration
     */
    public function __construct(
        \Closure $app
    ) {
        $this->configuration = new \Auth0\SDK\Configuration\SdkConfiguration($app()->make('config')->get('auth0'));
    }

    /**
     * Creates an instance of the Auth0-PHP SDK.
     */
    public function getSdk()
    {
        if ($this->sdk === null) {
            $this->sdk = new \Auth0\SDK\Auth0($this->configuration);
        }

        return $this->sdk;
    }

    public function getState()
    {
        return app()->make(\Auth0\Laravel\StateInstance::class);
    }

    // public function test()
    // {
    //     var_dump("HIT");
    // }

    // /**
    //  * Logs the user out from the SDK.
    //  */
    // public function logout(): void
    // {
    //     $this->getSDK()->logout();
    // }

    // /**
    //  * Redirects the user to the hosted login page
    //  */
    // public function login(
    //     $connection = null,
    //     $state = null,
    //     $additional_params = ['scope' => 'openid profile email'],
    //     $response_type = 'code'
    // ) {
    //     if ($connection && ! isset($additional_params['connection'])) {
    //         $additional_params['connection'] = $connection;
    //     }

    //     if ($state && ! isset($additional_params['state'])) {
    //         $additional_params['state'] = $state;
    //     }

    //     $additional_params['response_type'] = $response_type;
    //     $auth_url = $this->sdk->getLoginUrl($additional_params);

    //     return new \Illuminate\Http\RedirectResponse($auth_url);
    // }

    // /**
    //  * If the user is logged in, returns the user information.
    //  *
    //  * @return array|null When logged in, return the User info as described in https://docs.auth0.com/user-profile and the user access token. Otherwise, null.
    //  */
    // public function getUser(): ?array
    // {
    //     // Get the user info from auth0
    //     $user = $this->getSDK()->getUser();

    //     if ($user === null) {
    //         return null;
    //     }

    //     return [
    //         'profile' => $user,
    //         'accessToken' => $this->getSDK()->getAccessToken(),
    //     ];
    // }

    // /**
    //  * @param string $encUser
    //  * @param array  $verifierOptions
    //  *
    //  * @return array
    //  *
    //  * @throws \Auth0\SDK\Exception\InvalidTokenException
    //  */
    // public function decodeJWT(
    //     $encUser,
    //     array $verifierOptions = []
    // ) {
    //     var_dump('decodeJWT');
    //     // $token_issuer = 'https://'.$this->auth0Config['domain'].'/';
    //     // $apiIdentifier = $this->auth0Config['api_identifier'];
    //     // $idTokenAlg = $this->auth0Config['supported_algs'][0] ?? 'RS256';

    //     // $signature_verifier = null;
    //     // if ($idTokenAlg === 'RS256') {
    //     //     $jwksUri = $this->auth0Config['jwks_uri'] ?? 'https://'.$this->auth0Config['domain'].'/.well-known/jwks.json';
    //     //     $jwks_fetcher = new JWKFetcher($this->auth0Config['cache_handler']);
    //     //     $jwks = $jwks_fetcher->getKeys($jwksUri);
    //     //     $signature_verifier = new AsymmetricVerifier($jwks);
    //     // } elseif ($idTokenAlg === 'HS256') {
    //     //     $signature_verifier = new SymmetricVerifier($this->auth0Config['client_secret']);
    //     // } else {
    //     //     throw new \Auth0\SDK\Exception\InvalidTokenException('Unsupported token signing algorithm configured. Must be either RS256 or HS256.');
    //     // }

    //     // // Use IdTokenVerifier since Auth0-issued JWTs contain the 'sub' claim, which is used by the Laravel user model
    //     // $token_verifier = new TokenVerifier(
    //     //     $token_issuer,
    //     //     $apiIdentifier,
    //     //     $signature_verifier
    //     // );

    //     // $this->user = $token_verifier->verify($encUser, $verifierOptions);
    //     return $this->user;
    // }

    // public function getIdToken()
    // {
    //     return $this->getSDK()->getIdToken();
    // }

    // public function getAccessToken()
    // {
    //     return $this->getSDK()->getAccessToken();
    // }

    // public function getRefreshToken()
    // {
    //     return $this->getSDK()->getRefreshToken();
    // }
}

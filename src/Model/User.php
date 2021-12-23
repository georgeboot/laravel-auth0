<?php

namespace Auth0\Laravel\Model;

abstract class User implements \Illuminate\Contracts\Auth\Authenticatable
{
    private array $useprofiler;
    private ?string $idToken;
    private ?string $accessToken;
    private ?array $accessTokenScope;
    private ?int $accessTokenExpiration;
    private ?bool $accessTokenExpired;
    private ?string $refreshToken;

    /**
     * \Auth0\Laravel\Model\User constructor.
     */
    public function __construct(
        array $profile,
        ?string $idToken,
        ?string $accessToken,
        ?array $accessTokenScope,
        ?int $accessTokenExpiration,
        ?bool $accessTokenExpired,
        ?string $refreshToken
    ) {
        $this->profile = $profile;
        $this->idToken = $idToken;
        $this->accessToken = $accessToken;
        $this->accessTokenScope = $accessTokenScope;
        $this->accessTokenExpiration = $accessTokenExpiration;
        $this->accessTokenExpired = $accessTokenExpired;
        $this->refreshToken = $refreshToken;
    }

    /**
     * Add a generic getter to get all the properties of the user.
     *
     * @return mixed|null Returns the related value, or null if not set.
     */
    public function __get(
        string $name
    ) {
        if (! array_key_exists($name, $this->profile)) {
            return null;
        }

        return $this->profile[$name];
    }

    /**
     * Return a JSON-encoded representation of the user.
     */
    public function __toString(): string
    {
        return json_encode($this->profile, JSON_THROW_ON_ERROR, 512);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        if (isset($this->profile['sub'])) {
            return $this->profile['sub'];
        }

        return $this->profile['user_id'];
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword(): string
    {
        return '';
    }

    /**
     * Get the token value for the "remember me" session.
     */
    public function getRememberToken(): string
    {
        return '';
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     */
    public function setRememberToken(
        $value
    ): void {
    }

    /**
     * Get the column name for the "remember me" token.
     */
    public function getRememberTokenName(): string
    {
        return '';
    }
}

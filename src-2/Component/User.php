<?php

declare(strict_types=1);

namespace Auth0\Laravel\Component;

/**
 * This class represents a generic user initialized with the user information
 * given by Auth0 and provides a way to access to the user profile.
 */
final class User implements \Illuminate\Contracts\Auth\Authenticatable, \Auth0\Laravel\Contract\Component\User
{
    /**
     * An array representing the user's profile.
     *
     * @var array<string, mixed>
     */
    private array $profile;

    /**
     * An array representing the user's profile.
     *
     * @var string|null
     */
    private $token;

    /**
     * Auth0User constructor.
     *
     * @param array<string, mixed> $profile
     * @param string|null          $token
     */
    public function __construct(
        array $profile,
        ?string $token = null
    ) {
        $this->profile = $profile;
        $this->token = $token;
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
        return $this->token ?? '';
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

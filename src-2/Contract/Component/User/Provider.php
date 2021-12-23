<?php

declare(strict_types=1);

namespace Auth0\Laravel\Contract\Component\User;

interface Provider
{
    /**
     * Retrieve a user by their unique identifier.
     *
     * @param mixed $identifier
     */
    public function retrieveById(
        $identifier
    ): ?\Illuminate\Contracts\Auth\Authenticatable;

    /**
     * Required method. SDK does not implement this.
     */
    public function retrieveByToken(
        $identifier,
        $token
    ): ?\Illuminate\Contracts\Auth\Authenticatable;

    /**
     * Required method. SDK does not implement this.
     */
    public function updateRememberToken(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        $token
    ): void;

    /**
     * Parse, verify and validate a provided JSON Web Token (JWT).
     *
     * @param array $credentials
     */
    public function retrieveByCredentials(
        array $credentials
    ): ?\Illuminate\Contracts\Auth\Authenticatable;

    /**
     * Required method. SDK does not implement this.
     */
    public function validateCredentials(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        array $credentials
    ): bool;
}

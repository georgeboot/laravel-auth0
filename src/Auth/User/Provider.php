<?php

declare(strict_types=1);

namespace Auth0\Laravel\Auth\User;

final class Provider implements \Illuminate\Contracts\Auth\UserProvider
{
    protected Repository $repository;

    protected \Auth0\Laravel\Auth0 $service;

    /**
     * Auth0UserProvider constructor.
     *
     * @param \Auth0\Laravel\Auth\User\Repository $repository
     * @param \Auth0\Laravel\Auth0                $auth0
     */
    public function __construct(
        Repository $repository,
        \Auth0\Laravel\Auth0 $auth0
    ) {
        $this->repository = $repository;
        $this->auth0 = $auth0;
    }

    /**
     * Returns a \Auth0\Laravel\Model\Stateless\User instance from an Id Token.
     */
    public function retrieveById(
        $identifier
    ): ?\Illuminate\Contracts\Auth\Authenticatable {
        // Process $identifier here ...
        return $this->repository->fromAccessToken($identifier);
    }

    /**
     * Returns a \Auth0\Laravel\Model\Stateless\User instance from an Access Token.
     */
    public function retrieveByToken(
        $identifier,
        $token
    ): ?\Illuminate\Contracts\Auth\Authenticatable {
        // Process $identifier here ...
        return $this->repository->fromAccessToken(
            $credentials['user'] ?? null,
            $credentials['idToken'] ?? null,
            $credentials['accessToken'] ?? null,
            $credentials['accessTokenScope'] ?? null,
            $credentials['accessTokenExpiration'] ?? null,
            $credentials['accessTokenExpired'] ?? null,
            $credentials['refreshToken'] ?? null,
        );
    }

    /**
     * Returns a \Auth0\Laravel\Model\Stateless\User instance translated from an Auth0-PHP SDK session.
     */
    public function retrieveByCredentials(
        array $credentials
    ): ?\Illuminate\Contracts\Auth\Authenticatable {
        return $this->repository->fromSession(
            $credentials['user'] ?? null,
            $credentials['idToken'] ?? null,
            $credentials['accessToken'] ?? null,
            $credentials['accessTokenScope'] ?? null,
            $credentials['accessTokenExpiration'] ?? null,
            $credentials['accessTokenExpired'] ?? null,
            $credentials['refreshToken'] ?? null,
        );
    }

    /**
     * Returns true if the provided $user's unique identifier matches the credentials payload.
     */
    public function validateCredentials(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        array $credentials
    ): bool {
        return false;
    }

    /**
     * Method required by interface. Not supported.
     */
    public function updateRememberToken(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        $token
    ): void {
    }
}

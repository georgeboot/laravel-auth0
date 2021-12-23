<?php

declare(strict_types=1);

namespace Auth0\Laravel\Component\User;

final class Provider implements \Illuminate\Contracts\Auth\UserProvider, \Auth0\Laravel\Contract\Component\User\Provider
{
    protected \Auth0\Laravel\Component\User\Repository $repository;

    protected \Auth0\Laravel\Auth0 $service;

    /**
     * Auth0UserProvider constructor.
     *
     * @param \Auth0\Laravel\Component\User\Repository $userRepository
     * @param \Auth0\Laravel\Auth0                     $auth0
     */
    public function __construct(
        \Auth0\Laravel\Component\User\Repository $userRepository,
        \Auth0\Laravel\Auth0 $auth0
    ) {
        $this->userRepository = $userRepository;
        $this->auth0 = $auth0;
    }

    /**
     * @inheritdoc
     */
    public function retrieveById(
        $identifier
    ): ?\Illuminate\Contracts\Auth\Authenticatable {
        return $this->userRepository->getUserByIdentifier($identifier);
    }

    /**
     * @inheritdoc
     */
    public function retrieveByToken(
        $identifier,
        $token
    ): ?\Illuminate\Contracts\Auth\Authenticatable {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function updateRememberToken(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        $token
    ): void {
    }

    /**
     * @inheritdoc
     */
    public function retrieveByCredentials(
        array $credentials
    ): ?\Illuminate\Contracts\Auth\Authenticatable {
        $token = $credentials['token'] ?? null;

        if ($token !== null) {
            return $this->userRepository->getUserByDecodedJWT($this->auth0->decodeJWT($token));
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function validateCredentials(
        \Illuminate\Contracts\Auth\Authenticatable $user,
        array $credentials
    ): bool {
        return false;
    }
}

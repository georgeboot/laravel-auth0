<?php

declare(strict_types=1);

namespace Auth0\Laravel\Component\User;

final class Repository implements \Auth0\Laravel\Contract\Component\User\Repository
{
    /**
     * @inheritdoc
     */
    public function create(
        array $user
    ): \Illuminate\Contracts\Auth\Authenticatable {
        return new \Auth0\Laravel\Component\User($user['profile'], $user['accessToken']);
    }

    /**
     * @inheritdoc
     */
    public function get(
        string $id
    ): \Illuminate\Contracts\Auth\Authenticatable {
        $session = \app('auth0')->getUser();

        if ($session !== null) {
            $user = $this->create($session);

            if ($user->getAuthIdentifier() === $id) {
                return $user;
            }
        }

        throw \Auth0\Laravel\Exception\UserException::notFound();
    }
}

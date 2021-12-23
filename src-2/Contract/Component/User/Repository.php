<?php

declare(strict_types=1);

namespace Auth0\Laravel\Contract\Component\User;

interface Repository
{
    /**
     * @param array $user
     */
    public function create(
        array $user
    ): \Illuminate\Contracts\Auth\Authenticatable;

    /**
     * @param string|int|null $id
     */
    public function get(
        string $id
    ): \Illuminate\Contracts\Auth\Authenticatable;
}

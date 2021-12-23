<?php

declare(strict_types=1);

namespace Auth0\Laravel\Event\Stateful;

final class AuthenticationSucceeded
{
    public \Illuminate\Contracts\Auth\Authenticatable $user;

    public function __construct(
        \Illuminate\Contracts\Auth\Authenticatable $user
    ) {
        $this->user = $user;
    }
}

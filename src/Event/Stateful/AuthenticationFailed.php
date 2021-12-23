<?php

declare(strict_types=1);

namespace Auth0\Laravel\Event\Stateful;

final class AuthenticationFailed
{
    public \Auth0\SDK\Exception\Auth0Exception $exception;

    public bool $throwException = true;

    public function __construct(
        \Auth0\SDK\Exception\Auth0Exception $exception,
        bool $throwException = true
    ) {
        $this->$exception = $exception;
        $this->$throwException = $throwException;
    }
}

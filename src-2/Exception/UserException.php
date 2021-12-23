<?php

declare(strict_types=1);

namespace Auth0\Laravel\Exception;

/**
 * @codeCoverageIgnore
 */
final class UserException extends \Exception implements \Auth0\SDK\Exception\Auth0Exception
{
    public const MSG_USER_NOT_FOUND_GENERIC = 'User not found';

    public static function notFound(
        ?\Throwable $previous = null
    ): self {
        return new self(self::MSG_USER_NOT_FOUND_GENERIC, 0, $previous);
    }
}

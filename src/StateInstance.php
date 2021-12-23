<?php

declare(strict_types=1);

namespace Auth0\Laravel;

final class StateInstance
{
    public function __construct(
        \Closure $app
    ) {
        var_dump("Hello world.");
    }
}

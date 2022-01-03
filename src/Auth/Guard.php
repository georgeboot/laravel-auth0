<?php

declare(strict_types=1);

namespace Auth0\Laravel\Auth;

final class Guard implements \Illuminate\Contracts\Auth\Guard
{
    /**
     * The user provider implementation.
     *
     * @var \Illuminate\Contracts\Auth\UserProvider
     */
    protected $provider;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the query string item from the request containing the API token.
     *
     * @var string
     */
    protected $inputKey;

    /**
     * The name of the token "column" in persistent storage.
     *
     * @var string
     */
    protected $storageKey;

    /**
     * Indicates if the API token is hashed in storage.
     *
     * @var bool
     */
    protected $hash = false;

    /**
     * Create a new authentication guard.
     *
     * @param \Illuminate\Contracts\Auth\UserProvider $provider
     * @param \Illuminate\Http\Request $request
     * @param string $inputKey
     * @param string $storageKey
     * @param bool $hash
     */
    public function __construct(
        \Illuminate\Contracts\Auth\UserProvider $provider,
        \Illuminate\Http\Request $request,
        $inputKey = 'api_token',
        $storageKey = 'api_token',
        $hash = false
    ) {
        $this->hash = $hash;
        $this->request = $request;
        $this->provider = $provider;
        $this->inputKey = $inputKey;
        $this->storageKey = $storageKey;
    }

    /**
     * Set the current user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     */
    public function login(
        \Illuminate\Contracts\Auth\Authenticatable $user
    ): self {
        $this->getInstance()->setUser($user);
        return $this;
    }

    /**
     * Set the current user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     */
    public function logout(): self {
        $this->getInstance()->setUser(null);
        app('auth0')->getSdk()->clear();
        return $this;
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest(): bool
    {
        return ! $this->check();
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return mixed
     */
    public function id()
    {
        $user = $this->user();

        if ($user !== null) {
            return $user->getAuthIdentifier();
        }
    }

    /**
     * Validate a user's credentials.
     *
     * @param array $credentials
     */
    public function validate(
        array $credentials = []
    ): bool {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }

        $credentials = [$this->storageKey => $credentials[$this->inputKey]];

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }

    /**
     * Determine if the guard has a user instance.
     */
    public function hasUser(): bool
    {
        return ! is_null($this->getInstance()->getUser());
    }

    /**
     * Set the current user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     */
    public function setUser(
        \Illuminate\Contracts\Auth\Authenticatable $user
    ): self {
        $user = $this->getInstance()->setUser($user);
        return $this;
    }

    /**
     * Set the current request instance.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function setRequest(
        \Illuminate\Http\Request $request
    ): self {
        $this->request = $request;
        return $this;
    }

    /**
     * Get the currently authenticated user.
     */
    public function user(): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $instance = $this->getInstance();
        $user = $instance->getUser();

        if ($user === null) {
            $stateful = app('auth0')->getSdk()->getCredentials();

            if ($stateful !== null) {
                $user = $this->provider->retrieveByCredentials((array) $stateful);
            }
        }

        if ($user === null) {
            $token = $this->getTokenForRequest();

            if ($token !== null) {
                $user = $this->provider->retrieveByToken([], $token);
            }
        }

        if ($user !== null) {
            $instance->setUser($user);
        }

        return $user;
    }

    /**
     * Get the token for the current request.
     */
    public function getTokenForRequest(): ?string
    {
        $token = $this->request->query($this->inputKey);

        if ($token === null) {
            $token = $this->request->input($this->inputKey);
        }

        if ($token === null) {
            $token = $this->request->bearerToken();
        }

        if ($token === null) {
            $token = $this->request->getPassword();
        }

        return $token;
    }

    private function getInstance(): \Auth0\Laravel\StateInstance
    {
        return app()->make(\Auth0\Laravel\StateInstance::class);
    }
}

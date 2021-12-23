<?php

declare(strict_types=1);

namespace Auth0\Laravel\Http\Controller;

final class Callback
{
    public function __invoke(
        \Illuminate\Http\Request $request,
        \Auth0\Laravel\Contract\Auth0UserRepository $userRepository
    ): \Illuminate\Http\RedirectResponse
    {
        $service = app('auth0');
        $profile = $service->getUser();

        $user = $profile ? $userRepository->getUserByUserInfo($profile) : null;

        if ($user !== null) {
            event(new \Auth0\Laravel\Event\LoggedIn($user));
            \auth()->login($user, $service->rememberUser());
        }

        return \redirect()->intended('/');
    }
}

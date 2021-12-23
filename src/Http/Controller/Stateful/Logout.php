<?php

declare(strict_types=1);

namespace Auth0\Laravel\Http\Controller\Stateful;

final class Logout
{
    public function __invoke(
        \Illuminate\Http\Request $request
    ): \Illuminate\Http\RedirectResponse
    {
        var_dump("LOGOUT() HIT");
        exit;

        // if (auth()->guard('auth0')->check()) {
        //     auth()->login(Auth::guard('auth0')->user());
        // }

        // $service = app('auth0');
        // $profile = $service->getUser();

        // $user = $profile ? $userRepository->getUserByUserInfo($profile) : null;

        // if ($user !== null) {
        //     event(new \Auth0\Laravel\Event\LoggedIn($user));
        //     \auth()->login($user, $service->rememberUser());
        // }

        // return \redirect()->intended('/');
    }
}

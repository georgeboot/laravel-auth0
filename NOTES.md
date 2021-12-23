# ROUTE MIDDLEWARE
These should be assigned in $routeMiddleware in `app/Http/Kernel.php`.

## Stateless Applications:

    ### 'auth0.authorize' => \Auth0\Laravel\Http\Middleware\Stateless\Authorize::class
        Will parse a available access token.
        If one is not available, throw an HTTP error.
        Otherwise, set Auth to use the JWT pseudo-user.

    ### 'auth0.authorize.op+tional' => \Auth0\Laravel\Http\Middleware\Stateless\AuthorizeOptional::class
        Same as above, but if there is no token, it will set the active user to null without an error.

## Stateful Applications:

    ### 'auth0.authenticate' => \Auth0\Laravel\Http\Middleware\Stateful\Authenticate::class
        Will look for an available session for the end user based ok their device cookies.

        If a session is available:
        - Sets the active user to a \Auth0\Laravel\Component\User instance.
        - You can query this with standard Laravel commands like Auth::check(), Auth::user(), etc.
        Otherwise:
        - Will redirect the end user to a route named 'login'.

    ### 'auth0.authenticate.optional' => \Auth0\Laravel\Http\Middleware\Stateful\AuthenticateOptional::class
        Same as above, except the user will not be redirected if a session is not available.
        This is useful in routes where you want to allow both authenticated users or guests.

    ### 'auth0.organization.invitation' => \Auth0\Laravel\Http\Middleware\Stateful\OrganizationInvitation::class
        When present on a route, if Auth0 Organization invite parameters are present in the request,
        the end user will be redirected to a named route called 'login'. This route should be configured
        with the \Auth0\Laravel\Http\Controller\Stateful\Login controller to properly handle the
        Organization invitation.

    ### 'auth0.organization.invitation.required' => \Auth0\Laravel\Http\Middleware\Stateful\OrganizationInvitationRequired::class
        Same as above, but if organization parameters are not present, a 403 Unauthorized error will be thrown.

# ROUTE CONTROLLERS

## Stateful Applications:

    ### Route::get('/login', \Auth0\Laravel\Http\Controller\Stateful\Login::class)->name('login');
        This route will redirect the end user to the configured Universal Login Page if a session is not available.
        Otherwise, it will redirect to the '/' route.

    ### Route::get('/callback', \Auth0\Laravel\Http\Controller\Stateful\Callback::class)->name('callback');
        This is the route the end user should land on after completing the authentication step started with the 'login' route above.
        This finalizes the authentication step. If successful, the user will be redirected to the '/' route.

    ### Route::get('/logout', \Auth0\Laravel\Http\Controller\Stateful\Logout::class)->name('logout');
        Log the user out of any available session, and redirect them to the Auth0 /logout endpoint to clear their Auth0 session.

## Support/Troubleshooting:

    ### Route::get('/debug', \Auth0\Laravel\Http\Controller\Stateful\Debug::class);
        This route should NEVER be used in production. Echos some basic session information to the browser to help in
        troubleshooting during development. If you reach out to Auth0 Support, you may be asked to temporarily add this
        controller route to help aid us in determining any issues.

<?php

namespace Emtudo\Units\Auth\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

/**
 * Class Api.
 *
 * Authentication API routes.
 */
class Api extends RouteFile
{
    /**
     * Declare API Routes.
     */
    public function routes()
    {
        // login routes.
        $this->loginRoutes();

        // password reset routes.
        $this->passwordResetRoutes();
    }

    /**
     * Routes related to password recovery.
     */
    protected function passwordResetRoutes()
    {
        // sends a password recovery email.
        $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('forgot');

        // set's a new password based on the user's email and a reset token.
        $this->router->post('password/reset', 'ResetPasswordController@reset')->name('reset');
    }

    /**
     * Routes related with login, either credentials or token renewal.
     */
    protected function loginRoutes()
    {
        // login (generate a JWT token) from User's credentials (email and password).
        $this->router->post('login', 'LoginController@login')->name('login');

        // login (generate a JWT token) from another, valid or renewable JWT token.
        $this->router->post('refresh', 'LoginController@refresh')->name('refresh');
    }
}

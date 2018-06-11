<?php

namespace Emtudo\Units\Settings\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

/**
 * Api Routes.
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 */
class Api extends RouteFile
{
    /**
     * Declare API Routes.
     */
    public function routes()
    {
        $this->avatarRoutes();
        $this->documentRoutes();
        $this->profileRoutes();
    }

    public function avatarRoutes()
    {
        $this->router->post('users/me/avatars', [
            'uses' => 'AvatarController@update',
            'as' => 'update_avatar',
        ]);
        $this->router->post('users/{user}/avatars', [
            'uses' => 'AvatarController@updateUser',
            'as' => 'update_avatar',
        ]);
    }

    public function documentRoutes()
    {
        // update document
        $this->router->post('users/me/documents', [
            'uses' => 'DocumentController@update',
            'as' => 'update_document',
        ]);

        $this->router->post('users/{user}/documents', [
            'uses' => 'DocumentController@updateUser',
            'as' => 'update_document',
        ]);

        // get document
        $this->router->get('profile/me/documents/{kind}', [
            'uses' => 'DocumentController@getDocumetByKind',
            'as' => 'get_document',
        ]);

        // delete document
        $this->router->delete('profile/me/documents/{kind}', [
            'uses' => 'DocumentController@destroy',
            'as' => 'delete_document',
        ]);
    }

    public function profileRoutes()
    {
        // edit profile
        $this->router->get('profile/me', [
            'uses' => 'ProfileController@show',
            'as' => 'profile.show',
        ]);

        // update
        $this->router->put('profile/me', [
            'uses' => 'ProfileController@update',
            'as' => 'profile.update',
        ]);
    }
}

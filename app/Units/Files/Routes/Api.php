<?php

namespace Emtudo\Units\Files\Routes;

use Emtudo\Support\Http\Routing\RouteFile;

/**
 * Api Routes.
 *
 * This file is where you may define all of the routes that are handled
 * by your application. Just tell Laravel the URIs it should respond
 * to using a Closure or controller method. Build something great!
 */
class Api extends RouteFile
{
    /**
     * Declare Api Routes.
     */
    public function routes()
    {
        // temporary file upload.
        $this->router->post('temporary', [
            'uses' => 'FileController@temporary',
            'as' => 'temporary',
        ]);

        // temporary file upload.
        $this->router->get('{uuid}', [
            'uses' => 'FileController@show',
            'as' => 'show',
        ]);

        // file download url.
        $this->router->get('{uuid}/download', [
            'uses' => 'FileController@download',
            'as' => 'download',
        ]);

        // List of files
        $this->router->get('', [
            'uses' => 'FileController@index',
            'as' => 'files.index',
        ]);

        // Save file to tenant
        $this->router->post('', [
            'uses' => 'FileController@store',
            'as' => 'files.store',
        ]);
    }
}

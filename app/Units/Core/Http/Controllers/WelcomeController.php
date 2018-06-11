<?php

namespace Emtudo\Units\Core\Http\Controllers;

use Emtudo\Support\Http\Controller;

class WelcomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return env('APP_NAME');
    }
}

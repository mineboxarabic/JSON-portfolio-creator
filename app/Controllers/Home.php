<?php

namespace App\Controllers;

class Home extends BaseController
{
    public static $images ;
    public function index()
    {
        return view('welcome_message');
    }

}

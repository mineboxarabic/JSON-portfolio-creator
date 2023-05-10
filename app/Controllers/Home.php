<?php

namespace App\Controllers;

class Home extends BaseController
{
    public static $images ;
    public function index()
    {
        return view('include/inc_header').view('MainView');
    }

}

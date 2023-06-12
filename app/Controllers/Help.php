<?php

namespace App\Controllers;

use App\Models\Main_Model;

class Help extends BaseController
{

    public function index()
    {
        return view ('helper/index');
    }

}
<?php

namespace App\Controllers\Panel;

use core\Controller;

class Index extends Controller
{
    public function indexAction()
    {
        $this->render('index');
    }
}
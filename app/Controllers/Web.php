<?php


namespace app\Controllers;
use core\Controller;


class Web extends Controller {
    public function indexAction()
    {

        $this->render('bootstrap/pages/web',$data);
    }

}
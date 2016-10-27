<?php
/**
 * Created by PhpStorm.
 * User: wellington
 * Date: 04/10/2016
 * Time: 15:05
 */

namespace app\Controllers;
use core\Controller;


class Exercicios extends Controller {
    public function indexAction()
    {

        $this->render('bootstrap/pages/exercicios',$data);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/08/16
 * Time: 10:36
 */

namespace app\Controllers;
use core\Controller;

class Form extends Controller
{
    public function indexAction()
    {
       

        $this->render('bootstrap/pages/formulario',$data);
    }

}
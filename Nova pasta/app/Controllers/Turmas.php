<?php
/**
 * Created by PhpStorm.
 * User: wellington
 * Date: 14/08/16
 * Time: 18:32
 */

namespace app\Controllers;
use core\Controller;


class Turmas extends Controller {
    public function indexAction()
    {

        $this->render('bootstrap/pages/turmas',$data);
    }

} 
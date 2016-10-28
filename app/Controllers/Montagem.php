<?php
/**
 * Created by PhpStorm.
 * User: wellington
 * Date: 28/10/2016
 * Time: 16:22
 */
?>
<?php

namespace app\Controllers;
use core\Controller;


class Montagem extends Controller {
    public function indexAction()
    {

        $this->render('bootstrap/pages/montagem',$data);
    }

}
?>
<?php
/**
 * Created by PhpStorm.
 * User: wellington
 * Date: 28/10/2016
 * Time: 16:31
 */
?>
<?php
/**
 * Created by PhpStorm.
 * User: wellington
 * Date: 04/10/2016
 * Time: 15:05
 */

namespace app\Controllers;
use core\Controller;


class Web extends Controller {
    public function indexAction()
    {

        $this->render('bootstrap/pages/web',$data);
    }

}

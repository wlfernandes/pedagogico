<?php

namespace App\Controllers\Panel;

use core\Controller;
use core\Services\Auth;
use core\Services\Session;

/**
 * Class Login = Controller responsável por rendenrizar a página de login
 * @package App\Controllers\Panel
 */

class Login extends Controller
{
    public function indexAction()
    {
        # Se o usuário enviar oformulário de login, verificar se pode autenticar
        if($_POST)
        {
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            if(Auth::login($email,$senha))
            {
                $this->redirect('index');
            }
            else
                $this->message('Não foi possível autenticar. Tente novamente.','danger');
        }

        if(Session::get('auth'))
            header('Location: '.BASE_ADM);

        $this->render('login');
    }


    /**
     * Sair do painel
     */
    public function sair()
    {
        Auth::loggof();
    }
}
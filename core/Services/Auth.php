<?php

namespace core\Services;

/**
 * Class Auth = Responsável por autenticar o usuário no painel e colocar restrição nas páginas do painel
 * @package core\Services
 */

class Auth
{
    /**
     * Logar o usuário
     * @param $email
     * @param $senha
     * @return bool
     */
    public static function login($email,$senha)
    {
        $model = new \app\Models\Usuario();
        $senha = md5($senha);
        $user = $model->find(['email=:email AND senha=:senha','email='.$email.'&senha='.$senha]);
        if($user)
        {
            Session::set('auth',$user->data(true));
            return true;
        }
        else
            return false;
    }


    /**
     * Desloga o usuário
     */
    public static function loggof()
    {
        $_SESSION = [];
        session_destroy();
        header('Location: '.BASE_ADM);
    }


    /**
     * Verifica se o usuário está alogado
     */
    public static function restrict($nivel=0)
    {
        if(!Session::get('auth'))
        {
            $_SESSION = [];
            session_destroy();
            if($_SERVER['REQUEST_URI'] != '/painel/login')
                header('Location: '.BASE_ADM.'/login');
        }
    }
}
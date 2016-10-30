<?php

namespace core\Services;

/**
 * Class Session = Classe básica para manipular sessões
 * @package core\Services
 */

class Session
{
    private static $Session = null;

    /**
     * Verifica se umaa sessão foi inciada
     */
    private static function init()
    {
        if(!self::$Session)
        {
            session_start();
            self::$Session = session_id();
        }
    }

    /**
     * Cria uma sesão
     * @param $name = Nome da sessão a ser criada
     * @param string $val = Valor a ser guardado nessa sessão
     */
    public static function set($name,$val='')
    {
        self::init();
        $_SESSION[$name] = $val;
    }

    /**
     * Recupera uma sessão
     * @param $name = Nome da sessão a ser recuperada
     * @return mixed
     */
    public static function get($name)
    {
        self::init();
        if(@$val=$_SESSION[$name])
            return $val;
    }

    /**
     * Eliminar a sessão do usuário
     * @param null $name = Remove uma determinada sessão
     */
    public static function destroy($name=null)
    {
        self::init();
        if($name)
            unset($_SESSION[$name]);
        else
            session_destroy();
    }

}
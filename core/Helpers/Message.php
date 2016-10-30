<?php

namespace core\Helpers;

use core\Services\Session;

/**
 * Class Message = Responsável por gerar as mensagens do sistema
 * Faz usuo do serviço de sessão.
 * @package core\Helpers
 */

class Message
{
    /**
     * Criar uma mensagem
     * @param $message = Mensagem a ser exibida
     * @param $type = Tipo de mensagem
     */
    public static function set($message,$type)
    {
        $html = <<<html
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <p class="alert alert-{$type} text-center">{$message}</p>
                </div>
            </div>
        </div>
html;
        Session::set('message',$html);
    }

    /**
     * Recupera a mensagem que foi criada
     * @param string $name = Nome da mensagem a ser recuperada
     * @return mixed = Retorna a mensagems
     */
    public static function get($name='message')
    {
        $message = Session::get($name);
        Session::destroy($name);
        return $message;
    }
}
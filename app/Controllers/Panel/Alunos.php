<?php

namespace App\Controllers\Panel;

use core\Controller;

/**
 * Class Alunos = Controller responsável por gerenciar a página de alunoss
 * @package App\Controllers\Panel
 */

class Alunos extends Controller
{
    public function indexAction()
    {
        $data = $this->model('aluno');
        $this->render('alunos/index',$data);
    }

    public function salvar()
    {

        if($_POST)
        {
            $model = $this->model('aluno');

            if(!$_POST['nome'] || !$_POST['email'] || !$_POST['telefone'] || !$_POST['dataNascimento'] || !$_POST['Turmas_id'])
                $this->message('Todos os campos são obrigatórios','danger');
            else if($model->exists('email',$_POST['email']))
                $this->message('O email informado já existe.','info');
            else
            {
                $_POST['dataNascimento'] = date('Y-m-d H:i:s',strtotime($_POST['dataNascimento']));
                $model->create($_POST);
                $lastid = $model->getLastInsertId();
                if(!$lastid)
                    $this->message('Não foi possível executar a operação :: '.$model->e(),'danger');
                else
                {
                    $this->message('Aluno criado com sucesso','success');
                    $this->redirect('alunos/editar/'.$lastid);
                    return;
                }
            }
        }

        # Variável $data é passada para view tendo as turmas que o usuário póderá selecionar
        $data['turmas'] = $this->model('turmas')->all();
        $this->render('alunos/salvar',$data);
    }

    public function editar($id)
    {
        if(!$id)
            $this->redirect('alunos');

        $model = $this->model('aluno',$id);

        if($_POST)
        {
            if(!$_POST['nome'] || !$_POST['email'] || !$_POST['telefone'] || !$_POST['dataNascimento'] || !$_POST['Turmas_id'])
                $this->message('Todos os campos são obrigatórios','danger');
            else if($model->exists('email',$_POST['email']) && $_POST['email'] != $model->email)
                $this->message('O email informado já existe.','info');
            else
            {
                $_POST['id'] = $id;
                $_POST['dataNascimento'] = date('Y-m-d H:i:s',strtotime($_POST['dataNascimento']));
                $model->create($_POST);
                if(!$model->results() && $model->e())
                    $this->message('Não foi possível executar a operação :: '.$model->e(),'danger');
                else
                {
                    $this->message('Aluno atualizado com sucesso','success');
                    $this->redirect('alunos/editar/'.$id);
                    return;
                }
            }
        }

        # O aluno que foi recuperado é passado para a view para povoar os campos do formulário
        $data['aluno'] = $model;
        # Variável $data é passada para view tendo as turmas que o usuário póderá selecionar
        $data['turmas'] = $this->model('turmas')->all();
        $this->render('alunos/editar',$data);
    }


    public function remover($id)
    {
        $model = $this->model('aluno',$id);
        if(!$model->id)
            $this->message('Registro não encontrado :(','danger');
        else
            $model->remove();

        $this->redirect('alunos');
    }

}
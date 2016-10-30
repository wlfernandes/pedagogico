<?php

namespace App\Controllers\Panel;

use core\Controller;

/**
 * Class Usuarios = Controller responsável por gerenciar as páginas de alunos(listagem, criação eedição)
 * @package App\Controllers\Panel
 */

class Usuarios extends Controller
{
    /**
     * Listagem de alunos
     */
    public function indexAction()
    {
        $data = $this->model('usuario');
        $this->render('usuarios/index',$data);
    }

    /**
     * Salvar um novo aluno
     */
    public function salvar()
    {
        $result = false;
        if ($_POST) {

            /**
             * O método model() do controller instancia um model que está localizado na pasta de models
             * A variável($user) que recebe a instancia está pronta para manipular os métodos de manipulação com o banco de dados
             * Métodos estes que estão localizados e documentados na Classe Model da core.
             */
            $user = $this->model('usuario');

            # Algumas verificações de preencimento de dados
            if (!$_POST['nome'] || !$_POST['email'] || !$_POST['senha'])
                $this->message('Todos os campos são obrigatórios', 'danger');
            elseif ($_POST['senha'] <> $_POST['senha2']) {
                $this->message('Senhas não confere', 'danger');
            }
            elseif ($user->exists('email', $_POST['email'])) {
                $this->message('O email informado já exite', 'danger');
            } else {

                # Atribui cada variável à sua propriedade do objeto que será persistido no banco
                # As propriedades tem de ser os mesmo nomes das colunas da tabela que está sendo manipulada
                $user->nome = $_POST['nome'];
                $user->email = $_POST['email'];
                $user->senha = md5($_POST['senha']);
                $user->tipo = $_POST['tipo'];
                $user->status = isset($_POST['status']) ? 1 : 0;
                $user->data = date('Y-m-d H:i:s');

                # Método save() salva o registro no banco
                $user->save();

                # Uma vez salvo, o ojbeto que acabou de ser persistido recebe id que acabou de ser criado e esse id
                # pode ser recuperada através do método getLastInsertId()
                if ($id = $user->getLastInsertId()) {
                    /**
                     * Tendo obtido o id do último registro, tudo indica que nenhum erro ocorreu
                     * e então mosramos uma mensagem(ver classe que gera as mensagens) para o usuário
                     * e redirecionamos para a página de edição de registro (método editar() ) já passando o id como parâmetro
                     *
                     */
                    $this->message('Registro criado com sucesso', 'success');
                    $this->redirect('usuarios/editar/' . $id);
                } else
                    $this->message('Não foi possível realizar a operação:: ' . $user->e(), 'danger');
                return;
            }
        }

        $this->render('usuarios/salvar');

    }


    /**
     * Atualiza um registro no banco
     * @param $id = id do registro que está vindo na url para ser editado
     */
    public function editar($id)
    {
        /**
         * Todos os passos aqui são semelhantes ao método de salvar.
         */

        # O método model pode receber um segundo parâmetro como sendo o id de um registro
        # Isso fará com que o objeto instanciado já seja o respetivo objeto que está no banco o id especificado
        $user = $this->model('usuario', $id);

        if (!$user->id) {
            $this->message('Registro não encontrado :(', 'danger');
            $this->redirect('usuarios');
        }

        if ($_POST) {
            if (!$_POST['nome'] || !$_POST['email'])
                $this->message('Todos os campos são obrigatórios', 'danger');
            elseif ($_POST['senha'] && ($_POST['senha'] <> $_POST['senha2'])) {
                $this->message('Senhas não confere', 'danger');
            }
            elseif (($_POST['email'] != $user->email) && $user->exists('email', $_POST['email'])) {
                $this->message('O email informado já existe', 'danger');
            } else {
                $user->nome = $_POST['nome'];
                $user->email = $_POST['email'];
                $user->senha = ($pass = $_POST['senha']) ? md5($pass) : $user->senha;
                $user->tipo = $_POST['tipo'];
                $user->status = isset($_POST['status']) ? 1 : 0;
                $user->save();

                # Uma vez salvo, é verificado se alguma linha foi alterada, caso sim, então redireciona para a mesma página
                # Caso contrário informa apenas uma mensagem de errro
                if(!$user->results() && $user->e())
                    $this->message('Não foi possível executar a operação :: '.$user->e(),'danger');
                else{
                    $this->message('Registro atualizado com sucesso', 'success');
                    $this->redirect('usuarios/editar/' . $id);
                    return;
                }
            }
        }

        # O usuário recuperado, é passado para view da página, para que possa povoar os campos do formulário
        $this->render('usuarios/editar', $user);

    }

    /**
     * @param $id = Registro que será removido
     */
    public function remover($id)
    {
        $model = $this->model('usuario',$id);

        if(!$model->id)
            $this->message('Registro não encontrado :(','danger');
        else
            $model->remove();

        $this->redirect('usuarios');
    }


    /**
     * @param $id = id do registro que terá o status alterado
     */
    public function status($id)
    {
        if(!$id)
            $this->redirect('usuarios');

        $model  = $this->model('usuario',$id);
        $model->status = $model->status==1 ? 0 : 1;
        $model->save();
        $this->redirect('usuarios');
    }
}
<?php
namespace Controlador;

use \Modelo\Usuario;
use \Modelo\Solicitacao;
use \Framework\DW3Sessao;

class UsuarioControlador extends Controlador
{
    public function criar()
    {
        $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));

        if ($this->verificarLogado()) {
            $this->redirecionar(URL_RAIZ . 'laboratorio');
        } else {
            $this->visao('usuarios/criar.php', ['usuario' => $usuario, 'mensagem' => DW3Sessao::getFlash('mensagem', null)]);
        }
    }

    public function armazenar()
    {
        $usuario = new Usuario($_POST['email'], $_POST['senha']);
        $usuario2 = Usuario::buscarEmail($_POST['email']);

        $this->setErros($usuario->validarFormularioCriarConta($_POST['email'], $_POST['senha']));

        if ($this->getErro('email') || $this->getErro('nome') || $this->getErro('senha')) {
            $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));
            $this->visao('usuarios/criar.php', ['usuario' => $usuario, 'mensagem' => DW3Sessao::getFlash('mensagem', null)]);
        } else {
            if ($usuario2 != null) {
                $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));
                $this->setErros(['incorreto' => 'Um usuário com este email já foi criado.']);
                $this->visao('usuarios/criar.php', ['usuario' => $usuario, 'mensagem' => DW3Sessao::getFlash('mensagem', null)]);
            } else {
                $usuario->salvar();
                DW3Sessao::setFlash('mensagem', 'Conta criada com sucesso!');
                $this->redirecionar(URL_RAIZ . 'usuarios/criar');
            }
        }
    }

    public function mostrar($id)
    {
        $usuario = Usuario::buscarId($id);
        $receitas = Receita::buscarUsuarioReceitas($id);

        if ($this->verificarLogado()) {
            $this->visao('usuarios/mostrar.php', [
                'usuario' => $usuario,
                'usuarioid' => DW3Sessao::get('usuario'),
                'receitas' => $receitas
            ], 'logado.php');
        } else {
            $this->visao('usuarios/mostrar.php', [
            'usuario' => $usuario,
            'usuarioid' => DW3Sessao::get('usuario'),
            'receitas' => $receitas
            ], 'deslogado.php');
        }

    }
}

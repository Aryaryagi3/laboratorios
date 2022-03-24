<?php
namespace Controlador;

use \Modelo\Solicitacao;
use \Modelo\Usuario;
use \Framework\DW3Sessao;

class SolicitacaoControlador extends Controlador
{
    public function mostrarLabs()
    {
        if ($this->verificarLogado()) {
            $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));

            if ($usuario->getAdministrador() == 1) {
                $this->redirecionar(URL_RAIZ . 'administrador');
            }
            $solicitacoes = $usuario->buscarSolicitacoes(DW3Sessao::get('usuario'));
            $this->visao('laboratorio/index.php', ['solicitacoes' => $solicitacoes, 'usuario' => $usuario]);
        } else {
            $this->redirecionar(URL_RAIZ . 'login');
        }
    }

    public function mostrarLab($id)
    {
        $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));
        $solicitacoes = Solicitacao::buscarLaboratorio($id);

        if ($this->verificarLogado()) {
            $this->visao('laboratorio/mostrar.php', ['usuario' => $usuario, 'mensagem' => DW3Sessao::getFlash('mensagem', null), 'solicitacoes' => $solicitacoes, 'laboratorioId' => $id]);
        } else {
            $this->redirecionar(URL_RAIZ . 'login');
        }
    }

    public function listar()
    {
        $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));
        $solicitacoes = Solicitacao::buscarTodos();

        if ($this->verificarLogado() && $usuario->getAdministrador() == 1) {
            $this->visao('administrador/solicitacoes.php', ['usuario' => $usuario, 'solicitacoes' => $solicitacoes, 'mensagem' => DW3Sessao::getFlash('mensagem', null)]);
        } else {
            $this->redirecionar(URL_RAIZ . 'login');
        }
    }

    public function armazenar()
    {
        $solicitacoes = Solicitacao::buscarLaboratorio($_POST['laboratorio']);

        $bancada1 = '';
        $bancada2 = '';
        $bancada3 = '';

        if ($_POST['bancada1'] ?? null) {
            $bancada1 = $_POST['bancada1'];
        }
        if ($_POST['bancada2'] ?? null) {
            $bancada2 = $_POST['bancada2'];
        }
        if ($_POST['bancada3'] ?? null) {
            $bancada3 = $_POST['bancada3'];
        }

        $bancadas = 'Laboratorio: ' . $_POST['laboratorio'] . ' Bancada: ' . $bancada1 . '-' . $bancada2 . '-' . $bancada3;

        $solicitacao = new Solicitacao(
            'não',
            $_POST['data-inicio'],
            $_POST['data-fim'],
            $_POST['motivo'],
            $bancadas,
            $this->getUsuario()->getId()
        );

        $this->setErros($solicitacao->validarFormularioSolicitacao($_POST['data-inicio'], $_POST['data-fim'], $_POST['motivo'], $bancadas));

        if ($this->getErro('dataInicio') || $this->getErro('dataFim') || $this->getErro('motivo') || $this->getErro('bancadas')) {
            $this->visao('laboratorio/mostrar.php', ['mensagem' => DW3Sessao::getFlash('mensagem', null), 'solicitacoes' => $solicitacoes, 'laboratorioId' => $_POST['laboratorio']]);
        } else {
            $solicitacao->salvar();
            DW3Sessao::setFlash('mensagem', 'Solicitação registrada com sucesso!!');
            $this->redirecionar(URL_RAIZ . 'laboratorio/' . $_POST['laboratorio']);
        }
    }

    public function atualizar() {
        $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));
        $solicitacao = Solicitacao::buscarId($_POST['solicitacao']);

        if ($this->verificarLogado() && $usuario->getAdministrador() == 1) {
                    $solicitacao->atualizar($solicitacao->getId());
                    $this->redirecionar(URL_RAIZ . 'laboratorio');
                } else {
                    $this->redirecionar(URL_RAIZ . 'laboratorio');
                }
    }

    public function destruir()
    {
        $usuario = Usuario::buscarId(DW3Sessao::get('usuario'));
        $solicitacao = Solicitacao::buscarId($_POST['solicitacao']);


        if ($this->verificarLogado() && $usuario->getAdministrador() == 1 || $this->verificarLogado() && $solicitacao->getUsuarioId() == $usuario->getId()) {
            $solicitacao->destruir($_POST['solicitacao']);
            $this->redirecionar(URL_RAIZ . 'laboratorio');
        } else {
            $this->redirecionar(URL_RAIZ . 'laboratorio');
        }
    }
}

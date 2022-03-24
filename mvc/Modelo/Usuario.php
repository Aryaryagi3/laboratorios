<?php
namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;
use \Framework\DW3Sessao;

class Usuario extends Modelo
{
    const BUSCAR_ID = 'SELECT * FROM usuarios WHERE id = ?';
    const BUSCAR_EMAIL = 'SELECT * FROM usuarios WHERE email = ?';
    const INSERIR = 'INSERT INTO usuarios(email, senha) VALUES (?, ?)';
    const BUSCAR_SOLICITACOES_USUARIO = 'SELECT * FROM solicitacoes WHERE usuario_id = ? ORDER BY data_inicio ASC';

    private $id;
    private $email;
    private $senha;
    private $senhaInalterada;
    private $administrador;

    public function __construct(
        $email = null,
        $senhaInalterada = null,
        $administrador = null,
        $id = null
    ) {
        $this->email = $email;
        $this->senhaInalterada = $senhaInalterada;
        $this->senha = password_hash($senhaInalterada, PASSWORD_BCRYPT);
        $this->id = $id;
        $this->administrador = $administrador;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAdministrador()
    {
        return $this->administrador;
    }

    public function verificarSenha($senhaInalterada)
    {
        return password_verify($senhaInalterada, $this->senha);
    }

    public function salvar()
    {
        $this->inserir();
    }

    public function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->email, PDO::PARAM_STR);
        $comando->bindValue(2, $this->senha, PDO::PARAM_STR);
        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }

    public function validarFormularioCriarConta($email, $senha) {
        $erros = [];

        if (strlen($email) < 3) {
            $erros['email'] = 'Seu email é muito curto, no mínimo 3 caracteres são aceitos!';
        }
        if (strlen($senha) < 3) {
            $erros['senha'] = 'Sua senha é muito curta, no mínimo 3 caracteres são aceitos!';
        }
        return $erros;
    }

    public static function buscarId($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $registro = $comando->fetch();
        $usuario = null;
        if ($registro) {
            $usuario = new Usuario(
                $registro['email'],
                null,
                $registro['administrador'],
                $registro['id']
            );
            $usuario->senha = $registro['senha'];
        }
        return $usuario;
    }

    public static function buscarEmail($email)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_EMAIL);
        $comando->bindValue(1, $email, PDO::PARAM_STR);
        $comando->execute();
        $registro = $comando->fetch();
        $usuario = null;
        if ($registro) {
            $usuario = new Usuario(
                $registro['email'],
                null,
                $registro['administrador'],
                $registro['id']
            );
            $usuario->senha = $registro['senha'];
        }
        return $usuario;
    }

    public static function buscarSolicitacoes($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_SOLICITACOES_USUARIO);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $registros = $comando->fetchAll();
        $solicitacoes=[];
                foreach ($registros as $registro) {
                    $solicitacoes[] = new Solicitacao(
                        $registro['reservado'],
                        $registro['data_inicio'],
                        $registro['data_fim'],
                        $registro['motivo'],
                        $registro['laboratorio'],
                        $registro['usuario_id'],
                        $registro['id']
                    );
                }
                return $solicitacoes;
    }
}

<?php
namespace Modelo;

use \PDO;
use \Framework\DW3BancoDeDados;

class Solicitacao extends Modelo
{
    const BUSCAR_ID = 'SELECT * FROM solicitacoes WHERE id = ?';
    const BUSCAR_AUTOR = 'SELECT * FROM usuarios WHERE id = ?';
    const INSERIR = 'INSERT INTO solicitacoes(reservado, data_inicio, data_fim, motivo, laboratorio, usuario_id) VALUES (?, ?, ?, ?, ?, ?)';
    const BUSCAR_LABORATORIO = 'SELECT * FROM solicitacoes WHERE laboratorio LIKE ';
    const BUSCAR_TODOS = 'SELECT * FROM solicitacoes ORDER BY data_inicio ASC';
    const DELETAR = 'DELETE FROM solicitacoes WHERE id = ?';
    const ATUALIZAR = 'UPDATE solicitacoes SET data_inicio = ?, reservado = ? WHERE id = ?';

    private $id;
    private $reservado;
    private $dataInicio;
    private $dataFim;
    private $motivo;
    private $laboratorio;
    private $usuarioId;
    private $usuario;

    public function __construct(
        $reservado = null,
        $dataInicio = null,
        $dataFim = null,
        $motivo = null,
        $laboratorio = null,
        $usuarioId = null,
        $id = null
    ) {
        $this->id = $id;
        $this->reservado = $reservado;
        $this->dataInicio = $dataInicio;
        $this->dataFim = $dataFim;
        $this->motivo = $motivo;
        $this->laboratorio = $laboratorio;
        $this->usuarioId = $usuarioId;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setDataInicio($dataInicio)
    {
        $this->titulo = $titulo;
    }

    public function getDataInicio()
    {
        return $this->dataInicio;
    }

    public function setDataFim($dataFim)
    {
        $this->dataFim = $dataFim;
    }

    public function getDataFim()
    {
        return $this->dataFim;
    }

    public function setMotivo($dataMotivo)
    {
        $this->motivo = $motivo;
    }

    public function getMotivo()
    {
        return $this->motivo;
    }

    public function setLaboratorio($laboratorio)
    {
        $this->titulo = $titulo;
    }

    public function getLaboratorio()
    {
        return $this->laboratorio;
    }

    public function setReservado($reservado)
    {
        $this->titulo = $reservado;
    }

    public function getReservado()
    {
        return $this->reservado;
    }

    public function getUsuario()
    {
        if ($this->usuario == null) {
            $this->usuario = $this->buscarUsuario($this->usuarioId);
        }
        return $this->usuario;
    }

    public function getUsuarioId()
    {
        return $this->usuarioId;
    }

    public function salvar()
    {
        if ($this->id == null) {
            $this->inserir();
        } else {
            $this->atualizar();
        }
    }

    public static function buscarId($id)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_ID);
        $comando->bindValue(1, $id, PDO::PARAM_INT);
        $comando->execute();
        $registro = $comando->fetch();
        $solicitacao = null;

                    $solicitacao = new Solicitacao(
                        $registro['reservado'],
                        $registro['data_inicio'],
                        $registro['data_fim'],
                        $registro['motivo'],
                        $registro['laboratorio'],
                        $registro['usuario_id'],
                        $registro['id']
                    );
                return $solicitacao;
    }

    public function inserir()
    {
        DW3BancoDeDados::getPdo()->beginTransaction();
        $comando = DW3BancoDeDados::prepare(self::INSERIR);
        $comando->bindValue(1, $this->reservado, PDO::PARAM_STR);
        $comando->bindValue(2, $this->dataInicio, PDO::PARAM_STR);
        $comando->bindValue(3, $this->dataFim, PDO::PARAM_STR);
        $comando->bindValue(4, $this->motivo, PDO::PARAM_STR);
        $comando->bindValue(5, $this->laboratorio, PDO::PARAM_STR);
        $comando->bindValue(6, $this->usuarioId, PDO::PARAM_INT);
        $comando->execute();
        $this->id = DW3BancoDeDados::getPdo()->lastInsertId();
        DW3BancoDeDados::getPdo()->commit();
    }

    public function atualizar($solicitacao)
    {
        $solicitacao2 = Solicitacao::buscarId($solicitacao);

        if ($solicitacao2->getReservado() == 'sim') {
            $comando = DW3BancoDeDados::prepare(self::ATUALIZAR);
            $comando->bindValue(1, $solicitacao2->getDataInicio(), PDO::PARAM_STR);
            $comando->bindValue(2, 'não', PDO::PARAM_STR);
            $comando->bindValue(3, $solicitacao, PDO::PARAM_INT);
            $comando->execute();
        } else {
            $comando = DW3BancoDeDados::prepare(self::ATUALIZAR);
            $comando->bindValue(1, $solicitacao2->getDataInicio(), PDO::PARAM_STR);
            $comando->bindValue(2, 'sim', PDO::PARAM_STR);
            $comando->bindValue(3, $solicitacao, PDO::PARAM_INT);
            $comando->execute();
        }
    }

    public function validarFormularioSolicitacao($dataInicio, $dataFim, $motivo, $bancadas) {
        $erros = [];

        if (strlen($dataInicio) == 0) {
            $erros['dataInicio'] = 'A data de início de uso do laboratório é obrigatório!';
        }
        if (strlen($dataFim) == 0) {
            $erros['dataFim'] = 'A data de fim de uso do laboratório é obrigatório!';
        }
        if (strlen($motivo) < 3) {
            $erros['motivo'] = 'No mínimo 3 caracteres são aceitos!';
        }
        if (strlen($bancadas) == 26) {
            $erros['bancadas'] = 'Você não selecionou nenhuma bancada para uso!';
        }

        return $erros;
    }

    public static function buscarUsuario($usuarioId)
    {
        $comando = DW3BancoDeDados::prepare(self::BUSCAR_AUTOR);
        $comando->bindValue(1, $usuarioId, PDO::PARAM_INT);
        $comando->execute();
        $registro = $comando->fetch();
            return new Usuario(
                $registro['email'],
                null,
                $registro['administrador'],
                $registro['id']
                );
    }

    public static function buscarLaboratorio($id)
    {
            $registros = DW3BancoDeDados::query(self::BUSCAR_LABORATORIO . "'Laboratorio:_" . $id . "%" . "'" . ' ORDER BY data_inicio ASC');
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

    public static function buscarTodos()
    {
            $registros = DW3BancoDeDados::query(self::BUSCAR_TODOS);
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

    public function destruir($id)
    {
        $comando = DW3BancoDeDados::prepare(self::DELETAR);
        $comando->bindValue(1, $id, PDO::PARAM_STR);
        $comando->execute();
    }
}

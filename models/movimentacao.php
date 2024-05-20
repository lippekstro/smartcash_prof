<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/configs/conexao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/configs/utils.php';
class Movimentacao
{
    private $id_movimentacao;
    private $data_movimentacao;
    private $descricao;
    private $tipo_movimentacao;
    private $valor_movimentacao;
    private $id_categoria;
    private $id_usuario;

    // SQL Queries
    private const SELECT_BY_ID = 'SELECT * FROM MovimentacaoFinanceira WHERE id_movimentacao = :id';
    private const INSERT_MOV = 'INSERT INTO MovimentacaoFinanceira (valor_movimentacao, data_movimentacao, descricao, tipo_movimentacao, id_categoria, id_usuario) VALUES (:valor, :dia, :descr, :tipo, :categoria, :usuario)';
    private const SELECT_ALL = 'SELECT m.*, c.nome_categoria FROM MovimentacaoFinanceira m JOIN Categoria c ON m.id_categoria = c.id_categoria WHERE m.id_usuario = :id AND data_movimentacao BETWEEN :inicio AND :fim ORDER BY data_movimentacao';
    private const UPDATE_MOV = 'UPDATE MovimentacaoFinanceira SET valor_movimentacao = :valor, data_movimentacao = :dia, descricao = :descr, tipo_movimentacao = :tipo, id_categoria = :categoria WHERE id_movimentacao = :id';
    private const DELETE_MOV = 'DELETE FROM MovimentacaoFinanceira WHERE id_movimentacao = :id';

    public function __construct($id = false)
    {
        if ($id) {
            $this->id_movimentacao = $id;
            $this->carregar();
        }
    }

    public function getId()
    {
        return $this->id_movimentacao;
    }
    function setData_movimentacao($data_movimentacao)
    {
        $this->data_movimentacao = $data_movimentacao;
    }
    function getData_movimentacao()
    {
        return $this->data_movimentacao;
    }
    function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }
    function getDescricao()
    {
        return $this->descricao;
    }
    function setTipo_movimentacao($tipo_movimentacao)
    {
        $this->tipo_movimentacao = $tipo_movimentacao;
    }
    function getTipo_movimentacao()
    {
        return $this->tipo_movimentacao;
    }
    function setValor_movimentacao($valor_movimentacao)
    {
        $this->valor_movimentacao = $valor_movimentacao;
    }
    function getValor_movimentacao()
    {
        return $this->valor_movimentacao;
    }
    function setId_categoria($id_categoria)
    {
        $this->id_categoria = $id_categoria;
    }
    function getId_categoria()
    {
        return $this->id_categoria;
    }
    function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }
    function getId_usuario()
    {
        return $this->id_usuario;
    }


    private function carregar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::SELECT_BY_ID);
            $stmt->bindValue(':id', $this->id_movimentacao);
            $stmt->execute();
            $resultado = $stmt->fetch();

            if ($resultado) {
                $this->data_movimentacao = $resultado['data_movimentacao'];
                $this->descricao = $resultado['descricao'];
                $this->tipo_movimentacao = $resultado['tipo_movimentacao'];
                $this->valor_movimentacao = $resultado['valor_movimentacao'];
                $this->id_categoria = $resultado['id_categoria'];
                $this->id_usuario = $resultado['id_usuario'];
            }
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao carregar movimentação: ' . $e->getMessage();
        }
    }

    public function criar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::INSERT_MOV);
            $stmt->bindValue(':valor', $this->valor_movimentacao);
            $stmt->bindValue(':dia', $this->data_movimentacao);
            $stmt->bindValue(':descr', $this->descricao);
            $stmt->bindValue(':tipo', $this->tipo_movimentacao);
            $stmt->bindValue(':categoria', $this->id_categoria);
            $stmt->bindValue(':usuario', $this->id_usuario);
            $stmt->execute();
            $this->id_usuario = $conexao->lastInsertId();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao criar movimentação: ' . $e->getMessage();
        }
    }

    public static function listar($id, $inicio = null, $fim = null, $mes = null, $ano = null)
    {
        try {
            // Se datas de início e fim não forem fornecidas, usar mês e ano atuais ou selecionados
            if (!$inicio || !$fim) {
                if (!$mes || !$ano) {
                    $mes = date('m');
                    $ano = date('Y');
                }
                list($inicio, $fim) = Utils::getInicioEFimDoMes($ano, $mes);
            }

            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::SELECT_ALL);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':inicio', $inicio);
            $stmt->bindValue(':fim', $fim);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao listar movimentações: ' . $e->getMessage();
        }
    }

    public function atualizar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::UPDATE_MOV);
            $stmt->bindValue(':valor', $this->valor_movimentacao);
            $stmt->bindValue(':dia', $this->data_movimentacao);
            $stmt->bindValue(':descr', $this->descricao);
            $stmt->bindValue(':tipo', $this->tipo_movimentacao);
            $stmt->bindValue(':categoria', $this->id_categoria);
            $stmt->bindValue(':id', $this->id_movimentacao);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao atualizar movimentação: ' . $e->getMessage();
        }
    }

    public function deletar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::DELETE_MOV);
            $stmt->bindValue(':id', $this->id_movimentacao);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao deletar movimentação: ' . $e->getMessage();
        }
    }
}

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/configs/conexao.php';

class Categoria
{
    private $id_categoria;
    private $nome_categoria;

    // SQL Queries
    private const SELECT_BY_ID = 'SELECT * FROM Categoria WHERE id_categoria = :id';
    private const INSERT_CAT = 'INSERT INTO Categoria (nome_categoria) VALUES (:nome)';
    private const SELECT_ALL = 'SELECT * FROM Categoria ORDER BY nome_categoria';
    private const UPDATE_CAT = 'UPDATE Categoria SET nome_categoria = :nome WHERE id_categoria = :id';
    private const DELETE_CAT = 'DELETE FROM Categoria WHERE id_categoria = :id';

    public function __construct($id = false)
    {
        if ($id) {
            $this->id_categoria = $id;
            $this->carregar();
        }
    }

    public function getId()
    {
        return $this->id_categoria;
    }

    public function getNome()
    {
        return $this->nome_categoria;
    }

    public function setNome($nome)
    {
        $this->nome_categoria = $nome;
    }

    private function carregar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::SELECT_BY_ID);
            $stmt->bindValue(':id', $this->id_categoria);
            $stmt->execute();
            $resultado = $stmt->fetch();

            if ($resultado) {
                $this->nome_categoria = $resultado['nome_categoria'];
            }
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao carregar categoria: ' . $e->getMessage();
        }
    }

    public function criar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::INSERT_CAT);
            $stmt->bindValue(':nome', $this->nome_categoria);
            $stmt->execute();
            $this->id_categoria = $conexao->lastInsertId();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao criar categoria: ' . $e->getMessage();
        }
    }

    public static function listar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::SELECT_ALL);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao listar categorias: ' . $e->getMessage();
        }
    }

    public function atualizar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::UPDATE_CAT);
            $stmt->bindValue(':nome', $this->nome_categoria);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao atualizar categoria: ' . $e->getMessage();
        }
    }

    public function deletar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::DELETE_CAT);
            $stmt->bindValue(':id', $this->id_categoria);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao deletar categoria: ' . $e->getMessage();
        }
    }
}

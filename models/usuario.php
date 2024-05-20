<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/configs/conexao.php';

class Usuario
{
    private $id_usuario;
    private $nome;
    private $senha;
    private $email;
    private $foto_usuario;

    // SQL Queries
    private const SELECT_BY_ID = 'SELECT * FROM Usuario WHERE id_usuario = :id';
    private const INSERT_USER = 'INSERT INTO Usuario (nome_usuario, email, senha, foto_usuario) VALUES (:nome, :email, :senha, :foto)';
    private const SELECT_ALL = 'SELECT * FROM Usuario';
    private const UPDATE_USER = 'UPDATE Usuario SET nome_usuario = :nome, email = :email, foto_usuario = :foto WHERE id_usuario = :id';
    private const UPDATE_PASSWORD = 'UPDATE Usuario SET senha = :senha WHERE id_usuario = :id';
    private const DELETE_USER = 'DELETE FROM Usuario WHERE id_usuario = :id';

    public function __construct($id = false)
    {
        if ($id) {
            $this->id_usuario = $id;
            $this->carregar();
        }
    }

    public function getId()
    {
        return $this->id_usuario;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getFotoUsuario()
    {
        return $this->foto_usuario;
    }

    public function setFotoUsuario($foto_usuario)
    {
        $this->foto_usuario = $foto_usuario;
    }

    private function carregar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::SELECT_BY_ID);
            $stmt->bindValue(':id', $this->id_usuario);
            $stmt->execute();
            $resultado = $stmt->fetch();

            if ($resultado) {
                $this->nome = $resultado['nome_usuario'];
                $this->senha = $resultado['senha'];
                $this->email = $resultado['email'];
                $this->foto_usuario = $resultado['foto_usuario'];
            }
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao carregar usuário: ' . $e->getMessage();
        }
    }

    public function criar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::INSERT_USER);
            $stmt->bindValue(':nome', $this->nome);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':senha', $this->senha);
            $stmt->bindValue(':foto', $this->foto_usuario);
            $stmt->execute();
            $this->id_usuario = $conexao->lastInsertId();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao criar usuário: ' . $e->getMessage();
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
            echo 'Erro ao listar usuários: ' . $e->getMessage();
        }
    }

    public function atualizar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::UPDATE_USER);
            $stmt->bindValue(':nome', $this->nome);
            $stmt->bindValue(':email', $this->email);
            $stmt->bindValue(':foto', $this->foto_usuario);
            $stmt->bindValue(':id', $this->id_usuario);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao atualizar usuário: ' . $e->getMessage();
        }
    }

    public function atualizarSenha()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::UPDATE_PASSWORD);
            $stmt->bindValue(':senha', $this->senha);
            $stmt->bindValue(':id', $this->id_usuario);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao atualizar senha: ' . $e->getMessage();
        }
    }

    public function deletar()
    {
        try {
            $conexao = Conexao::criaConexao();
            $stmt = $conexao->prepare(self::DELETE_USER);
            $stmt->bindValue(':id', $this->id_usuario);
            $stmt->execute();
        } catch (PDOException $e) {
            // Tratamento de exceções
            echo 'Erro ao deletar usuário: ' . $e->getMessage();
        }
    }
}

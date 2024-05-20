<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/configs/conexao.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/usuario.php';

session_start();

class Auth
{
    public static function logar($email, $senha)
    {
        $sql = "SELECT * FROM Usuario WHERE email = :email";
        $conexao = Conexao::criaConexao();
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nome'] = $usuario['nome_usuario'];
            $_SESSION['email'] = $usuario['email'];
            $_SESSION['foto_usuario'] = $usuario['foto_usuario'];

            header('Location: /smartcash_prof/index.php');
            exit();
        } else {
            $_SESSION['aviso'] = "Email ou Senha incorretos";
            header('Location: /smartcash_prof/views/login.php');
            exit();
        }
    }

    public static function estaAutenticado()
    {
        return isset($_SESSION['id_usuario']);
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header('Location: /smartcash_prof/views/login.php');
        exit();
    }
}

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/usuario.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lógica para registro de usuário
    $nome = htmlspecialchars($_POST['nome']);
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    }
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Criar uma instância de Usuario
    $novoUsuario = new Usuario();
    $novoUsuario->setNome($nome);
    $novoUsuario->setEmail($email);
    $novoUsuario->setSenha($senha);
    $novoUsuario->setFotoUsuario(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/imgs/dummy_usuario.php'));

    // Chamar o método para criar o usuário
    $novoUsuario->criar();

    // Redirecionar para login
    header('Location: /smartcash_prof/views/login.php');
    exit();
}

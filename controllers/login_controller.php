<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/auth/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    }
    $senha = $_POST['senha'];
    Auth::logar($email, $senha);
}

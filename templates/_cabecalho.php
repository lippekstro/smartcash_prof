<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/auth/auth.php';

?>

<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartCash</title>
    <link rel="shortcut icon" href="/smartcash_prof/imgs/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="/smartcash_prof/css/bootstrap.css">
    <script src="/smartcash_prof/js/bootstrap.bundle.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="navbar sticky-top bg-dark flex-md-nowrap shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="#">SmartCash</a>

        <?php if (Auth::estaAutenticado()) : ?>
            <span class="mx-3">Bem Vindo, <?= $_SESSION['nome'] ?></span>
        <?php endif; ?>

        <ul class="navbar-nav flex-row d-md-none">
            <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </li>
        </ul>
    </header>

    <section class="container-fluid flex-grow-1">
        <div class="row">
            <nav class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                <div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">SmartCash</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="/smartcash_prof/index.php">
                                    <span class="material-symbols-outlined">home</span>Início
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="/smartcash_prof/views/movimentacoes.php">
                                    <span class="material-symbols-outlined">currency_exchange</span>Movimentações Financeiras
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="/smartcash_prof/views/extrato.php">
                                    <span class="material-symbols-outlined">monitoring</span>Extrato
                                </a>
                            </li>
                        </ul>

                        <hr class="my-3">

                        <ul class="nav flex-column mb-auto">
                            <li class="nav-item">
                                <a class="nav-link d-flex align-items-center gap-2" href="/smartcash_prof/index.php">
                                    <span class="material-symbols-outlined">settings</span>Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <?php if (Auth::estaAutenticado()) : ?>
                                    <a class="nav-link d-flex align-items-center gap-2" href="/smartcash_prof/controllers/logout_controller.php">
                                        <span class="material-symbols-outlined">door_front</span>Sair
                                    </a>
                                <?php else : ?>
                                    <a class="nav-link d-flex align-items-center gap-2" href="/smartcash_prof/views/login.php">
                                        <span class="material-symbols-outlined">door_open</span>Entrar
                                    </a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
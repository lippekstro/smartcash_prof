<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/movimentacao.php';
session_start();

$id = $_GET['id'];

$movimentacao = new Movimentacao($id);

$movimentacao->deletar();

header('Location: /smartcash_prof/views/movimentacoes.php');
exit();

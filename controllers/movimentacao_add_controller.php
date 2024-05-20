<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/movimentacao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['tipo'] == 'entrada') {
        $valor = (float)$_POST['valor'];
    } else {
        $valor = -abs($_POST['valor']);
    }

    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];

    $novaMovimentacao = new Movimentacao();
    $novaMovimentacao->setValor_movimentacao($valor);
    $novaMovimentacao->setData_movimentacao($data);
    $novaMovimentacao->setDescricao($descricao);
    $novaMovimentacao->setTipo_movimentacao($tipo);
    $novaMovimentacao->setId_categoria($categoria);
    $novaMovimentacao->setId_usuario($_SESSION['id_usuario']);

    $novaMovimentacao->criar();

    header('Location: /smartcash_prof/views/movimentacoes.php');
    exit();
}

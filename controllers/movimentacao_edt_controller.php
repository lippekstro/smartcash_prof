<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/movimentacao.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $valor = $_POST['valor'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];
    $tipo = $_POST['tipo'];
    $categoria = $_POST['categoria'];

    $movimentacao = new Movimentacao($id);
    $movimentacao->setValor_movimentacao($valor);
    $movimentacao->setData_movimentacao($data);
    $movimentacao->setDescricao($descricao);
    $movimentacao->setTipo_movimentacao($tipo);
    $movimentacao->setId_categoria($categoria);

    $movimentacao->atualizar();

    header('Location: /smartcash_prof/views/movimentacoes.php');
    exit();
}

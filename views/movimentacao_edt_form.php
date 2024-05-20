<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_cabecalho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/categoria.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/movimentacao.php';

$listaCategorias = Categoria::listar();

$id = $_GET['id'];
$movimentacao = new Movimentacao($id);

?>

<section class="form-signin w-100 m-auto d-flex justify-content-center">
    <form class="col-10 col-md-6 col-lg-5" action="/smartcash_prof/controllers/movimentacao_edt_controller.php" method="post" autocomplete="off">
        <div class="d-flex justify-content-center">
            <img class="mb-4" src="/smartcash_prof/imgs/logo.png" alt="" width="150px" height="150px">
        </div>

        <input type="hidden" name="id" value="<?= $movimentacao->getId() ?>">

        <div class="form-floating my-3">
            <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0" value="<?= $movimentacao->getValor_movimentacao() ?>" required>
            <label for="floatingInput">Valor</label>
        </div>

        <div class="form-floating my-3">
            <input type="date" class="form-control" id="data" name="data" value="<?= $movimentacao->getData_movimentacao() ?>" required>
            <label for="floatingPassword">Data</label>
        </div>

        <div class="form-floating my-3">
            <textarea class="form-control" id="descricao" name="descricao"><?= $movimentacao->getDescricao() ?></textarea>
            <label for="floatingPassword">Descrição</label>
        </div>

        <div class="form-floating my-3">
            <h4 class="mb-3">Tipo de Movimentação</h4>
            <div class="my-3">
                <div class="form-check">
                    <input id="entrada" name="tipo" type="radio" class="form-check-input" value="entrada" <?= $movimentacao->getTipo_movimentacao() == 'entrada' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="entrada">Entrada</label>
                </div>
                <div class="form-check">
                    <input id="saida" name="tipo" type="radio" class="form-check-input" value="saida" <?= $movimentacao->getTipo_movimentacao() == 'saida' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="saida">Saida</label>
                </div>
            </div>
        </div>

        <div class="my-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select class="form-select" id="categoria" name="categoria">
                <?php foreach ($listaCategorias as $categoria) : ?>
                    <option value="<?= $categoria['id_categoria'] ?>" <?= $movimentacao->getId_categoria() == $categoria['id_categoria'] ? 'selected' : '' ?>><?= $categoria['nome_categoria'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Atualizar</button>
    </form>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_rodape.php';
?>
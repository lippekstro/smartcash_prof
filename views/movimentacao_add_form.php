<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_cabecalho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/categoria.php';

$listaCategorias = Categoria::listar();

?>

<section class="form-signin w-100 m-auto d-flex justify-content-center">
    <form class="col-10 col-md-6 col-lg-5" action="/smartcash_prof/controllers/movimentacao_add_controller.php" method="post" autocomplete="off">
        <div class="d-flex justify-content-center">
            <img class="mb-4" src="/smartcash_prof/imgs/logo.png" alt="" width="150px" height="150px">
        </div>

        <div class="form-floating my-3">
            <input type="number" class="form-control" id="valor" name="valor" step="0.01" min="0" required>
            <label for="floatingInput">Valor</label>
        </div>

        <div class="form-floating my-3">
            <input type="date" class="form-control" id="data" name="data" required>
            <label for="floatingPassword">Data</label>
        </div>

        <div class="form-floating my-3">
            <textarea class="form-control" id="descricao" name="descricao"></textarea>
            <label for="floatingPassword">Descrição</label>
        </div>

        <div class="form-floating my-3">
            <h4 class="mb-3">Tipo de Movimentação</h4>
            <div class="my-3">
                <div class="form-check">
                    <input id="entrada" name="tipo" type="radio" class="form-check-input" value="entrada" checked>
                    <label class="form-check-label" for="entrada">Entrada</label>
                </div>
                <div class="form-check">
                    <input id="saida" name="tipo" type="radio" class="form-check-input" value="saida">
                    <label class="form-check-label" for="saida">Saida</label>
                </div>
            </div>
        </div>

        <div class="my-3">
            <label for="categoria" class="form-label">Categoria</label>
            <select class="form-select" id="categoria" name="categoria">
                <?php foreach ($listaCategorias as $categoria) : ?>
                    <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['nome_categoria'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Criar</button>
    </form>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_rodape.php';
?>
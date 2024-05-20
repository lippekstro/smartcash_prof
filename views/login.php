<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_cabecalho.php';
?>

<section class="form-signin w-100 m-auto d-flex justify-content-center">
    <form class="col-10 col-md-6 col-lg-5" action="/smartcash_prof/controllers/login_controller.php" method="post" autocomplete="off">
        <div class="d-flex justify-content-center">
            <img class="mb-4" src="/smartcash_prof/imgs/logo.png" alt="" width="150px" height="150px">
        </div>

        <div class="form-floating my-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" required>
            <label for="floatingInput">Email</label>
        </div>

        <div class="form-floating my-3">
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required>
            <label for="floatingPassword">Senha</label>
        </div>

        <div class="my-3 text-center">
            <a href="/smartcash_prof/views/registro.php">Registrar-se</a>
        </div>

        <button class="btn btn-primary w-100 py-2" type="submit">Login</button>
    </form>
</section>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_rodape.php';
?>
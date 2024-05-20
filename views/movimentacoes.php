<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_cabecalho.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/models/movimentacao.php';

// Receber intervalo de datas personalizado ou mês e ano selecionados pelo usuário via GET ou POST
$inicioSelecionado = isset($_GET['inicio']) ? date('Y-m-d', strtotime($_GET['inicio'])) : null;
$fimSelecionado = isset($_GET['fim']) ? date('Y-m-d', strtotime($_GET['fim'])) : null;
$mesSelecionado = isset($_GET['mes']) ? date('m', strtotime($_GET['mes'])) : null;
$anoSelecionado = isset($_GET['mes']) ? date('Y', strtotime($_GET['mes'])) : null;

// Listar movimentações com base no intervalo personalizado ou mês e ano selecionados
$listaMovimentacoes = Movimentacao::listar($_SESSION['id_usuario'], $inicioSelecionado, $fimSelecionado, $mesSelecionado, $anoSelecionado);

// Arrays associativos para armazenar os valores acumulados por categoria para entradas e saídas
$categorias_valores_entrada = array();
$categorias_valores_saida = array();

// Iterar sobre a lista de movimentações
foreach ($listaMovimentacoes as $movimentacao) {
    $categoria = $movimentacao['nome_categoria'];
    $valor = abs((float)$movimentacao['valor_movimentacao']);
    $tipo = $movimentacao['tipo_movimentacao'];

    // Acumular o valor na categoria correta dependendo do tipo de movimentação
    if ($tipo == 'entrada') {
        if (isset($categorias_valores_entrada[$categoria])) {
            $categorias_valores_entrada[$categoria] += $valor;
        } else {
            $categorias_valores_entrada[$categoria] = $valor;
        }
    } elseif ($tipo == 'saida') {
        if (isset($categorias_valores_saida[$categoria])) {
            $categorias_valores_saida[$categoria] += $valor;
        } else {
            $categorias_valores_saida[$categoria] = $valor;
        }
    }
}

// Converter os dados acumulados em um formato adequado para o gráfico de entradas
$dados_grafico_entrada = array();
$dados_grafico_entrada[] = ['Categoria', 'Valor'];
foreach ($categorias_valores_entrada as $categoria => $valor) {
    $dados_grafico_entrada[] = [$categoria, $valor];
}

// Converter os dados acumulados em um formato adequado para o gráfico de saídas
$dados_grafico_saida = array();
$dados_grafico_saida[] = ['Categoria', 'Valor'];
foreach ($categorias_valores_saida as $categoria => $valor) {
    $dados_grafico_saida[] = [$categoria, $valor];
}

$dados_grafico_json_entrada = json_encode($dados_grafico_entrada);
$dados_grafico_json_saida = json_encode($dados_grafico_saida);


?>

<section class="d-flex justify-content-evenly align-items-center flex-wrap">
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="m-3 d-flex flex-column align-items-center">
        <fieldset class="align-items-center d-flex flex-column">
            <legend class="text-center">Filtre Por Mês</legend>
            <input type="month" name="mes" id="mes">
        </fieldset>
        <button type="submit" class="btn btn-outline-success m-3 d-flex align-items-center">Selecionar</button>
    </form>

    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get" class="m-3 d-flex flex-column align-items-center">
        <fieldset class="align-items-center d-flex flex-column">
            <legend class="text-center">Intervalo Personalizado</legend>
            <input type="date" name="inicio" id="inicio">
            <span>a</span>
            <input type="date" name="fim" id="fim">
        </fieldset>
        <button type="submit" class="btn btn-outline-success m-3 d-flex align-items-center">Selecionar</button>
    </form>

    <a href="/smartcash_prof/views/movimentacao_add_form.php" class="btn btn-outline-success m-3 d-flex align-items-center"><span class="material-symbols-outlined me-1">add_circle</span>Adicionar</a>
</section>

<section class="row m-3">
    <h6>Entradas</h6>
    <div class="col-md-8">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($listaMovimentacoes as $entrada) : ?>
                <?php if ($entrada['tipo_movimentacao'] == 'entrada') : ?>
                    <div class="col">
                        <div class="card shadow-sm bg-success-subtle">
                            <div class="card-body">
                                <p class="card-text text-center">R$ <?= $entrada['valor_movimentacao'] ?></p>
                                <p class="card-text text-center"><?= $entrada['nome_categoria'] ?></p>
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="">
                                        <a href="/smartcash_prof/views/movimentacao_edt_form.php?id=<?= $entrada['id_movimentacao'] ?>" class="btn btn-sm btn-outline-info m-1">Editar</a>
                                        <a href="/smartcash_prof/controllers/movimentacao_del_controller.php?id=<?= $entrada['id_movimentacao'] ?>" class="btn btn-sm btn-outline-danger m-1">Deletar</a>
                                    </div>
                                    <small class="text-body-secondary"><?= date('d/m/Y', strtotime($entrada['data_movimentacao'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-4 my-3">
        <div id="grafEntradas"></div>
    </div>
</section>

<hr class="my-3">

<section class="row m-3">
    <h6>Saídas</h6>
    <div class="col-md-8">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php foreach ($listaMovimentacoes as $entrada) : ?>
                <?php if ($entrada['tipo_movimentacao'] == 'saida') : ?>
                    <div class="col">
                        <div class="card shadow-sm bg-danger-subtle">
                            <div class="card-body">
                                <p class="card-text text-center">R$ <?= $entrada['valor_movimentacao'] ?></p>
                                <p class="card-text text-center"><?= $entrada['nome_categoria'] ?></p>
                                <div class="d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="">
                                        <a href="/smartcash_prof/views/movimentacao_edt_form.php?id=<?= $entrada['id_movimentacao'] ?>" class="btn btn-sm btn-outline-info m-1">Editar</a>
                                        <a href="/smartcash_prof/controllers/movimentacao_del_controller.php?id=<?= $entrada['id_movimentacao'] ?>" class="btn btn-sm btn-outline-danger m-1">Deletar</a>
                                    </div>
                                    <small class="text-body-secondary"><?= date('d/m/Y', strtotime($entrada['data_movimentacao'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-4 my-3">
        <div id="grafSaidas"></div>
    </div>
</section>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawEntradas);
    google.charts.setOnLoadCallback(drawSaidas);

    function drawEntradas() {
        var dados = <?= $dados_grafico_json_entrada ?>; //inserindo o JSON gerado com PHP nessa variavel para manipular depois
        var data = google.visualization.arrayToDataTable(dados);
        var options = {
            title: 'Minhas Entradas por Categoria',
            titleTextStyle: {
                color: '#fff'
            },
            legendTextStyle: {
                color: '#fff'
            },
            is3D: false,
            backgroundColor: 'transparent',
            color: '#000',
            width: '100%', // Definir a largura como 100% para que o gráfico se ajuste automaticamente ao tamanho do contêiner
            height: '100%', // Definir a altura como 100% para que o gráfico se ajuste automaticamente ao tamanho do contêiner
            chartArea: { // Definir a área do gráfico para garantir que o gráfico se ajuste corretamente
                width: '80%',
                height: '80%'
            }
        };
        var chart = new google.visualization.PieChart(document.getElementById('grafEntradas'));
        chart.draw(data, options);
    }

    function drawSaidas() {
        var dados = <?= $dados_grafico_json_saida ?>; //inserindo o JSON gerado com PHP nessa variavel para manipular depois
        var data = google.visualization.arrayToDataTable(dados);
        var options = {
            title: 'Minhas Saídas por Categoria',
            titleTextStyle: {
                color: '#fff'
            },
            legendTextStyle: {
                color: '#fff'
            },
            is3D: false,
            backgroundColor: 'transparent',
            color: '#000',
            width: '100%', // Definir a largura como 100% para que o gráfico se ajuste automaticamente ao tamanho do contêiner
            height: '100%', // Definir a altura como 100% para que o gráfico se ajuste automaticamente ao tamanho do contêiner
            chartArea: { // Definir a área do gráfico para garantir que o gráfico se ajuste corretamente
                width: '80%',
                height: '80%'
            }
        };
        var chart = new google.visualization.PieChart(document.getElementById('grafSaidas'));
        chart.draw(data, options);
    }
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_rodape.php';
?>
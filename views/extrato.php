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

$dados_grafico = [];
$dados_grafico[] = ['Data', 'Saldo'];

$saldo_total = 0;
foreach ($listaMovimentacoes as $registro) {
    $saldo_total += $registro['valor_movimentacao'];
    $dados_grafico[] = [$registro['data_movimentacao'], (float)$saldo_total];
}

$dados_grafico_json = json_encode($dados_grafico);
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

    <a href="/smartcash_prof/views/" class="btn btn-outline-success m-3 d-flex align-items-center"><span class="material-symbols-outlined me-1">table_chart</span>Gerar Relatório</a>
</section>

<section class="m-3">
    <div class="table-responsive small">
        <table class="table table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Descrição</th>
                    <th scope="col">Categoria</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaMovimentacoes as $mov) : ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($mov['data_movimentacao'])) ?></td>
                        <td><?= $mov['descricao'] ?></td>
                        <td><?= $mov['nome_categoria'] ?></td>
                        <td <?= $mov['tipo_movimentacao'] == 'saida' ? 'class="text-danger"' : '' ?>>R$ <?= $mov['valor_movimentacao'] ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3">Total</td>
                    <td <?= $saldo_total < 0 ? 'class="text-danger"' : '' ?>>R$ <?= $saldo_total ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<section>
    <div id='graphExtrato'></div>
</section>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    google.charts.load('current', {
        packages: ['corechart']
    });
    google.charts.setOnLoadCallback(drawExtrato);

    function drawExtrato() {
        var dados = <?= $dados_grafico_json ?>; //inserindo o JSON gerado com PHP nessa variavel para manipular depois
        var data = google.visualization.arrayToDataTable(dados);
        var options = {
            title: 'Saldo ao longo do tempo',
            titleTextStyle: {
                color: '#fff'
            },
            legendTextStyle: {
                color: '#fff'
            },
            is3D: false,
            backgroundColor: 'transparent',
            color: '#000',
            hAxis: {
                title: 'Data',
                titleTextStyle: {
                    color: '#fff'
                },
                textStyle: {
                    color: '#FFF'
                }
            },
            vAxis: {
                title: 'Saldo',
                titleTextStyle: {
                    color: '#fff'
                },
                textStyle: {
                    color: '#FFF'
                }
            },
            width: '100%', // Definir a largura como 100% para que o gráfico se ajuste automaticamente ao tamanho do contêiner
            height: '100%', // Definir a altura como 100% para que o gráfico se ajuste automaticamente ao tamanho do contêiner
            chartArea: { // Definir a área do gráfico para garantir que o gráfico se ajuste corretamente
                width: '50%',
                height: '50%'
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('graphExtrato'));
        chart.draw(data, options);
    }
</script>

<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/smartcash_prof/templates/_rodape.php';
?>
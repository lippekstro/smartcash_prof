<?php

class Utils
{
    static function getInicioEFimDoMes($ano, $mes)
    {
        // Data de início do mês
        $inicio = new DateTime("$ano-$mes-01");

        // Clonar a data de início para calcular a data de fim
        $fim = clone $inicio;

        // Mudar para o primeiro dia do próximo mês e subtrair um dia para obter o último dia do mês atual
        $fim->modify('first day of next month');
        $fim->modify('-1 day');

        // Formatar as datas como strings no formato 'Y-m-d'
        $inicioFormatado = $inicio->format('Y-m-d');
        $fimFormatado = $fim->format('Y-m-d');

        return array($inicioFormatado, $fimFormatado);
    }
}

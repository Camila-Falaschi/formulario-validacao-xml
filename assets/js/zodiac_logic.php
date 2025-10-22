<?php
function findZodiacSign(DateTime $birthDate, string $xmlFile = 'signos.xml'): array {
    if (!file_exists($xmlFile)) {
        return ['error' => 'Arquivo de dados (signos.xml) não encontrado.'];
    }

    libxml_use_internal_errors(true);
    $signos = simplexml_load_file($xmlFile);
    if ($signos === false) {
        return ['error' => 'Erro ao ler o arquivo XML de signos.'];
    }

    $birthMonthDay = $birthDate->format('m-d');

    foreach ($signos->signo as $signo) {
        $dataInicio = (string)$signo->dataInicio;
        $dataFim = (string)$signo->dataFim;

        $startMonthDay = DateTime::createFromFormat('d/m', $dataInicio)->format('m-d');
        $endMonthDay = DateTime::createFromFormat('d/m', $dataFim)->format('m-d');

        $isMatch = false;

        if ($startMonthDay > $endMonthDay) {
            if ($birthMonthDay >= $startMonthDay || $birthMonthDay <= $endMonthDay) {
                $isMatch = true;
            }
        } else {
            if ($birthMonthDay >= $startMonthDay && $birthMonthDay <= $endMonthDay) {
                $isMatch = true;
            }
        }

        if ($isMatch) {
            return [
                'signoNome' => (string)$signo->signoNome,
                'descricao' => (string)$signo->descricao
            ];
        }
    }

    return ['error' => 'Não foi possível identificar o signo com a data informada.'];
}
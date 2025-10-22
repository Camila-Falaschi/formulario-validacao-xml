<?php
include('header.php');

function dateFromDayMonth($dayMonth, $year) {
    $parts = explode('/', $dayMonth);
    if (count($parts) != 2) return false;
    list($d, $m) = $parts;
    $d = intval($d);
    $m = intval($m);

    $dateStr = sprintf('%04d-%02d-%02d', $year, $m, $d);
    return DateTime::createFromFormat('Y-m-d', $dateStr);
}

$data_nascimento = $_POST['data_nascimento'];

if (!isset($data_nascimento) || empty($data_nascimento)) {
    $error = "Nenhuma data de nascimento informada. Voltar e preencher o campo.";
} else {
    $input = $_POST['data_nascimento'];
    $dt = DateTime::createFromFormat('Y-m-d', $input);
    if (!$dt) {
        $error = "Data inválida. Utilizar formato de data válido (AAAA-MM-DD).";
    } else {
        $birthDate = $dt;
        $birthYear = intval($birthDate->format('Y'));

        if (!file_exists('signos.xml')) {
            $error = "Arquivo signos.xml não encontrado.";
        } else {
            libxml_use_internal_errors(true);
            $signos = simplexml_load_file('signos.xml');
            if ($signos === false) {
                $error = "Erro ao ler signos.xml.";
            } else {
                $found = null;

                foreach ($signos->signo as $signo) {
                    $dataInicio = (string)$signo->dataInicio; 
                    $dataFim = (string)$signo->dataFim;      

                    
                    $start = dateFromDayMonth($dataInicio, $birthYear);
                    $end = dateFromDayMonth($dataFim, $birthYear);

                    if (!$start || !$end) continue;

                    
                    if ($start > $end) {
                        
                        $end = dateFromDayMonth($dataFim, $birthYear + 1);
                    }
                    
                    $testDate = DateTime::createFromFormat('Y-m-d', $birthDate->format('Y-m-d'));

                    if ($testDate >= $start && $testDate <= $end) {
                        $found = $signo;
                        break;
                    }
    
                    if ($start->format('Y') < $end->format('Y')) {
                        
                        $testDate2 = DateTime::createFromFormat('Y-m-d', sprintf('%04d-%02d-%02d',
                            $birthYear + 1,
                            intval($birthDate->format('m')),
                            intval($birthDate->format('d'))
                        ));
                        if ($testDate2 >= $start && $testDate2 <= $end) {
                            $found = $signo;
                            break;
                        }
                    }
                } 

                if ($found === null) {
                    $error = "Não foi possível identificar o signo com a data informada.";
                } else {
                    $signoNome = (string)$found->signoNome;
                    $descricao = (string)$found->descricao;
                }
            }
        }
    }
}
?>

  <div class="row">
    <div class="col-12 text-center mb-4">
      <h1>Resultado da consulta</h1>
    </div>
  </div>

<?php if (isset($error)): ?>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="alert alert-warning" role="alert">
        <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
      </div>
      <div>
        <a href="index.php" class="btn btn-secondary">Voltar</a>
      </div>
    </div>
  </div>
<?php else: ?>
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card card-signo p-4">
        <h2 class="signo-name"><?php echo htmlspecialchars($signoNome, ENT_QUOTES, 'UTF-8'); ?></h2>
        <p class="description"><?php echo htmlspecialchars($descricao, ENT_QUOTES, 'UTF-8'); ?></p>
        <hr>
        <p><strong>Data de nascimento:</strong> <?php echo $birthDate->format('d/m/Y'); ?></p>
        <a href="index.php" class="btn btn-primary">Consultar outra data</a>
      </div>
    </div>
  </div>
<?php endif; ?>

  <footer>
    <small>Resultado obtido a partir do arquivo XML.</small>
  </footer>

<?php

echo "</div>\n"; 
?>

<script src="https:
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>

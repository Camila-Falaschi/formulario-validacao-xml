<?php
include('layouts/header.php');
include('assets/js/zodiac_logic.php'); 

$error = null;
$result = null;
$birthDate = null;

if (empty($_POST['data_nascimento'])) {
    $error = "Nenhuma data de nascimento informada. Voltar e preencher o campo.";
} else {
    $birthDate = DateTime::createFromFormat('Y-m-d', $_POST['data_nascimento']);
    
    if (!$birthDate) {
        $error = "Data inválida. Utilizar formato de data válido (AAAA-MM-DD).";
    } else {      
        $result = findZodiacSign($birthDate, 'signos.xml');
        
        if (isset($result['error'])) {
            $error = $result['error'];
            $result = null; 
        }
    }
}
?>

  <div class="row">
    <div class="col-12 text-center mb-4">
      <h1>Resultado da consulta</h1>
    </div>
  </div>

<?php if ($error): ?>
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
<?php elseif ($result): ?>
  <div class="row justify-content-center">
    <div class="card card-signo p-4">
    <h2 class="signo-name"><?php echo htmlspecialchars($result['signoNome'], ENT_QUOTES, 'UTF-8'); ?></h2>
      <p class="description"><?php echo htmlspecialchars($result['descricao'], ENT_QUOTES, 'UTF-8'); ?></p>
      <hr>
      <p><strong>Data de nascimento:</strong> <?php echo $birthDate->format('d/m/Y'); ?></p>
      <a href="index.php" class="btn btn-primary">Consultar outra data</a>
    </div>
  </div>
<?php endif; ?>

<?php
include('layouts/footer.php'); 
?>
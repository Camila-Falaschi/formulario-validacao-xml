<?php
include('layouts/header.php');
?>
  <div class="row">
    <div class="col-12 text-center mt-4">
      <h1>Descubra o seu signo</h1>
      <p class="text-muted">Informe a data de nascimento para verificar o signo zodiacal.</p>
    </div>
  </div>

  <div class="row">
    <div class="form-section">
      <div class="card card-signo p-4">
        <form id="signo-form" method="POST" action="show_zodiac_sign.php">
          <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn-primary">Consultar signo</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
include('layouts/footer.php');
?>
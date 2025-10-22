<?php
include('header.php');
?>

  <div class="row">
    <div class="col-12 text-center mb-4">
      <h1>Descubra o seu signo</h1>
      <p class="text-muted">Informe a data de nascimento para verificar o signo zodiacal.</p>
    </div>
  </div>

  <div class="row">
    <div class="form-section">
      <div class="card card-signo p-4">
        <form id="signo-form" method="POST" action="show_zodiac_sign.php" novalidate>
          <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required>
            <div class="form-text">Formato: AAAA-MM-DD. Browsers modernos exibem um seletor de data.</div>
          </div>

          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Consultar signo</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <footer>
    <small>Aplicação didática — Consulta de signo a partir de arquivo XML.</small>
  </footer>

<?php
echo "</div>\n"; 
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa"
        crossorigin="anonymous"></script>
</body>
</html>

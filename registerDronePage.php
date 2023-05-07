<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $nome = $_POST["name"];
  $modello = $_POST["model"];
  $anno_acquisto = $_POST["buyingDate"];
  $ore_di_volo = $_POST["flyHours"];
  $ultima_manutenzione = $_POST['lastManutention'];
  $icon = $_POST['icon'];

  $user_id = $_SESSION['user_info']['user_id'];

  $dbc = Database::getInstance();
  $conn = $dbc->getConnection();

  $stmt = $conn->prepare("INSERT INTO droni (nome, modello, anno_acquisto, utente_id, ore_di_volo, ultima_manutenzione, icon) VALUES (:nome, :modello, :anno_acquisto, :user_id, :ore_di_volo, :ultima_manutenzione, :icon)");
  $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
  $stmt->bindParam(':modello', $modello, PDO::PARAM_STR);
  $stmt->bindParam(':anno_acquisto', $anno_acquisto, PDO::PARAM_INT);
  $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  $stmt->bindParam(':ore_di_volo', $ore_di_volo, PDO::PARAM_INT);
  $stmt->bindParam(':ultima_manutenzione', $ultima_manutenzione, PDO::PARAM_STR);
  $stmt->bindParam(':icon', $icon, PDO::PARAM_STR);
  
  if ($stmt->execute()) {
    header('Location: homePage.php?page=dronePage');
    exit();
  } else {
    echo "Errore nell'inserimento del record: " . $stmt->errorInfo();
  }
}
?>

<div class="container page-title">
  <div class="row">
    <div class="col-12">
      <h3 class="h3-reg">Register your Drone</h3>
      <p class="p-reg">Fill in the data below.</p>
      <form class="needs-validation" method="post" id="form">
        <div class="form-group">
          <label for="name">Drone name</label>
          <input class="form-control" type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="model">Model</label>
          <input class="form-control" type="text" id="model" name="model" required>
          <div class="valid-feedback">Email field is valid!</div>
          <div class="invalid-feedback">Email field cannot be blank!</div>
        </div>
        <div class="form-group">
          <label for="buyingDate">Buying Date</label>
          <input class="form-control" type="date" id="buyingDate" name="buyingDate" required>
        </div>
        <div class="form-group">
          <label for="flyHours">Fly Hours</label>
          <input class="form-control" type="number" id="flyHours" name="flyHours">
        </div>
        <div class="form-group">
          <label for="buyingDate">Last manutention</label>
          <input class="form-control" type="date" id="lastManutention" name="lastManutention" required>
        </div>
        <div class="form-group">
          <div class="mb-3">
            <label for="formFile" class="form-label">Drone icon image (jpg, png)</label>
            <input type="file" id="formFile" name="icon">
          </div>
          <small class="form-text text-muted">Select an icon to represent your drone (optional).</small>
        </div>
        <div class="form-group form-check">
          <input class="form-check-input" type="checkbox" id="termsAndConditions" name="termsAndConditions" required>
          <label class="form-check-label" for="termsAndConditions">I agree to the <a href="#">Terms and Conditions</a></label>
        </div>
        <div class="form-group">
          <button id="submit" type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>
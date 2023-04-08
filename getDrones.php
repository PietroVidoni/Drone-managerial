<?php
include 'enableConnection.php';

if (isset($_GET['keywords']) && isset($_GET['selector'])) {
  $keywords = $_GET['keywords'];
  $selector = $_GET['selector'];

  $user_id = $_SESSION['user_id'];

  $dbc = Database::getInstance();
  $conn = $dbc->getConnection();

  $sql = "SELECT * FROM droni WHERE utente_id = :id";
  if (!empty($keywords)) {
    $sql .= " AND ($selector LIKE :keywords)";
  }
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(':id', $user_id);
  if (!empty($keywords)) {
    $stmt->bindValue(':keywords', "%$keywords%");
  }
  $stmt->execute();

  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

  foreach ($rows as $drone) {
    echo '<div class="job-box d-md-flex align-items-center justify-content-between mb-30">';
    echo '<div class="job-left my-4 d-md-flex align-items-center flex-wrap">';
    echo '<div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">';
    echo '<img src="' . $drone['icon'] . '" class="rounded-circle" style="width: 90px;" alt="Avatar" />';
    echo '</div>';
    echo '<div class="job-content">';
    echo '<h5 class="text-center text-md-left">';
    echo 'Name: ' . $drone['nome'];
    echo '</h5>';
    echo '<ul class="d-md-flex flex-wrap text-capitalize ff-open-sans">';
    echo '<li class="mr-md-4">';
    echo '<i class="zmdi zmdi-pin mr-2"></i>';
    echo 'Model: ' . $drone['modello'];
    echo '</li>';
    echo '<li class="mr-md-4">';
    echo '<i class="zmdi zmdi-money mr-2"></i>';
    echo 'Price: ' . $drone['prezzo'] . '€';
    echo '</li>';
    echo '</ul>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }
}
?>

<?php

if (isset($_POST['droneID'])) {
    $droneID = $_POST['droneID'];
}

?>

<div class="container mt-5 page-div">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Richiesta dati di volo</h3>
                </div>
                <div class="card-body">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

                        if (!isset($_SESSION['user_info']['user_id'])) {
                            header("../model/logout.php?reason=Something%20Went%20Wrong");
                            exit();
                        }

                        $dbc = Database::getInstance();
                        $conn = $dbc->getConnection();

                        $user_id = $_SESSION['user_info']['user_id'];
                        $droneID = $_POST['droneID'];
                        $tempo_di_volo = $_POST["tempo_di_volo"];
                        $coordinate = $_POST["coordinate"];
                        $luogo_di_partenza = $_POST["luogo_di_partenza"];
                        $note = $_POST["note"];
                        $data_volo = $_POST["data_volo"];

                        $sql_insert = "INSERT INTO record_di_volo (drone_id, utente_id, tempo_di_volo, coordinate, luogo_di_partenza, note, data_volo) 
                                VALUES (:droneID, :utente_id, :tempo_di_volo, :coordinate, :luogo_di_partenza, :note, :data_volo)";


                        $stmt = $conn->prepare($sql_insert);
                        $stmt->bindParam(':droneID', $droneID);
                        $stmt->bindParam(':utente_id', $user_id);
                        $stmt->bindParam(':tempo_di_volo', $tempo_di_volo);
                        $stmt->bindParam(':coordinate', $coordinate);
                        $stmt->bindParam(':luogo_di_partenza', $luogo_di_partenza);
                        $stmt->bindParam(':note', $note);
                        $stmt->bindParam(':data_volo', $data_volo);

                        try {
                            $stmt->execute();
                            echo "Record di volo inserito con successo!";
                        } catch (PDOException $e) {
                            header("Location: errors/internalErrorPage.php?error=" . $e->getMessage());
                            exit();
                        }

                        if ($stmt->rowCount() > 0) {
                            $sql_update = "UPDATE droni SET ore_di_volo = ore_di_volo + :tempo_di_volo WHERE id = :droneID";
                            $stmt_update = $conn->prepare($sql_update);
                            $stmt_update->bindParam(':tempo_di_volo', $tempo_di_volo);
                            $stmt_update->bindParam(':droneID', $droneID);

                            try {
                                $stmt_update->execute();
                                echo "\n<br>Ore di volo del drone aggiornate con successo!";
                            } catch (PDOException $e) {
                                header("Location: errors/internalErrorPage.php?error=" . $e->getMessage());
                                exit();
                            }
                        }
                    }
                    ?>

                    <form method="POST">
                        <input type="hidden" name="droneID" value="<?php echo $droneID; ?>">
                        <div class="form-group">
                            <label for="tempo_di_volo">Tempo di volo:</label>
                            <input type="text" class="form-control" id="tempo_di_volo" name="tempo_di_volo" required>
                        </div>
                        <div class="form-group">
                            <label for="coordinate">Coordinate:</label>
                            <input type="text" class="form-control" id="coordinate" name="coordinate" required>
                        </div>
                        <div class="form-group">
                            <label for="luogo_di_partenza">Luogo di partenza:</label>
                            <input type="text" class="form-control" id="luogo_di_partenza" name="luogo_di_partenza"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="note">Note:</label>
                            <textarea class="form-control" id="note" name="note"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="data_volo">Data di volo:</label>
                            <input type="date" class="form-control" id="data_volo" name="data_volo">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" name="submit">Invia</button>
                        </div>
                    </form>
                    <?php $dbc = Database::getInstance();
                    $conn = $dbc->getConnection();

                    $sql_select = "SELECT * FROM record_di_volo WHERE drone_id = :droneID";
                    $stmt_select = $conn->prepare($sql_select);
                    $stmt_select->bindParam(':droneID', $droneID);

                    try {
                        $stmt_select->execute();
                        $flightRecords = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        header("Location: errors/internalErrorPage.php?error=" . $e->getMessage());
                        exit();
                    }

                    if (!empty($flightRecords)) {
                        echo "<h4>Flight Records:</h4>";
                        echo "<ul>";
                        foreach ($flightRecords as $record) {
                            echo "<li>Tempo di volo: " . $record['tempo_di_volo'] . "</li>";
                            echo "<li>Coordinate: " . $record['coordinate'] . "</li>";
                            echo "<li>Luogo di partenza: " . $record['luogo_di_partenza'] . "</li>";
                            echo "<li>Note: " . $record['note'] . "</li>";
                            echo "<li>Data di volo: " . $record['data_volo'] . "</li>";
                            echo "<hr>";
                        }
                        echo "</ul>";
                    }

                    $stmt = null;
                    $stmt_update = null;
                    $conn = null;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
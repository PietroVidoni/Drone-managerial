<?php

include 'enableConnection.php';

session_start();

if (!isset($_SESSION['user_status']) || $_SESSION['user_status'] == false) {
    header('Location: loginPage.php');
}

$user_id = $_SESSION['user_id'];

$dbc = Database::getInstance();
$conn = $dbc->getConnection();

$stmt = $conn->prepare("SELECT * FROM droni WHERE utente_id = :id");
$stmt->execute(array(':id' => $user_id));

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$conn = null;

$jsonArray = json_encode($rows);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>DronePage</title>
    <script src="script.js"></script>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto mb-4">
                <div class="section-title text-center ">
                    <h3 class="top-c-sep">Drone list</h3>
                    <p>Lorem ipsum dolor sit detudzdae amet, rcquisc adipiscing elit. Aenean socada commodo
                        ligaui egets dolor. Nullam quis ante tiam sit ame orci eget erovtiu faucid.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="career-search mb-60">

                    <form class="career-form mb-60">
                        <div class="row">
                            <div class="col-md-6 col-lg-3 my-3">
                                <div class="input-group position-relative">
                                    <input type="text" class="form-control" placeholder="Enter Your Keywords"
                                        id="keywords">
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 my-3">
                                <div class="select-container">
                                    <select class="custom-select" id="select">
                                        <option selected="">modello</option>
                                        <option value="nome">nome</option>
                                        <option value="ultima_manutenzione">ultima manutenzione</option>
                                        <option value="anno_acquisto">anno acquisto</option>
                                        <option value="ore_di_volo">ore di volo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-3 my-3">
                                <button type="button" class="btn btn-lg btn-block btn-light btn-custom" id="search-btn">
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>


                    <script>

                        var keywords;
                        var selector;
                        var myArray = JSON.parse('<?php echo $jsonArray; ?>');

                        document.getElementById("search-btn").addEventListener('click', e => {
                            keywords = document.getElementById("keywords").value;
                            selector = document.getElementById("select").value;

                            if (selector === "nome") {
                                sort_name(myArray);
                            } else if (selector === "modello") {
                                sort_model(myArray);
                            } else if (selector === "ultima_manutenzione") {
                                sort_last_man(myArray);
                            } else if (selector === "anno_acquisto") {
                                sort_year(myArray);
                            } else if (selector === "ore_di_volo") {
                                sort_fly_hours(myArray);
                            }

                            // Creare una nuova richiesta AJAX
                            var xhr = new XMLHttpRequest();

                            // Impostare la funzione da chiamare quando la richiesta viene completata con successo
                            xhr.onreadystatechange = function () {
                                if (this.readyState == 4 && this.status == 200) {
                                    // La richiesta è stata completata e il server ha restituito una risposta
                                    console.log(this.responseText);
                                    // Aggiornare la lista sulla pagina
                                    document.querySelector('.filter-result').innerHTML = this.responseText;
                                }
                            };

                            // Impostare il metodo HTTP e l'URL del file PHP che riceverà la richiesta
                            xhr.open("POST", "", true);

                            // Impostare l'intestazione della richiesta per indicare che si sta inviando un oggetto JSON
                            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");

                            // Convertire l'oggetto JSON in una stringa
                            var jsonData = JSON.stringify(myArray);

                            // Invio della richiesta al server
                            xhr.send(jsonData);
                        });

                    </script>

                    <div class="filter-result">
                        <?php
                        function printList($array) {
                            foreach ($array as $drone) {
                                echo '<div class="job-box d-md-flex align-items-center justify-content-between mb-30">';
                                echo '<div class="job-left my-4 d-md-flex align-items-center flex-wrap">';
                                echo '<div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">';
                                echo '<img src=' . $drone['icon'] . ' class="rounded-circle" style="width: 90px;" alt="Avatar" />';
                                echo '</div>';
                                echo '<div class="job-content">';
                                echo '<h5 class="text-center text-md-left">Name: ' . $drone['nome'] . '</h5>';
                                echo '<ul class="d-md-flex flex-wrap text-capitalize ff-open-sans">';
                                echo '<li class="mr-md-4"><i class="zmdi zmdi-pin mr-2"></i>Model: ' . $drone['modello'] . '</li>';
                                echo '<li class="mr-md-4"><i class="zmdi zmdi-money mr-2"></i>Purchase date: ' . $drone['anno_acquisto'] . '</li>';
                                echo '<li class="mr-md-4"><i class="zmdi zmdi-time mr-2"></i>Last maintenance: ' . $drone['ultima_manutenzione'] . '</li>';
                                echo '</ul>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="job-right my-4 flex-shrink-0">';
                                echo '<button href="#" class="btn d-block w-100 d-sm-inline-block btn-light info"';
                                echo 'data-nome="' . $drone['nome'] . '"';
                                echo 'data-modello="' . $drone['modello'] . '">Info</button>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }

                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Qui inserisci la logica per aggiornare il tuo array $myArray
                            $myArray = array( /* array aggiornato */);

                            // Aggiorna la lista
                            printList($myArray);
                        } else {
                            // Stampa la lista per la prima volta
                            $myArray = json_decode($jsonArray, true);
                            printList($myArray);
                        }
                        ?>

                    </div>

                    <div id='popup' class='modal'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h3 class='modal-title'></h3>
                                    <button type='button' class='btn-close' data-bs-dismiss='modal'
                                        aria-label='Close'></button>
                                </div>
                                <div class='modal-body'>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        var popupEl = document.getElementById('popup');
                        var closeButtonEl = popupEl.querySelector('.btn-close');
                        var titleEl = popupEl.querySelector('h3');
                        var descriptionEl = popupEl.querySelector('p');

                        closeButtonEl.addEventListener('click', function () {
                            popupEl.style.display = 'none';
                        });

                        window.addEventListener('click', function (event) {
                            if (event.target == popupEl) {
                                popupEl.style.display = 'none';
                            }
                        });

                        var infoButtons = document.querySelectorAll('.info');
                        for (var i = 0; i < infoButtons.length; i++) {
                            infoButtons[i].addEventListener('click', function () {
                                popupEl.style.display = 'block';

                                var nome = this.getAttribute('data-nome');
                                titleEl.innerHTML = nome;

                                var modello = this.getAttribute('data-modello');
                                //TODO add fly hours
                                descriptionEl.innerHTML = "Model: " + modello + "<br>Ore volo: ";
                            });
                        }
                    </script>


                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-reset justify-content-center">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="zmdi zmdi-long-arrow-left"></i>
                                </a>
                            </li>
                            <li class="page-item"><a classcontact-submit="page-link" href="#">1</a></li>
                            <li class="page-item d-none d-md-inline-block"><a class="page-link" href="#">2</a></li>
                            <li class="page-item d-none d-md-inline-block"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">...</a></li>
                            <li class="page-item"><a class="page-link" href="#">8</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="zmdi zmdi-long-arrow-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>

        </div>

</body>

</html>
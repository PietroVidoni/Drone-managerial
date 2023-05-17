<?php

$dbc = Database::getInstance();
$conn = $dbc->getConnection();

$stmt = $conn->prepare("SELECT * FROM droni WHERE utente_id = :id");
$stmt->execute(array(':id' => $user_id));

$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$jsonArray = json_encode($rows);

?>

<div class="container page-title">
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

                <!-- Selector start -->
                <form class="career-form mb-60">
                    <div class="row">
                        <div class="col-md-6 col-lg-3 my-3">
                            <div class="input-group position-relative">
                                <input type="text" class="form-control" placeholder="Enter Your Keywords" id="keywords">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 my-3">
                            <button type="button" class="btn btn-lg btn-block btn-light btn-custom" id="search-btn">
                                Refresh
                            </button>
                        </div>
                        <div class="col-md-6 col-lg-3 my-3">
                            <a href="homePage.php?page=registerDronePage" type="buttonRegister"
                                class="btn btn-lg btn-block btn-light btn-custom" id="search-btn">
                                Register drone
                            </a>
                        </div>
                    </div>
                </form>
                <!-- Selector end -->

                <!-- Order list logic script -->
                <script>
                    const updatedList = JSON.parse('<?php echo $jsonArray; ?>');

                    document.getElementById("search-btn").addEventListener('click', () => {

                        const xhr = new XMLHttpRequest();
                        xhr.onreadystatechange = () => {
                            if (xhr.readyState === 4) {
                                if (xhr.status === 200) {
                                    document.querySelector('.filter-result').innerHTML = xhr.responseText;
                                } else {
                                    console.error('Errore nella richiesta AJAX:', xhr.status);
                                }
                            }
                        };

                        xhr.onerror = () => {
                            console.error('Errore nella richiesta AJAX.');
                        };

                        const data = {
                            selector: selector,
                            drones: updatedList,
                            keywords: keywords || null
                        };

                        xhr.open("POST", "../control/updateList.php", true);
                        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                        xhr.send(JSON.stringify(data));


                        var infoButtons = document.querySelectorAll('.info');
                        var flyButtons = document.querySelectorAll('.fly');
                        var removeButtons = document.querySelectorAll('.remove');

                        updateButtons(infoButtons, flyButtons, removeButtons);
                    });
                </script>

                <!-- Dinamic php list start -->
                <div class="filter-result">
                    <?php
                    //include the code whitout executing it 
                    ob_start();
                    include '../control/updateList.php';
                    $updateListCode = ob_get_clean();
                    ?>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $jsonArray = file_get_contents('php://input');
                        $updatedList = json_decode($jsonArray, true);

                        printList($updatedList);
                    } else {
                        $updatedList = json_decode($jsonArray, true);
                        printList($updatedList);
                    }
                    ?>

                </div>
                <!-- Dinamic php list end -->

                <!-- Popup start -->
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
                <!-- Popup end -->

                <!-- Popup gestor script -->
                <script>
                    var popupEl = document.getElementById('popup');
                    var closeButtonEl = popupEl.querySelector('.btn-close');
                    var titleEl = popupEl.querySelector('h3');
                    var descriptionEl = popupEl.querySelector('p');

                    closeButtonEl.addEventListener('click', function () {
                        popupEl.style.display = 'none';
                    });

                    window.addEventListener('click', function (event) {
                        if (event.target === popupEl) {
                            popupEl.style.display = 'none';
                        }
                    });

                    var infoButtons = document.querySelectorAll('.info');
                    var flyButtons = document.querySelectorAll('.fly');
                    var removeButtons = document.querySelectorAll('.remove');

                    updateButtons(infoButtons, flyButtons, removeButtons);
                </script>
            </div>
        </div>
    </div>
</div>
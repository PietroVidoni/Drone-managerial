<?php

session_start();

$data = json_decode(file_get_contents("php://input"), true);

$drones = $data['drones'];
$selector = $data['selector'];
$keywords = $data['keywords'];

foreach ($drones as $drone) {
    if (stripos($drone[$selector], $keywords) !== false) {
        $results[] = $drone;
    }
}

printList($results);
function printList($array) {

    
    foreach ($array as $drone) {
    
        $icon = $drone['icon'] != null ? $drone['icon'] : ".\assets\img\png\default_drone.png" ;

        echo '<div class="job-box d-md-flex align-items-center justify-content-between mb-30">';
        echo '<div class="job-left my-4 d-md-flex align-items-center flex-wrap">';
        echo '<div class="img-holder mr-md-4 mb-md-0 mb-4 mx-auto mx-md-0 d-md-none d-lg-flex">';
        echo '<img src=' . $icon . ' class="rounded-circle" style="width: 90px;" alt="Avatar" />';
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
        echo 'data-name="' . $drone['nome'] . '"';
        echo 'data-last_man="' . $drone['ultima_manutenzione'] . '"';
        echo 'data-fly_hours="' . $drone['ore_di_volo'] . '"';
        echo 'data-model="' . $drone['modello'] . '">Info</button>';
        echo '</div>';
        echo '</div>';
    }
}
?>

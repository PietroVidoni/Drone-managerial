<?php 
$cartella = basename(dirname(__FILE__));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZEo25ksqBow3T6TJ+M9XaJ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mt-5">
                <h1 class="display-4">404 Not Found</h1>
                <p class="lead">The requested URL was not found on this server.</p>
                <a href="/<?php echo $cartella."/index.php"?>" class="btn btn-primary">Go to Homepage</a>
            </div>
        </div>
    </div>
    
</body>
</html>
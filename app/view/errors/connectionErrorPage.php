<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Database Connection Error</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="mt-5">Database Connection Error</h1>

        <?php if (isset($_GET['error'])): //TODO chek if alredy logged and redirect to homePage not to loginPage?>
            <div class="alert alert-danger mt-4" role="alert">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>

        <a href="../homePage.php?page=dronePage" class="btn btn-primary mt-4">Torna alla pagina principale</a>
    </div>
</body>

</html>

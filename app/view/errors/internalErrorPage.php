<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Internal Error</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title">Internal Error</h5>
                    </div>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger " role="alert">
                            <?php echo "Error: " . $_GET['error']; ?>
                        </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <p>Si è verificato un errore interno.</p>
                        <p>Per favore se persiste, contatta l'amministratore di sistema per ulteriori informazioni.</p>
                    </div>

                    <div class="card-footer text-center">
                        <a href="../homePage.php?page=dronePage" class="btn btn-primary">Torna alla homepage</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
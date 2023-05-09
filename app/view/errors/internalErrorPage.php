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

</html>

<body>
    <div class="container">
        <h1>Errori di connessione al database</h1>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $_GET['error']; ?>
            </div>
        <?php endif; ?>

        <a href="index.php" class="btn btn-primary">Torna alla pagina principale</a>
    </div>
</body>


<?php
// file di configurazione di gettext
$locale = "it_IT"; // lingua di default
putenv("LANG=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("messages", "./locale");
textdomain("messages");

// Cambio la lingua
if (isset($_POST["lingua"])) {
    $locale = $_POST["lingua"];
    putenv("LANG=$locale");
    setlocale(LC_ALL, $locale);
}
?>

<div class="container mt-5 page-div">
    <h1>
        <?php echo _("Impostazioni"); ?>
    </h1>
    <hr>
    <h3>
        <?php echo _("General Settings"); ?>
    </h3>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="form">
        <div class="form-group">
            <label for="language-select">
                <?php echo _("Lingua"); ?>
            </label>
            <select class="form-control" id="language-select" name="lingua">
                <option value="it" <?php if ($locale == "it_IT")
                                        echo "selected"; ?>><?php echo _("Italiano"); ?></option>
                <option value="en" <?php if ($locale == "en_US")
                                        echo "selected"; ?>><?php echo _("Inglese"); ?></option>
                <option value="fr" <?php if ($locale == "fr_FR")
                                        echo "selected"; ?>><?php echo _("Francese"); ?></option>
                <option value="de" <?php if ($locale == "de_DE")
                                        echo "selected"; ?>><?php echo _("Tedesco"); ?></option>
                <option value="es" <?php if ($locale == "es_ES")
                                        echo "selected"; ?>><?php echo _("Spagnolo"); ?></option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            <?php echo _("Salva"); ?>
        </button>
    </form>
    <script>
        document.getElementById('form').addEventListener("submit", e => {
            e.preventDefault();
        })
    </script>
</div>
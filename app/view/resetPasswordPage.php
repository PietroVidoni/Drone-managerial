<?php

session_start();

$token = $_GET['reset_token'];

$dbc = Database::getInstance();
$conn = $dbc->getConnection();

$stmt = $conn->prepare("SELECT COUNT(*) FROM utenti WHERE token = :token");
$stmt->execute(array(':token' => $token));
$count = $stmt->fetchColumn();

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $timestamp = $row['timestamp'];

    // Verifica se il token è scaduto (10 minuti di validità)
    $expiryTime = strtotime($timestamp) + (10 * 60); // Aggiunge 10 minuti al timestamp di creazione
    if (time() < $expiryTime) {
        $valid = true;
        $_SESSION['reset_token'] = $token;
    }
}

if (!$valid) {
    // show an error message
    //echo "Invalid or expired token.";
    header("Location: forgotPasswordPage.php?valid=Invalid or expired token");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="gradient-custom">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Reset Password</h2>

                                <form method="post" action="confirmResetPassword.php">

                                    <?php if (isset($_GET['valid'])) { ?>

                                        <p class="error"><?php echo $_GET['valid']; ?></p>

                                    <?php } ?>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password1" required />
                                        <label class="form-label" for="typePasswordX">New Password</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg" name="password2" required />
                                        <label class="form-label" for="typePasswordX">Repeat Password</label>
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Reset Password</button>
                            </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
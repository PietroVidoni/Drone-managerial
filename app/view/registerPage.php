
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="gradient-custom">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Register</h2>

                                <form method="post" action="../model/register.php">

                                    <?php if (isset($_GET['error'])) { ?>

                                    <p class="error">
                                        <?php echo $_GET['error']; ?>
                                    </p>

                                    <?php } ?>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="typeEmailX" class="form-control form-control-lg" required
                                            name="username" />
                                        <label class="form-label" for="typeEmailX">Username</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="email" id="typeEmailX" class="form-control form-control-lg"
                                            required name="email" />
                                        <label class="form-label" for="typeEmailX">Email</label>
                                    </div>
                                    
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="typename" class="form-control form-control-lg" required
                                            name="name" />
                                        <label class="form-label" for="typename">nome</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="typesurname" class="form-control form-control-lg" required
                                            name="surname" />
                                        <label class="form-label" for="typesurname">cognome</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg"
                                            name="password1" required />
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" class="form-control form-control-lg"
                                            name="password2" required />
                                        <label class="form-label" for="typePasswordX">Repeat Password</label>
                                    </div>

                                    <button class="btn btn-outline-light btn-lg px-5" type="submit">Register</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
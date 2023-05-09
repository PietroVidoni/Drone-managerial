<!-- Navbar start -->
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <p class="navbar-brand">Drone Manager</p>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="homePage.php?page=dronePage">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="homePage.php?page=aboutPage">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="homePage.php?page=aboutPage#contacts">Contacts</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle"></i>
                    <?php echo $_SESSION['user_info']['username']; ?>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="homePage.php?page=profilePage">My Profile</a>
                    <a class="dropdown-item" href="homePage.php?page=settings">Settings</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../model/logout.php?reason=Log%20out%20done%20<br>%20Successfuly">Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- Navbar end -->

<!-- Navbar logic -->
<script>
    $(document).ready(function() {
        $('.navbar-nav .dropdown').hover(function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(250).slideDown();
        }, function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();
        });
    });
</script>
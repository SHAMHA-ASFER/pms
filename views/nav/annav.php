<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <!-- Navbar Brand -->
            <a class="navbar-brand me-auto" href="/">
            <img src="/assets/images/user/<?php echo $_SESSION['profile']; ?>" width="40" height="40" class="rounded-circle me-2" alt=""><?php echo $_SESSION["lname"] . "," ?></a>

            <!-- Navbar Toggler for Small Screens -->
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Links for Larger Screens -->
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-4">
                        <a class="nav-link active" href="/">Home</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link" href="/analyzer/dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link btn btn-secondary" href="/logout">Logout <i class="fa fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>

            <!-- Off-canvas Menu for Smaller Screens -->
            <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/analyzer/dashboard"></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-secondary" href="/logout">Logout <i class="fa fa-sign-out-alt"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
   
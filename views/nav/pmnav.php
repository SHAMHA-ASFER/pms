<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><?php echo $_SESSION["lname"] . "," ?></a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/manager/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/manager/project">Manage Project</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/manager/task">Manage Task</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/manager/members">Manage Members</a>
                    </li>
                </ul>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="btn btn-secondary me-2" href="/logout" >Logout <i class="fa fa-sign-out-alt"></i></a>
        </div>
    </nav>

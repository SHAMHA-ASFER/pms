<nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="/"><?php echo $_SESSION["lname"] . "," ?></a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="/dev/home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dev/create">Create File</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dev/update">Update File</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dev/view">View Task</a>
                    </li>
                </ul>
            </div>
            <a class="btn btn-secondary me-2" href="/logout" >Logout <i class="fa fa-sign-out-alt"></i></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

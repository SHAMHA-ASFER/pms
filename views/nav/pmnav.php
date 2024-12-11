<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"><?php echo $_SESSION["lname"] . "," ?></a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link active" href="/">Home</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/manager/dashboard">Dashboard</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/manager/handle/analyzer">Analyzers</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/manager/handle/developer">Developers</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/manager/handle/qa">QAs</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/manager/handle/task">Task</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="/manager/handle/doc">Document</a>
                </li>
            </ul>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <a class="btn btn-secondary me-2" href="/logout">Logout <i class="fa fa-sign-out-alt"></i></a>
    </div>
</nav>
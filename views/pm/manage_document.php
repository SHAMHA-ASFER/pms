<?php
$page = isset($_GET["page"]) ? $_GET["page"] : 'welcome';
?>
<div class="container-fluid mt-5" style="margin: 0; padding:0;">
    <div class="d-flex">
        <nav class="bg-light w-25 min-vh-100">
            <a href="?page=welcome" class="text-decoration-none text-black">
                <h4 class="text-center mt-4 mb-5">Navigate Projects</h4>
            </a>
            <div class="d-flex flex-column align-items-center m-3">
                <?php
                $projects = $this->projectModel->getAllProjects();
                while ($project = $projects->fetch_assoc()) {
                    if (isset($_GET['id']) && $_GET['id'] == $project['id']) {
                ?>
                <a href="?page=task" class="text-decoration-none text-start btn btn-primary w-100 d-flex fs-5 mb-3 bg-primary">
                    <i class="fa fa-spinner pt-1"></i>&nbsp;<p class="text-wrap"><?php echo $project['name']; ?></p></a>
                <?php
                    } else {
                        if ($project['status'] == 'pending') {
                ?>
                <a href="?page=task&id=<?php echo $project['id'] ?>" class="text-decoration-none text-start btn w-100 fs-5 d-flex mb-3" style="color:gray">
                    <i class="fa fa-wrench pt-1"></i>&nbsp;<p class="text-wrap"><?php echo $project['name']; ?></p></a>
                <?php
                        } else {
                ?>
                <a href="?page=task&id=<?php echo $project['id'] ?>" class="text-decoration-none text-start btn w-100 fs-5 d-flex mb-3" style="color:#31ed2e">
                    <i class="fa fa-check-circle pt-1"></i>&nbsp;<p class="text-wrap"><?php echo $project['name']; ?></p></a>
                <?php
                        }
                    }
                }
                ?>
            </div>
        </nav>
        <div class="flex-grow-1 h-100 w-75">
        <?php
        switch ($page) {
            case 'welcome': include_once __DIR__ .'/doc/welcome.php';
            break;
            case 'task': include_once __DIR__ .'/doc/doc.php';
            break;
        }
        ?>
        </div>
    </div>
</div>
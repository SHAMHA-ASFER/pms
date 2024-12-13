<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'projects';
?>
<div class="container-fluid d-flex" style="margin: 0; padding: 0;">
    <div class="w-75 mt-5 pt-3 min-vh-100">
        <?php
        switch ($page) {
            case 'projects':
                include_once __DIR__ .'/task/qa_pro.php';
                break;
            case 'task':
                include_once __DIR__ .'/task/qa_task.php';
                break;
        }
        ?>
    </div>
    <div class="pt-5 w-25 bg-light min-vh-100">
        <nav class="p-3">
            <h5 class="pt-4">Project Explorer</h5>
            <div class="mt-4">
                <?php
                $projects = $this->projectModel->getAllProjects();
                $i = 1;
                while ($project = $projects->fetch_assoc()) {
                    ?>
                    <div>
                        <h6 class="p-1 bg-light no-select" id="projectToggle-<?php echo $project['id']; ?>">
                            <i class="fa fa-angle-right" id="toggle-icon-<?php echo $project['id']; ?>"></i>
                            &nbsp;&nbsp;<i class="fa fa-folder text-warning"></i>&nbsp;<?php echo $project['name']; ?>
                        </h6>
                        <div class="collapse" id="collapsible-<?php echo $project['id']; ?>">
                            <?php
                            $files = $this->traverseDirectory(__DIR__ . '/../../assets/projects/' . $project['name'] . "/src");
                            $this->renderExplorer($files['children'], $project['name'], $project['id'], $i);
                            ?>
                        </div>
                    </div>
                    <?php
                    $i = 1;
                }
                ?>
            </div>
        </nav>
    </div>
</div>

<script>
    $('[id^="projectToggle-"]').click(function () {
        var id = $(this).attr('id').split('-')[1];
        $('#toggle-icon-' + id).toggleClass('rotated');
        $('#collapsible-' + id).collapse('toggle');
    });
</script>
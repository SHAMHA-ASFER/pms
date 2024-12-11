<div class="container-fluid" style="margin: 0; padding: 0;">
    <div class="d-flex mt-5">
        <nav class="p-4 min-vh-100 w-25 bg-secondary">
            <h5 class="pt-4">File Explorer</h5>
            <div class="mt-4">
                <?php
                $projects = $this->projectModel->getAllProjects();
                while ($project = $projects->fetch_assoc()) {
                    ?>
                    <div>
                        <h6 class="p-2 bg-white no-select" id="projectToggle-<?php echo $project['id']; ?>">
                            <i class="fa fa-angle-right" id="toggle-icon-<?php echo $project['id']; ?>"></i>
                            &nbsp;&nbsp;<?php echo $project['name']; ?>
                        </h6>
                        <div class="collapse" id="collapsible-<?php echo $project['id']; ?>">
                            <?php
                            $files = $this->traverseDirectory(__DIR__ . '/../../assets/projects/' . $project['name']);
                            $i = 0;
                            $this->renderExplorer($files['children'], $project['name'], $project['id'], $i);
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </nav>
        <div class="container p-4 min-vh-100 w-75" style="margin: 0; padding: 0;">

        </div>
    </div>
</div>

<script>
    $('[id^="projectToggle-"]').click(function () {
        var id = $(this).attr('id').split('-')[1];
        $('#toggle-icon-' + id).toggleClass('rotated');
        $('#collapsible-' + id).collapse('toggle');
    });
</script>
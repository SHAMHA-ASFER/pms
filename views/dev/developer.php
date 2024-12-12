<div class="container-fluid" style="margin: 0; padding: 0;">
    <div class="d-flex mt-5">
        <nav class="p-4 min-vh-100 w-25 bg-light position-relative z-index-1">
            <h5 class="pt-4">Project Explorer</h5>
            <div class="mt-4">
                <?php
                $projects = $this->projectModel->getAllProjects();
                $i = 1;
                while ($project = $projects->fetch_assoc()) {
                    ?>
                    <div>
                        <h7 class="p-1 bg-light no-select" id="projectToggle-<?php echo $project['id']; ?>">
                            <i class="fa fa-angle-right" id="toggle-icon-<?php echo $project['id']; ?>"></i>
                            &nbsp;&nbsp;<i class="fa fa-folder"></i>&nbsp;<?php echo $project['name']; ?>
                        </h7>
                        <div class="collapse" id="collapsible-<?php echo $project['id']; ?>">
                            <?php
                            $files = $this->traverseDirectory(__DIR__ . '/../../assets/projects/' . $project['name']);
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
        <div class="container p-4 min-vh-100 w-75 position-relative z-index-3" style="margin: 0; padding: 0;">
            <!-- Content goes here -->
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

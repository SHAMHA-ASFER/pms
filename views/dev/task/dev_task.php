<?php
$pro_id = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<div class="container p-4">
    <h3 class="mb-5">
        <?php
        $projects = $this->projectModel->getProject($pro_id);
        while ($project = $projects->fetch_assoc()) {
            echo $project['name'];
        }
        ?>
        Tasks
    </h3>
    <table id="taskTable" class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Task</th>
                <th>Description</th>
                <th>Deadline</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $taskDevs = $this->taskDeveloperModel->getAllTasks($_SESSION['id']);
            while ($taskDev = $taskDevs->fetch_assoc()) {
                $tasks = $this->taskModel->getTask($taskDev['task_id']);
                while ($task = $tasks->fetch_assoc()) {
                    ?>
                    <tr>
                        <td style="background-color:<?php
                        if ($task['status'] == 'pending') {
                            echo 'rgba(247, 254, 144, 0.5)';
                        } else if ($task['status'] == 'completed') {
                            echo 'rgba(128, 255, 109, 0.5)';
                        } else if ($task['status'] == 'denied') {
                            echo 'rgba(255, 145, 145, 0.5)';
                        } ?>;" class="col-md-1"><?php echo $i; ?></td>
                        <td style="background-color:<?php
                        if ($task['status'] == 'pending') {
                            echo 'rgba(247, 254, 144, 0.5)';
                        } else if ($task['status'] == 'completed') {
                            echo 'rgba(128, 255, 109, 0.5)';
                        } else if ($task['status'] == 'denied') {
                            echo 'rgba(255, 145, 145, 0.5)';
                        } ?>;" class="col-md-2"><?php echo $task['name']; ?></td>
                        <td style="background-color:<?php
                        if ($task['status'] == 'pending') {
                            echo 'rgba(247, 254, 144, 0.5)';
                        } else if ($task['status'] == 'completed') {
                            echo 'rgba(128, 255, 109, 0.5)';
                        } else if ($task['status'] == 'denied') {
                            echo 'rgba(255, 145, 145, 0.5)';
                        } ?>;" class="col-md-6"><?php echo $task['description']; ?></td>
                        <td style="background-color:<?php
                        if ($task['status'] == 'pending') {
                            echo 'rgba(247, 254, 144, 0.5)';
                        } else if ($task['status'] == 'completed') {
                            echo 'rgba(128, 255, 109, 0.5)';
                        } else if ($task['status'] == 'denied') {
                            echo 'rgba(255, 145, 145, 0.5)';
                        } ?>;" class="col-md-1"><?php echo $task['deadline']; ?></td>
                        <td class="text-center" style="background-color:<?php
                        if ($task['status'] == 'pending') {
                            echo 'rgba(247, 254, 144, 0.5)';
                        } else if ($task['status'] == 'completed') {
                            echo 'rgba(128, 255, 109, 0.5)';
                        } else if ($task['status'] == 'denied') {
                            echo 'rgba(255, 145, 145, 0.5)';
                        } ?>;" class="col-md-2">
                            <?php
                            if ($task['status'] == 'pending') {
                                ?>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#submitTask-<?php echo $task['id']; ?>"><i
                                        class="fa fa-plus"></i>&nbsp;Submit</button>
                                <?php
                            } else if ($task['status'] == 'denied') {
                                ?>
                                <form action="/files/remove" method="post">
                                    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                    <input type="hidden" name="pro_id" value="<?php echo $pro_id; ?>">
                                    <button class="btn btn-danger">
                                        <i class="fa fa-trash"></i>&nbsp;Remove</button>
                                </form>
                                <?php
                            } else if ($task['status'] == 'completed') {
                                ?>
                                        Accepted&nbsp;<i class="fa fa-info-circle pt-3"></i>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                $i++;
            }
            ?>
        </tbody>
    </table>
</div>

<?php
$taskDevs = $this->taskDeveloperModel->getAllTasks($_SESSION['id']);
while ($taskDev = $taskDevs->fetch_assoc()) {
    $tasks = $this->taskModel->getTask($taskDev['task_id']);
    while ($task = $tasks->fetch_assoc()) {
        ?>
        <div class="modal fade" id="submitTask-<?php echo $task['id']; ?>">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/files/add" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <div class="d-flex w-100 justify-content-between">
                            <h5>Locate Source</h5>
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <input type="hidden" name="pro_id" value="<?php echo $pro_id; ?>">
                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                            <div class="input-group mb-3">
                                <div class="input-group-text">Type</div>
                                <select id="file-type" class="form-select">
                                    <option value="FILE" selected>File</option>
                                    <option value="FOLDER">Folder</option>
                                </select>
                            </div>
                            <input type="file" name="source[]" class="form-control" id="input-file" multiple>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><i class="fa fa-upload"></i>&nbsp;Submit</button>
                    </div>
                    
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<script>
    $(document).ready(function () {
        $('#taskTable').DataTable();
        $('#file-type').on('change', function() {
            const type = $(this).val();
            $('#input-file').val('');
            if (type == 'FILE') {
                $('#input-file').removeAttr('webkitdirectory');
            } else {
                $('#input-file').attr('webkitdirectory', true);
            }
        });
    });
</script>   
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
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#submitTask-<?php echo $task['id']; ?>"><i
                                            class="fa fa-plus"></i>&nbsp;Re-submit</button>
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
                            <input type="file" name="source[]" class="form-control" webkitdirectory multiple>
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
        $(document).on('click', '[id^=submit-]', function() {
            const id = $(this).attr('id').split('-')[1];
            const fileInput = $('#source-' + id);
            const pro_id = $('#pro_id-' + id).val();
            const task_id = $('#task_id-' + id).val();
            const formData = new FormData();
            formData.append('pro_id', pro_id);
            formData.append('task_id', task_id);
            for (let i = 0; i < fileInput.prop('files').length; i++) {
                formData.append('source[]', fileInput.prop('files')[i]);
            }
            $.ajax({
                url:"/files/add",
                data:formData,
                type:'post',
                contentType:false,
                processData:false,
                success:function(response) {
                    console.log(response);
                },
                error:function(xhr, status, error) {
                    console.log("ERROR: " + error);
                }
            });
        });
    });
</script>
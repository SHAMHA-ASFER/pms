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
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $taskQAs = $this->taskQAModel->getAllTasks($_SESSION['id']);
            while ($taskQA = $taskQAs->fetch_assoc()) {
                $tasks = $this->taskModel->getTask($taskQA['task_id']);
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
                        } ?>;" class="col-md-4"><?php echo $task['description']; ?></td>
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
                        } ?>;" class="col-md-3">
                            <form action="/task/status/change" method="post">
                                <input type="hidden" name="pro_id" value="<?php echo $pro_id; ?>">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <select name="status" class="form-select" onchange="form.submit()">
                                    <option value="pending"   <?php if ($task['status'] == 'pending') { echo 'selected'; } ?>>Pending</option>
                                    <option value="completed" <?php if ($task['status'] == 'completed') { echo 'selected'; } ?>>Completed</option>
                                    <option value="denied"    <?php if ($task['status'] == 'denied') { echo 'selected'; } ?>>Denied</option>
                                </select>
                            </form>
                        </td>
                        <td class="text-center" style="background-color:<?php
                        if ($task['status'] == 'pending') {
                            echo 'rgba(247, 254, 144, 0.5)';
                        } else if ($task['status'] == 'completed') {
                            echo 'rgba(128, 255, 109, 0.5)';
                        } else if ($task['status'] == 'denied') {
                            echo 'rgba(255, 145, 145, 0.5)';
                        } ?>;" class="col-md-2">
                            <form action="/task/files/download" method="post">
                                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                <input type="hidden" name="pro_id" value="<?php echo $pro_id; ?>">
                                <button class="btn btn-primary"><i class="fa fa-download"></i>&nbsp;Download</button>
                            </form>
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
<script>
    $(document).ready(function () {
        $('#taskTable').DataTable();
    });
</script>   
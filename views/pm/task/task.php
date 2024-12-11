<?php
$pro_id = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<div class="container">
    <div class="m-5 w-100">
        <div class="pt-3 w-100">
            <h5>Create Task</h5>
            <input type="hidden" id="pm" value="<?php echo $_SESSION['id']; ?>">
            <form action="/task/create" method="post">
                <div class="d-flex justify-content-between mb-3">
                    <input type="hidden" name="pro_id" value="<?php echo $pro_id; ?>">
                    <div class="input-group me-3 align-self-start" style="max-width: 450px;">
                        <div class="input-group-text">Enter task</div>
                        <input type="text" id="task" name="task" class="form-control" placeholder="Write task here"
                            required>
                    </div>
                    <div class="input-group mb-3" style="max-width: 450px;">
                        <div class="input-group-text">Deadline</div>
                        <div class="d-flex">
                            <div class="">
                                <select name="day" id="day" class="form-select rounded-0">
                                    <option value="" default>Day</option>
                                    <?php
                                    for ($i = 1; $i <= 31; $i++) {
                                        ?>
                                        <option value="<?php if ($i < 10) {
                                            echo '0' . $i;
                                        } else {
                                            echo $i;
                                        } ?>">
                                            <?php echo $i; ?>
                                        </option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="">
                                <select name="month" id="month" class="form-select rounded-0">
                                    <option value="" default>Month</option>
                                    <?php
                                    for ($i = 1; $i <= 12; $i++) {
                                        $month = date('F', mktime(0, 0, 0, $i, 1));
                                        ?>
                                        <option value="<?php if ($i < 10) {
                                            echo '0' . $i;
                                        } else {
                                            echo $i;
                                        } ?>">
                                            <?php echo $month; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="">
                                <select name="year" id="year" class="form-select rounded-0">
                                    <option value="" default>Year</option>
                                    <?php
                                    $currentYear = date('Y');
                                    for ($i = $currentYear - 5; $i <= $currentYear + 30; $i++) {
                                        ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success col-md-2 align-self-start"><i
                            class="fa fa-pencil"></i>&nbsp;&nbsp;CreateTask</button>
                </div>
                <textarea name="description" class="form-control" placeholder="Write description here" rows="2"
                    style="resize:none;"></textarea>
            </form>
        </div>
    </div>
    <div class="m-5 w-100">
        <h5>
            <?php
            $projects = $this->projectModel->getName($pro_id);
            while ($project = $projects->fetch_assoc()) {
                echo $project['name'];
            }
            ?>&nbsp;Tasks
        </h5>
        <table id="taskManagement" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Developer</th>
                    <th>QA</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tasks = $this->taskModel->getAllTask($pro_id);
                while ($task = $tasks->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $task['name']; ?></td>
                        <td>
                            <?php
                            $i = 0;
                            $devs = $this->taskDeveloperModel->getAllDevelopers($task['id']);
                            while ($dev = $devs->fetch_assoc()) {
                                $users = $this->userModel->getName($dev['dev_id']);
                                while ($user = $users->fetch_assoc()) {
                                    echo ucfirst($user['fname']) . " " . ucfirst($user["lname"]);
                                    $i++;
                                }
                            }
                            if ($i == 0) {
                                echo "No Assigned";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            $i = 0;
                            $qas = $this->taskQAModel->getAllQas($task["id"]);
                            while ($qa = $qas->fetch_assoc()) {
                                $users = $this->userModel->getName($qa['qa_id']);
                                while ($user = $users->fetch_assoc()) {
                                    echo ucfirst($user['fname']) . " " . ucfirst($user["lname"]);
                                    $i++;
                                }
                            }
                            if ($i == 0) {
                                echo "No Assigned";
                            }
                            ?>
                        </td>
                        <td><?php echo $task['status']; ?></td>
                        <td class="col-md-3">
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addMember-<?php echo $task['id']; ?>"><i
                                    class="fa fa-plus"></i>&nbsp;Add</button>
                            <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#removeMember-<?php echo $task['id']; ?>"><i class="fa fa-trash"></i>&nbsp;Remove</button>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$tasks = $this->taskModel->getAllTask($pro_id);
while ($task = $tasks->fetch_assoc()) {
    ?>
    <div class="modal fade" id="addMember-<?php echo $task['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/taskmember/add" method="post">
                    <div class="modal-header">
                        <div class="d-flex w-100 justify-content-between">
                            <h5>Add member</h5>
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                        <input type="hidden" name="pro_id" value="<?php echo $task['project_id']; ?>">
                        <div class="input-group mb-3">
                            <div class="input-group-text col-md-4">Choose role</div>
                            <select name="role" id="role-<?php echo $task['id']; ?>" class="form-select">
                                <option value="">Select</option>
                                <option value="DEV">Developer</option>
                                <option value="QA">QA</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <div class="input-group-text col-md-4">Select Member</div>
                            <select name="mem_id" id="members-<?php echo $task['id']; ?>" class="form-select">
                                <option value="select">Select</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add member</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>

<?php
$tasks = $this->taskModel->getAllTask($pro_id);
while ($task = $tasks->fetch_assoc()) {
    $devs = $this->taskDeveloperModel->getAllDevelopers($task['id']);
    $dev_id = 0;
    while ($dev = $devs->fetch_assoc()) {
        $dev_id = $dev['dev_id'];
    }
    $qas = $this->taskQAModel->getAllQas($task['id']);
    $qa_id = 0;
    while ($qa = $qas->fetch_assoc()) {
        $qa_id = $qa['qa_id'];
    }
?>
<div class="modal fade" id="removeMember-<?php echo $task['id']; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/taskmember/remove" method="post">
                <div class="modal-header">
                    <div class="d-flex justify-content-between w-100">
                        <h5>Remove Member</h5>
                        <button class="btn btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input type="hidden" name="id" value="<?php echo $pro_id; ?>">
                        <input type="hidden" name="dev" value="<?php echo $dev_id; ?>">
                        <input type="hidden" name="qa" value="<?php echo $qa_id; ?>">
                        <input type="hidden" name="task" value="<?php echo $task['id']; ?>">
                        <div class="input-group-text">Select Role</div>
                        <select name="mem_type" class="form-select">
                            <option value="DEV">Developer</option>
                            <option value="QA">QA</option>
                            <option value="BOTH">Both</option>
                            <option value="TASK">Task</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Remove</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
}
?>

<script>
    $(document).ready(function () {
        $('#taskManagement').DataTable();
        $(document).on('change', '[id^=role-]', function () {
            const modaId = $(this).attr('id').split('role-')[1];
            const type = $(this).val();
            const pm = $('#pm').val();
            const formData = new FormData();
            formData.append('type', type);
            formData.append('pm', pm);  
            $.ajax({
                url:'/users/get',
                type:'post',
                data:formData,
                contentType:false,
                processData:false,
                success:function(response) {
                    $(`#members-${modaId}`).empty();
                    const expression = response.split('<\?>');
                    expression[1].split('<*>').forEach(element => {
                        if (element) {
                            const member = element.split(',');
                            $(`#members-${modaId}`).append($(`<option value="${member[0]}">${member[1]}</option>`))
                        }
                    });
                },
                error:function(xhr, status, error) {
                    console.log("ERROR: " + error);
                }
            });
        });
    });
</script>
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
                                    <option value="pending" <?php if ($task['status'] == 'pending') {
                                        echo 'selected';
                                    } ?>>
                                        Pending</option>
                                    <option value="completed" <?php if ($task['status'] == 'completed') {
                                        echo 'selected';
                                    } ?>>
                                        Completed</option>
                                    <option value="denied" <?php if ($task['status'] == 'denied') {
                                        echo 'selected';
                                    } ?>>Denied
                                    </option>
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

<div class="position-fixed bottom-0 start-0 ms-2 mb-2">
    <button id="chatPopUp" type="button" class="btn btn-primary rounded-5"><i class="fa fa-commenting"></i></button>
</div>
<div id="chatContainer" class="card position-fixed d-none bottom-0 start-0 ms-2 mb-5 zindex-1000"
    style="min-width:50vw;" aria-labelledby=" dropdownMenuButton">
    <div class="d-flex justify-content-between w-100 p-2">
        <h5>Chat members</h5>
        <button type="button" class="btn btn-close" id="closeChat"></button>
    </div>
    <hr class="m-0">
    <div class="row g-0">
        <div class="card rounded-0 col-md-5">
            <div class="card-body overflow-auto" style="min-height:50vh;">
                <input type="hidden" id="pro_id" value="<?php echo $pro_id; ?>">
                <input type="hidden" id="myId" value="<?php echo $_SESSION['id']; ?>">
                <?php
                $projects = $this->projectModel->getProject($pro_id);
                while ($project = $projects->fetch_assoc()) {
                    $users = $this->userModel->getName($project['created_by']);
                    while ($user = $users->fetch_assoc()) {
                        if ($user['id'] == $_SESSION['id'])
                            continue;
                        ?>
                        <p class="p-2 hover m-0" id="member-<?php echo $user['id']; ?>">
                            <?php echo ucfirst($user['fname']) . " " . ucfirst($user['lname']); ?>&nbsp;&nbsp;<span
                                class="btn btn-outline-secondary rounded-5 border-2 pt-0 pb-0">Manager</span>
                        </p>
                        <?php
                    }
                }
                $projectAnalyzers = $this->projectAnalyzerModel->getAllAnalyzers($pro_id);
                while ($analyzer = $projectAnalyzers->fetch_assoc()) {
                    $users = $this->userModel->getName($analyzer['user_id']);
                    while ($user = $users->fetch_assoc()) {
                        if ($user['id'] == $_SESSION['id'])
                            continue;
                        ?>
                        <p class="p-2 hover m-0" id="member-<?php echo $user['id']; ?>">
                            <?php echo ucfirst($user['fname']) . " " . ucfirst($user['lname']); ?>&nbsp;&nbsp;<span
                                class="btn btn-outline-secondary rounded-5 border-2 pt-0 pb-0">analyzer</span>
                        </p>
                        <?php
                    }
                }
                $projectDevs = $this->projectDeveloperModel->getAllDevelopers($pro_id);
                while ($dev = $projectDevs->fetch_assoc()) {
                    $users = $this->userModel->getName($dev['user_id']);
                    while ($user = $users->fetch_assoc()) {
                        if ($user['id'] == $_SESSION['id'])
                            continue;
                        ?>
                        <p class="p-2 hover m-0" id="member-<?php echo $user['id']; ?>">
                            <?php echo ucfirst($user['fname']) . " " . ucfirst($user['lname']); ?>&nbsp;&nbsp;<span
                                class="btn btn-outline-secondary rounded-5 border-2 pt-0 pb-0">dev</span>
                        </p>
                        <?php
                    }
                }
                $projectQAs = $this->projectQAModel->getAllQAs($pro_id);
                while ($qa = $projectQAs->fetch_assoc()) {
                    $users = $this->userModel->getName($qa['user_id']);
                    while ($user = $users->fetch_assoc()) {
                        if ($user['id'] == $_SESSION['id'])
                            continue;
                        ?>
                        <p class="p-2 hover m-0" id="member-<?php echo $user['id']; ?>">
                            <?php echo ucfirst($user['fname']) . " " . ucfirst($user['lname']); ?>&nbsp;&nbsp;<span
                                class="btn btn-outline-secondary rounded-5 border-2 pt-0 pb-0">qa</span>
                        </p>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="card rounded-0 col-md-7">
            <div class="card-body">
                <div id="conversation" class="p-2 overflow-auto">
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex w-100">
                    <input type="text" id="message-text" placeholder="Type message" class="form-control me-2">
                    <button type="button" id="send-message" class="btn btn-primary rounded-5"><i
                            class="fa fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#taskTable').DataTable();
        $('#closeChat').click(function () {
            $('#chatContainer').addClass('d-none');
        });
        $('#chatPopUp').click(function () {
            $('#chatContainer').toggleClass('d-none');
        });

        var id = 0;
        var messages = [];
        const update_conversation = () => {
            const formData = new FormData();
            formData.append('user_id', id);
            formData.append('pro_id', $('#pro_id').val());
            $.ajax({
                url: '/member/chats',
                data: formData,
                type: 'post',
                contentType: false,
                processData: false,
                success: function (response) {
                    const regex = /\[(.*?)\]/g;
                    const matches = response.matchAll(regex);
                    for (const match of matches) {
                        $.each(match[1].split('<#>'), function (idx, value) {
                            if (value) {
                                const msg_data = value.split('<\?>');
                                if (!messages.includes(msg_data[0])) {
                                    messages.push(msg_data[0]);
                                    if (msg_data[2] == $('#myId').val()) {
                                        $('#conversation').append(`
                                        <div class="d-flex justify-content-end mb-2">
                                            <div class="p-2 rounded-1 bg-primary text-white">${msg_data[4]}</div>
                                        </div>
                                    `);
                                    } else {
                                        $('#conversation').append(`
                                        <div class="d-flex justify-content-start mb-2">
                                            <div class="p-2 rounded-1 bg-secondary text-white">${msg_data[4]}</div>
                                        </div>
                                    `);
                                    }
                                }
                            }
                        });
                    }
                },
                error: function (xhr, status, error) {
                    print('ERROR: ' + error);
                }
            });
        }

        $('[id^=member-]').on('click', function () {
            id = $(this).attr('id').split('-')[1];
            $('[id^=member-]').each(function () {
                $(this).removeClass('bg-primary');
            });
            $('#member-' + id).addClass('bg-primary');
            messages = [];
            $('#conversation').empty();
        });

        $('#send-message').click(function () {
            const message = $('#message-text').val();
            if (id != 0) {
                if (message) {
                    const formData = new FormData();
                    formData.append('pro_id', $('#pro_id').val());
                    formData.append('user_id', id);
                    formData.append('message', message);
                    $.ajax({
                        url: '/member/chat/send',
                        data: formData,
                        type: 'post',
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            $('#message-text').val('');
                        },
                        error: function (xhr, status, error) {
                            print('ERROR: ' + error);
                        }
                    });
                }
            } else {
                alert('Please select a member to chat with.');
            }
        });

        setInterval(update_conversation, 1000);
    });
</script>
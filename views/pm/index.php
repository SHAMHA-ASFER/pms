<div class="container mt-5 mb-5">
    <div class="row pt-5 gx-5" style="max-width: 95%; margin: auto;">
        <form action="/project/create" method="post">
            <h4>Create Project</h4>
            <div class="d-flex">
                <div class="col-md-6 mb-4 me-3">
                    <div class="form-group mb-2">
                        <label for="docTitle">Project Title</label>
                        <input type="text" id="docTitle" class="form-control" name="project"
                            placeholder="Enter project title" required>
                    </div>
                    <div class="form-group">
                        <label for="desc">Deadline</label>
                        <div class="d-flex">
                            <select name="day" class="form-select me-2">
                                <option value="Day" default>Day</option>
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
                            <select name="month" class="form-select me-2">
                                <option value="Month" default>Month</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    $month = date('F', mktime(0, 0, 0, $i, 1));
                                    ?>
                                    <option value="<?php if ($i < 10) {
                                        echo '0' . $i;
                                    } else {
                                        echo $i;
                                    } ?>" default>
                                        <?php echo $month; ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                            <select name="year" class="form-select">
                                <option value="Year" default>Year</option>
                                <?php
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i <= $currentYear + 30; $i++) {
                                    ?>
                                    <option value="<?php echo $i; ?>" default><?php echo $i; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-success mt-3">Create Project</button>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-group mb-3">
                        <label for="desc">Description</label>
                        <textarea name="description" class="form-control" placeholder="Enter description"
                            rows="4"></textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="p-5">
        <table class="table table-striped" id="projectsTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Desc</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $projects = $this->projectModel->getAllProjects();
                $i = 1;
                while ($project = $projects->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $project['name']; ?></td>
                        <td class="col-md-4"><?php echo $project['description']; ?></td>
                        <td class="text-center"><?php echo $project['create_date'] . "<br>to<br>" . $project['deadline']; ?>
                        </td>
                        <td>
                            <form action="/project/status/change" method="post">
                                <input type="hidden" name="pro_id" value="<?php echo $project["id"]; ?>">
                                <select name="status" class="form-select" onchange="form.submit()">
                                    <option value="completed" <?php if ($project['status'] == 'completed') {
                                        echo 'selected';
                                    } ?>>Completed</option>
                                    <option value="pending" <?php if ($project['status'] == 'pending') {
                                        echo 'selected';
                                    } ?>>Pending</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="/project/remove" method="post">
                                <input type="hidden" name="pro_id" value="<?php echo $project["id"]; ?>">
                                <button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Remove</button>
                            </form>
                            <button type="button" id="see-chat-<?php echo $project['id']; ?>"
                                class="btn btn-primary mt-3"><i class="fa fa-commenting"></i>&nbsp;Chat</button>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$projects = $this->projectModel->getAllProjects();
while ($project = $projects->fetch_assoc()) {
    ?>
    <div id="chatContainer-<?php echo $project['id']; ?>"
        class="card position-fixed d-none bottom-0 start-0 ms-2 mb-5 zindex-1000" style="min-width:50vw;"
        aria-labelledby=" dropdownMenuButton">
        <div class="d-flex justify-content-between w-100 p-2">
            <h5>Chat members</h5>
            <button type="button" class="btn btn-close" id="closeChat-<?php echo $project['id']; ?>"></button>
        </div>
        <hr class="m-0">
        <div class="row g-0">
            <div class="card rounded-0 col-md-5">
                <div class="card-body overflow-auto" style="min-height:50vh;">
                    <input type="hidden" id="pro_id" value="<?php echo $project['id']; ?>">
                    <input type="hidden" id="myId" value="<?php echo $_SESSION['id']; ?>">
                    <?php
                    $pros = $this->projectModel->getProject($project['id']);
                    while ($pro = $pros->fetch_assoc()) {
                        $users = $this->userModel->getName($pro['created_by']);
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
                    $projectAnalyzers = $this->projectAnalyzerModel->getAllAnalyzers($project['id']);
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
                    $projectDevs = $this->projectDeveloperModel->getAllDevelopers($project['id']);
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
                    $projectQAs = $this->projectQAModel->getAllQAs($project['id']);
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
                    <div id="conversation-<?php echo $project['id']; ?>" class="p-2 overflow-auto">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex w-100">
                        <input type="text" id="message-text-<?php echo $project['id']; ?>" placeholder="Type message"
                            class="form-control me-2">
                        <button type="button" id="send-message-<?php echo $project['id']; ?>"
                            class="btn btn-primary rounded-5"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>

<script>
    $(document).ready(function () {
        $('#projectsTable').DataTable();
    });
    const print = (data) => {
        console.log(data);
    }
    var pro_id = 0;
    $('[id^=see-chat-]').click(function () {
        var id = $(this).attr('id').split('-')[2];
        $('#chatContainer-' + id).toggleClass('d-none');
        pro_id = id;
    });
    $('[id^=closeChat-]').click(function () {
        var id = $(this).attr('id').split('-')[1];
        $('#chatContainer-' + id).toggleClass('d-none');
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
                                    $('#conversation-' + pro_id).append(`
                                        <div class="d-flex justify-content-end mb-2">
                                            <div class="p-2 rounded-1 bg-primary text-white">${msg_data[4]}</div>
                                        </div>
                                    `);
                                } else {
                                    $('#conversation-' + pro_id).append(`
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
    $('[id^=send-message-]').click(function () {
        const mid = $(this).attr('id').split('-')[2];
        const message = $('#message-text-' + mid).val();
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
        setInterval(update_conversation, 1000);
    });
</script>
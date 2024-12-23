<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-center ms-5 me-5 pt-5">
        <div class="w-100">
            <form action="/doc/create" method="post" enctype="multipart/form-data"
                class="d-flex justify-content-between">
                <div class="col mb-4 me-4">
                    <h4>Create Project Document</h4>
                    <div class="form-group">
                        <label for="docTitle">Document Title</label>
                        <input type="text" id="docTitle" class="form-control" placeholder="Enter document title"
                            name="name" required>
                    </div>
                    <button id="createDocBtn" class="btn btn-success mt-3">Create Document</button>
                </div>
                <div class="col mb-4 me-4">
                    <h4>Select Project</h4>
                    <div class="form-group">
                        <label for="selectProject">Project Title</label>
                        <select id="selectProject" class="form-select" name="project" required>
                            <option value="">Select Project</option>
                            <?php
                            while ($row = $projects->fetch_assoc()) {
                                $projectName = "";
                                $result = $this->projectModel->getName($row["pro_id"]);
                                while ($r = $result->fetch_assoc()) {
                                    $projectName = $r["name"];
                                }
                                ?>
                                <option value="<?php echo $row['pro_id']; ?>"><?php echo $projectName; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col mb-4">
                    <h4>Select File</h4>
                    <div class="form-group">
                        <label for="file">File</label>
                        <input type="file" id="file" name="doc" class="form-control" required>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="card mx-auto" style="max-width: 91.5%;">
        <div class="card-header">
            <h5>Project Documents</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="documentsTable" class="table table-striped table-bordered" style="min-width: 1000px;">
                    <thead>
                        <tr>
                            <th>Document Title</th>
                            <th>Project Title</th>
                            <th>Chat</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $documents->fetch_assoc()) {
                            $res = $model->getName($row["pro_id"]);
                            $projectName = "";
                            while ($r = $res->fetch_assoc()) {
                                $projectName = $r["name"];
                            }
                            ?>
                            <tr>
                                <td style="background-color:<?php
                                if ($row['status'] == 'pending') {
                                    echo 'rgba(247, 254, 144, 0.5)';
                                } else if ($row['status'] == 'accepted') {
                                    echo 'rgba(128, 255, 109, 0.5)';
                                } else if ($row['status'] == 'denied') {
                                    echo 'rgba(255, 145, 145, 0.5)';
                                } ?>;"><?php echo $row['name']; ?></td>
                                <td style="background-color:<?php
                                if ($row['status'] == 'pending') {
                                    echo 'rgba(247, 254, 144, 0.5)';
                                } else if ($row['status'] == 'accepted') {
                                    echo 'rgba(128, 255, 109, 0.5)';
                                } else if ($row['status'] == 'denied') {
                                    echo 'rgba(255, 145, 145, 0.5)';
                                } ?>;"><?php echo $projectName; ?></td>
                                <td class="text-center" style="background-color:<?php
                                if ($row['status'] == 'pending') {
                                    echo 'rgba(247, 254, 144, 0.5)';
                                } else if ($row['status'] == 'accepted') {
                                    echo 'rgba(128, 255, 109, 0.5)';
                                } else if ($row['status'] == 'denied') {
                                    echo 'rgba(255, 145, 145, 0.5)';
                                } ?>;">
                                    <button type="button" id="see-chat-<?php echo $row['pro_id']; ?>"
                                        class="btn btn-primary"><i class="fa fa-commenting"></i>&nbsp;Open</button>
                                </td>
                                <?php
                                if ($row['status'] == 'accepted') {
                                    ?>
                                    <td style="background-color:<?php
                                    if ($row['status'] == 'pending') {
                                        echo 'rgba(247, 254, 144, 0.5)';
                                    } else if ($row['status'] == 'accepted') {
                                        echo 'rgba(128, 255, 109, 0.5)';
                                    } else if ($row['status'] == 'denied') {
                                        echo 'rgba(255, 145, 145, 0.5)';
                                    } ?>;" class="col-md-3">
                                        <span>Document Validated&nbsp;<i class="fa fa-info-circle pt-1 ps-2"></i>
                                        </span>
                                    </td>
                                    <?php
                                } else { ?>
                                    <td style="background-color:<?php
                                    if ($row['status'] == 'pending') {
                                        echo 'rgba(247, 254, 144, 0.5)';
                                    } else if ($row['status'] == 'accepted') {
                                        echo 'rgba(128, 255, 109, 0.5)';
                                    } else if ($row['status'] == 'denied') {
                                        echo 'rgba(255, 145, 145, 0.5)';
                                    } ?>;min-width: 200px;display:flex;">
                                        <button class="btn btn-primary me-3" data-bs-toggle="modal"
                                            data-bs-target="#update-doc-<?php echo $row['id']; ?>"><i
                                                class="fa fa-refresh"></i>&nbsp;Update</button>
                                        <form action="/doc/delete" method="post">
                                            <input type="hidden" name="doc" value="<?php echo $row['id']; ?>">
                                            <button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Delete</button>
                                        </form>
                                    </td>
                                    <?php
                                }
                                ?>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
while ($row = $mdocuments->fetch_assoc()) {
    ?>
    <div class="modal fade" id="update-doc-<?php echo $row['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/doc/update" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <div class="w-100 d-flex justify-content-between">
                            <h5 class="modal-title">Update Document</h5>
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="pro_id" value="<?php echo $row['pro_id']; ?>">
                        <input type="file" name="doc" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
while ($row = $mdocuments->fetch_assoc()) {
    ?>
    <div class="modal fade" id="update-doc-<?php echo $row['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/doc/update" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <div class="w-100 d-flex justify-content-between">
                            <h5 class="modal-title">Update Document</h5>
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="pro_id" value="<?php echo $row['pro_id']; ?>">
                        <input type="file" name="doc" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><i class="fa fa-refresh"></i>&nbsp;Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}
$documents = $this->documentModel->getAllDocuments($_SESSION['id']);
while ($doc = $documents->fetch_assoc()) {
?>
<div id="chatContainer-<?php echo $doc['pro_id']; ?>"
        class="card position-fixed d-none bottom-0 start-0 ms-2 mb-5 zindex-1000" style="min-width:50vw;"
        aria-labelledby=" dropdownMenuButton">
        <div class="d-flex justify-content-between w-100 p-2">
            <h5>Chat members</h5>
            <button type="button" class="btn btn-close" id="closeChat-<?php echo $doc['pro_id']; ?>"></button>
        </div>
        <hr class="m-0">
        <div class="row g-0">
            <div class="card rounded-0 col-md-5">
                <div class="card-body overflow-auto" style="min-height:50vh;">
                    <input type="hidden" id="pro_id" value="<?php echo $doc['pro_id']; ?>">
                    <input type="hidden" id="myId" value="<?php echo $_SESSION['id']; ?>">
                    <?php
                    $pros = $this->projectModel->getProject($doc['pro_id']);
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
                    $projectAnalyzers = $this->projectAnalyzerModel->getAllAnalyzers($doc['pro_id']);
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
                    $projectDevs = $this->projectDeveloperModel->getAllDevelopers($doc['pro_id']);
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
                    $projectQAs = $this->projectQAModel->getAllQAs($doc['pro_id']);
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
                    <div id="conversation-<?php echo $doc['pro_id']; ?>" class="p-2 overflow-auto">
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex w-100">
                        <input type="text" id="message-text-<?php echo $doc['pro_id']; ?>" placeholder="Type message"
                            class="form-control me-2">
                        <button type="button" id="send-message-<?php echo $doc['pro_id']; ?>"
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
        $('#documentsTable').DataTable();
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
            $('[id^=member-]').each(function() {
                $(this).removeClass('bg-primary');
            });
            $('#member-'+id).addClass('bg-primary');
            messages = [];
            $('#conversation-'+pro_id).empty();
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
        setInterval(update_conversation, 1000);
    });
</script>
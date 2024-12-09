<div class="container-fluid w-100 mt-5 mb-5">
    <div class="d-flex justify-content-center">
        <div class="card mx-auto col-md-11">
            <div class="card-header">
                <h5>Manage Developers For Each Projects</h5>
            </div>
            <div class="card-body">
                <table id="projectDevelopers" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Developers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $projects = $this->projectModel->getAllProjects();
                        while ($project = $projects->fetch_assoc()) {
                            $dev_count = 1;
                            $counts = $this->projectDeveloperModel->getCount($project["id"]);
                            while ($count = $counts->fetch_assoc()) {
                                $dev_count = $count["count"];
                            }
                            $developers = $this->projectDeveloperModel->getAllDevelopers($project["id"]);
                            while ($developer = $developers->fetch_assoc()) {
                                $name = "";
                                $users = $this->userModel->getName($developer["user_id"]);
                                while ($user = $users->fetch_assoc()) {
                                    $name = ucfirst($user["fname"]) . " " . ucfirst($user["lname"]);
                                }
                                if ($i == 0) {
                                    ?>
                                    <tr>
                                        <td rowspan="<?php echo $dev_count; ?>"><?php echo $project['name']; ?></td>
                                        <td class="text-center"><?php echo $name; ?></td>
                                        <td class="col-md-2" rowspan="<?php echo $dev_count; ?>">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addDeveloper-<?php echo $project['id']; ?>"><i
                                                    class="fa fa-plus"></i>&nbsp;Add</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#removeDeveloper-<?php echo $project['id']; ?>"><i
                                                    class="fa fa-trash"></i>&nbsp;Remove</button>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $name; ?></td>
                                    </tr>
                                    <?php
                                }
                                $i++;
                            }
                            if ($i == 0) {
                                ?>
                                <tr>
                                    <td><?php echo $project['name']; ?></td>
                                    <td class="text-center">Not Available</td>
                                    <td class="col-md-1">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addDeveloper-<?php echo $project['id']; ?>"><i
                                                class="fa fa-plus"></i>&nbsp;Add</button>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
$projects = $this->projectModel->getAllProjects();
while ($project = $projects->fetch_assoc()) {
    ?>
    <div class="modal fade" id="addDeveloper-<?php echo $project['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/projectdev/add" method="post">
                    <div class="modal-header">
                        <div class="d-flex justify-content-between w-100">
                            <h5>Add a Developer</h5>
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="input-group-text">Choose Developer</div>
                            <input type="hidden" name="pro_id" value="<?php echo $project['id']; ?>">
                            <select name="user_id" class="form-select">
                                <option value="Select" default>Select</option>
                                <?php
                                $users = $this->userModel->getUserByManager($project['created_by'], "DEV");
                                while ($user = $users->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $user['id']; ?>">
                                        <?php echo ucfirst($user['fname']) . " " . ucfirst($user['lname']); ?>
                                    </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><i class="fa fa-plus"></i>&nbsp;Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php
}

?>
<?php
$projects = $this->projectModel->getAllProjects();
while ($project = $projects->fetch_assoc()) {
    ?>
    <div class="modal fade" id="removeDeveloper-<?php echo $project['id']; ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="/projectdev/remove" method="post">
                    <div class="modal-header">
                        <div class="d-flex justify-content-between w-100">
                            <h5>Remove Developer</h5>
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="input-group-text">
                                Select Developer
                            </div>
                            <input type="hidden" name="pro_id" value="<?php echo $project['id'] ?>">
                            <select name="user_id" class="form-select" >
                                <option value="" default>Select</option>
                                <?php
                                $developers = $this->projectDeveloperModel->getAllDevelopers($project['id']);
                                while ($developer = $developers->fetch_assoc()) { 
                                    $name = "";
                                    $users = $this->userModel->getName($developer["user_id"]);
                                    while ($user = $users->fetch_assoc()) {
                                        $name = ucfirst($user["fname"]) . " " . ucfirst($user["lname"]);
                                    }
                                    ?>
                                    <option value="<?php echo $developer['user_id']; ?>"><?php echo $name; ?></option>
                                    <?php
                                }
                                ?>
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
        $('#projectDevelopers').DataTable();
    });
</script>
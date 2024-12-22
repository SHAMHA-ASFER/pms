<div class="container">
    <h3>Allocated Projects</h3>
    <table class="table table-striped" id="projectTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Manager</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            $projectDevs = $this->projectDeveloperModel->getAllProjects($_SESSION['id']);
            while ($projectDev = $projectDevs->fetch_assoc()) {
                $projects = $this->projectModel->getProject($projectDev['pro_id']);
                while ($project = $projects->fetch_assoc()) {
                    ?>
                    <tr>
                        <td class="col-md-1"><?php echo $i; ?></td>
                        <td class="col-md-2">
                            <a href="?page=task&id=<?php echo $project['id']; ?>"
                                class="text-decoration-none fw-bold pointer"><?php echo $project['name']; ?></a>
                        </td>
                        <td class="col-md-5"><?php echo $project['description']; ?></td>
                        <td class="col-md-2">
                            <?php
                            $users = $this->userModel->getName($project['created_by']);
                            while ($user = $users->fetch_assoc()) {
                                echo ucfirst($user['fname']) . " " . ucfirst($user['lname']);
                            }
                            ?>
                        </td>
                        <td class="col-md-1"><?php echo $project['deadline']; ?></td>
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
        $('#projectTable').DataTable();
    });
</script>
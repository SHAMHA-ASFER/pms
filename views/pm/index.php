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
                                <option value="<?php if ($i < 10) { echo '0' . $i; } else { echo $i; } ?>"><?php echo $i; ?></option>
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
                                <option value="<?php if ($i < 10) { echo '0' . $i; } else { echo $i; } ?>" default><?php echo $month; ?></option>
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
                    <td class="text-center"><?php echo $project['create_date'] . "<br>to<br>" . $project['deadline']; ?></td>
                    <td>
                        <form action="/project/status/change" method="post">
                            <input type="hidden" name="pro_id" value="<?php echo $project["id"]; ?>">
                            <select name="status" class="form-select" onchange="form.submit()">
                                <option value="completed" <?php if ($project['status'] == 'completed') { echo 'selected'; } ?>>Completed</option>
                                <option value="pending" <?php if ($project['status'] == 'pending') { echo 'selected'; } ?>>Pending</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form action="/project/remove" method="post">
                           <input type="hidden" name="pro_id" value="<?php echo $project["id"]; ?>">
                            <button class="btn btn-danger"><i class="fa fa-trash"></i>&nbsp;Remove</button>
                        </form>
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

<script>
    $(document).ready(function() {
        $('#projectsTable').DataTable();
    });
</script>
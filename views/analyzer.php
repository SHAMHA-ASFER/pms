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
                                }?>;"><?php echo $row['name']; ?></td>
                                <td style="background-color:<?php 
                                if ($row['status'] == 'pending') {
                                    echo 'rgba(247, 254, 144, 0.5)';
                                } else if ($row['status'] == 'accepted') {
                                    echo 'rgba(128, 255, 109, 0.5)';
                                } else if ($row['status'] == 'denied') {
                                    echo 'rgba(255, 145, 145, 0.5)';
                                }?>;"><?php echo $projectName; ?></td>
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
                                    }?>;" class="col-md-3">
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
                                    }?>;min-width: 200px;display:flex;">
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
?>
<script>
    $(document).ready(function () {
        $('#documentsTable').DataTable();
    });
</script>
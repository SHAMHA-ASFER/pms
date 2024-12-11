<div class="container-fluid w-100 mt-5 mb-5">
    <div class="d-flex justify-content-center pt-5">
        <div class="card mx-auto col-md-11">
            <div class="card-header">
                <h5>Manage Analyzers For Each Projects</h5>
            </div>
            <div class="card-body">
                <table id="projectAnalyzers" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Analyzers</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Loop each Projects Information
                        while ($row = $result->fetch_assoc()) {
                            // Find Count of analyzers added to current project
                            $count_res = $this->projectAnalyzerModel->getCount($row["id"]);
                            $count = 1;
                            while ($r = $count_res->fetch_assoc()) {
                                $count = $r["count"];
                            }
                            // 
                            $analyzers = $this->projectAnalyzerModel->getAllAnalyzers($row["id"]);
                            $i = 0;
                            while ($r = $analyzers->fetch_assoc()) {
                                if ($i == 0) {
                                    ?>
                                    <tr>
                                        <td rowspan="<?php echo $count; ?>"><?php echo $row['name']; ?></td>
                                        <td>
                                            <?php
                                                $users = $this->userModel->getName($r['user_id']);
                                                while ($nr = $users->fetch_assoc()) {
                                                    echo ucfirst($nr['fname']) . " " . ucfirst($nr['lname']); 
                                                }
                                            ?>
                                        </td>
                                        <td rowspan="<?php echo $count; ?>" class="col-md-2">
                                            <button class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addAnalyzer-<?php echo $row["id"]; ?>"><i
                                                    class="fa fa-plus"></i>&nbsp;Add</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#removeAnalyzer-<?php echo $row["id"]; ?>"><i
                                                    class="fa fa-trash"></i>&nbsp;Remove</button>
                                        </td>
                                    </tr>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                                $i++;
                            }
                            if ($i == 0) {
                                ?>
                                <tr>
                                    <td><?php echo $row['name']; ?></td>
                                    <td>Not Available</td>
                                    <td class="col-md-1">
                                        <button class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#addAnalyzer-<?php echo $row["id"]; ?>"><i
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
$result = $this->projectModel->getAllProjects();
while ($row = $result->fetch_assoc()) {
    ?>
    <div class="modal fade" id="addAnalyzer-<?php echo $row["id"]; ?>">
        <div class="modal-dialog">
            <div class="modal-content"> 
                <form action="/projectanalyzer/add" method="post">
                    <div class="modal-header">
                        <div class="d-flex justify-content-between w-100">
                            <h5>Add an analyzer</h5>
                            <button class="btn btn-close" data-bs-dismiss="modal"></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="input-group-text">Choose Analyzer</div>
                            <input type="hidden" name="pro_id" value="<?php echo $row['id']; ?>">
                            <select name="analyzer" class="form-select">
                                <option value="Select" default>Select</option>
                                <?php
                                $res = $this->userModel->getUserByManager($row["created_by"], "ANA");
                                while ($r = $res->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $r['id']; ?>">
                                        <?php echo ucfirst($r['fname']) . ' ' . ucfirst($r['lname']); ?></option>
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
$result = $this->projectModel->getAllProjects();
while ($row = $result->fetch_assoc()) {
?>
<div class="modal fade" id = "removeAnalyzer-<?php echo $row['id']; ?>">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/projectanalyzer/remove" method="post">
                <div class="modal-header">
                    <div class="d-flex justify-content-between w-100">
                        <h5>Remove an Analyzer</h5>
                        <button class="btn btn-close" data-bs-dismiss="modal"></button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-text">
                            Select an Analyzer
                        </div>
                        <input type="hidden" name="pro_id" value="<?php echo $row['id']; ?>">
                        <select name="user_id" class="form-select">
                            <option value="" default>Select</option>
                            <?php 
                            $res=$this->projectAnalyzerModel->getAllAnalyzers($row['id']);
                            while($r = $res->fetch_assoc()) {
                                $rslt = $this->userModel->getName($r['user_id']);
                                $name = "";
                                while($rw = $rslt->fetch_assoc()){
                                    $name = ucfirst($rw["fname"]) . " " . ucfirst($rw["lname"]);
                                    ?>
                                    <option value="<?php echo $r['user_id']; ?>"><?php echo $name; ?></option>
                                    <?php
                                }
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
        $('#projectAnalyzers').DataTable();
    });
</script>
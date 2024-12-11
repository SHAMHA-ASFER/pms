<?php
$pro_id = isset($_GET['id']) ? $_GET['id'] : 0;
?>
<div class="container">
    <div class="m-5">
        <table class="table table-striped" id="documentTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Updated-By</th>
                    <th>Last-Modified</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $docs = $this->documentModel->getAllDocuments($pro_id);
                $i = 1;
                while ($doc = $docs->fetch_assoc()) {
                ?>
                <tr>
                    <td style="background-color:<?php 
                    if ($doc['status'] == 'pending') {
                        echo 'rgba(247, 254, 144, 0.5)';
                    } else if ($doc['status'] == 'accepted') {
                        echo 'rgba(128, 255, 109, 0.5)';
                    } else if ($doc['status'] == 'denied') {
                        echo 'rgba(255, 145, 145, 0.5)';
                    }?>;"><?php echo $i; ?></td>
                    <td style="background-color:<?php 
                    if ($doc['status'] == 'pending') {
                        echo 'rgba(247, 254, 144, 0.5)';
                    } else if ($doc['status'] == 'accepted') {
                        echo 'rgba(128, 255, 109, 0.5)';
                    } else if ($doc['status'] == 'denied') {
                        echo 'rgba(255, 145, 145, 0.5)';
                    }?>;"><?php echo $doc['name']; ?></td>
                    <td style="background-color:<?php 
                    if ($doc['status'] == 'pending') {
                        echo 'rgba(247, 254, 144, 0.5)';
                    } else if ($doc['status'] == 'accepted') {
                        echo 'rgba(128, 255, 109, 0.5)';
                    } else if ($doc['status'] == 'denied') {
                        echo 'rgba(255, 145, 145, 0.5)';
                    }?>;">
                        <?php
                        $users = $this->userModel->getName($doc['updated_by']);
                        while ($user = $users->fetch_assoc()) {
                            echo ucfirst($user['fname']) . " " . ucfirst($user['lname']);
                        }
                        ?>
                    </td>
                    <td style="background-color:<?php 
                    if ($doc['status'] == 'pending') {
                        echo 'rgba(247, 254, 144, 0.5)';
                    } else if ($doc['status'] == 'accepted') {
                        echo 'rgba(128, 255, 109, 0.5)';
                    } else if ($doc['status'] == 'denied') {
                        echo 'rgba(255, 145, 145, 0.5)';
                    }?>;"><?php echo $doc['last_modified']; ?></php></td>
                    <td style="background-color:<?php 
                    if ($doc['status'] == 'pending') {
                        echo 'rgba(247, 254, 144, 0.5)';
                    } else if ($doc['status'] == 'accepted') {
                        echo 'rgba(128, 255, 109, 0.5)';
                    } else if ($doc['status'] == 'denied') {
                        echo 'rgba(255, 145, 145, 0.5)';
                    }?>;">
                        <form action="/document/status" method="post">
                            <input type="hidden" name="id" value="<?php echo $pro_id; ?>">
                            <input type="hidden" name="doc" value="<?php echo $doc["id"]; ?>">
                            <select name="status" class="form-select" onchange="form.submit()">
                            <?php
                            $status = $this->documentModel->getStatus();
                            while ($st = $status->fetch_assoc()) {
                                $matcher = "/'([^']+)'/";
                                preg_match_all( $matcher, $st["COLUMN_TYPE"], $matches);
                                for ($i = 0; $i < count($matches[1]); $i++) {
                                    if ($matches[1][$i] === $doc['status']) {
                            ?>
                            <option value="<?php echo $matches[1][$i]; ?>" selected><?php echo $matches[1][$i]; ?></option>
                            <?php
                                    } else {
                            ?>
                            <option value="<?php echo $matches[1][$i]; ?>"><?php echo $matches[1][$i]; ?></option>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </select>
                        </form>
                    </td>
                    <td style="background-color:<?php 
                    if ($doc['status'] == 'pending') {
                        echo 'rgba(247, 254, 144, 0.5)';
                    } else if ($doc['status'] == 'accepted') {
                        echo 'rgba(128, 255, 109, 0.5)';
                    } else if ($doc['status'] == 'denied') {
                        echo 'rgba(255, 145, 145, 0.5)';
                    }?>;">
                        <form>
                            <a href="/assets/projects/<?php echo $doc['location']; ?>" download="<?php echo explode("/",$doc['location'])[2]; ?>" class="btn btn-primary"><i class="fa fa-download"></i>&nbsp;Download</a>
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
        $('#documentTable').DataTable();
    });
</script>
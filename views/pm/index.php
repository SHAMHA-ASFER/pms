<div class="container mt-5 mb-5">
    <div class="row gx-5" style="max-width: 95%; margin: auto;">
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
</div>
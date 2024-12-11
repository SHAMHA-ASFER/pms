<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-2 bg-light">
            <h4 class="py-3">QA Panel</h4>
            <ul class="list-unstyled">
                <li><a href="#" class="text-decoration-none d-block py-2">Project A</a></li>
                <li><a href="#" class="text-decoration-none d-block py-2">Project B</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-10">
            <div class="py-3">
                <h3>Validate Source Files - Project A</h3>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mb-4" id="QATable">
                    <thead>
                        <tr>
                            <th>File Name</th>
                            <th>Developer</th>
                            <th>Last Updated</th>
                            <th>Task State</th>
                            <th>Comments</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="qaTasksTable">
                        <tr>
                            <td>login.js</td>
                            <td>John Doe</td>
                            <td>Dec 01, 2024</td>
                            <td>
                                <select class="form-select" onchange="updateTaskState(this)">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="complete">Complete</option>
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control" rows="1" placeholder="Add comments..."></textarea>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="approveTask(this)">Approve</button>
                                <button class="btn btn-danger btn-sm" onclick="rejectTask(this)">Reject</button>
                            </td>
                        </tr>
                        <tr>
                            <td>dashboard.css</td>
                            <td>Jane Smith</td>
                            <td>Nov 29, 2024</td>
                            <td>
                                <select class="form-select" onchange="updateTaskState(this)">
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="complete">Complete</option>
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control" rows="1" placeholder="Add comments..."></textarea>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="approveTask(this)">Approve</button>
                                <button class="btn btn-danger btn-sm" onclick="rejectTask(this)">Reject</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4 mb-4">
                <button class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#QATable').DataTable();
    });
</script>

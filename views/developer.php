<div class="container-fluid mt-5" data-page="file-explorer">
    <div class="row pt-5">
        <!-- Sidebar -->
        <div class="col-md-2 bg-light vh-100 overflow-auto p-3">
            <h4>File Explorer</h4>
            <ul id="fileExplorer" class="list-unstyled">
                <li>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-sm btn-link toggle-btn" onclick="toggleCollapse(this)">
                            <i class="fa fa-chevron-right"></i>
                        </button>
                        <img src="https://via.placeholder.com/20" alt="folder" class="me-2">
                        <span>Project A</span>
                        <div class="ms-auto">
                            <button class="btn btn-link btn-sm" onclick="addFile(this)"><i
                                    class="fa fa-file"></i></button>
                            <button class="btn btn-link btn-sm" onclick="addFolder(this)"><i
                                    class="fa fa-folder"></i></button>
                        </div>
                    </div>
                    <ul class="list-unstyled ps-3 d-none"></ul>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 mx-4 mt-4">
            <h5>Assigned Projects</h5>
            <div class="row g-3 mt-4">
                <div class="col-md-2 border text-center p-3">
                    <i class="fa fa-folder fa-3x"></i>
                    <p>Project A</p>
                </div>
                <div class="col-md-2 border text-center p-3">
                    <i class="fa fa-folder fa-3x"></i>
                    <p>Project B</p>
                </div>
            </div>

            <h5 class="mt-4 mb-4">Tasks</h5>
            <table class="table table-hover" id="devTable">
                <thead>
                    <tr>
                        <th>Project Title</th>
                        <th>Task</th>
                        <th>Last Modified</th>
                        <th>Project Manager</th>
                        <th>Deadline</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Project A</td>
                        <td>Implement Login</td>
                        <td>Dec 01, 2024</td>
                        <td>Jane Doe</td>
                        <td>Dec 10, 2024</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Upload Source</a></li>
                                    <li><a class="dropdown-item" href="#">View Task</a></li>
                                    <li><a class="dropdown-item" href="#">Clone</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Project B</td>
                        <td>Create Dashboard</td>
                        <td>Nov 29, 2024</td>
                        <td>John Smith</td>
                        <td>Dec 15, 2024</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown">
                                    Actions
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Add Source File</a></li>
                                    <li><a class="dropdown-item" href="#">Update Task</a></li>
                                    <li><a class="dropdown-item" href="#">View Details</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#devTable').DataTable();
    });
</script>
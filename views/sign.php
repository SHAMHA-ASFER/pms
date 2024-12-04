<div class="d-flex justify-content-center align-items-center bg-secondary text-white vh-100">
    <div class="container bg-dark rounded shadow d-flex flex-column flex-md-row overflow-hidden"
        style="max-width: 900px;">
        <!-- Left Side Image -->
        <div class="d-none d-md-block w-50"
            style="background: url('https://images.unsplash.com/photo-1584697964123-6136df241121?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center / cover; min-width: 300px;">
        </div>
        <!-- Form Section -->
        <div class="p-4 w-100">
            <h2 class="text-center mb-4">Create an Account</h2>
            <form action="/signup" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username"
                            required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact"
                            required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">

                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="dob" name="dob" placeholder="YYYY-MM-DD"
                                required>
                            <label for="dob">Date of Birth</label>
                        </div>

                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" class="form-control" id="nic" name="nic" placeholder="NIC" required>
                    </div>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" id="address" name="address" rows="2"
                        placeholder="Address"></textarea>
                </div>
                <div class="mb-3">
                    <select class="form-select" id="role" name="role" required>
                        <option value="" disabled selected>Select Role</option>
                        <option value="PM">Project Manager</option>
                        <option value="QA">QA</option>
                        <option value="DEV">Developer</option>
                        <option value="AN">Analyzer</option>
                        <option value="RQ">Requester</option>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="form-floating mb-3">
                        <input type="file" class="form-control" id="profile" name="image" required>
                        <label for="profile">Add profile</label>
                    </div>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label" for="terms">I agree to the terms & conditions</label>
                </div>
                <button type="submit" class="btn btn-primary w-100">Create Account</button>
            </form>
        </div>
    </div>
</div>
<div class="container mt-5">
        <div class="row">
            <div class="col-md-3 profile-sidebar">
                <img class="profile-img" src="https://via.placeholder.com/100" alt="Profile Picture">
                <h5>Nama User</h5>
                <p>Student</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
                <hr>
                <div class="courses">
                    <p><strong>0</strong> <br> Upcoming Courses</p>
                    <p class="completed" ><strong>0</strong> <br> Completed Courses</p>
                </div>
                <hr>
                <div class="d-flex">
                    <img class="social-media-img" src="<?= base_url('assets/images/github.png'); ?>" alt="github logo">
                    <a href="#">GitHub</a>
                </div>

                <div class="d-flex">
                    <img class="social-media-img" src="<?= base_url('assets/images/instagram.png'); ?>" alt="github logo">
                    <a href="#">Instagram</a>
                </div>

                <div class="d-flex">
                    <img class="social-media-img" src="<?= base_url('assets/images/x.png'); ?>" alt="github logo">
                    <a href="#">X</a>
                </div>
            </div>
            <div class="col-md-9">
                <ul class="nav nav-tabs" id="profileTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="achievements-tab" data-toggle="tab" href="#achievements" role="tab" aria-controls="achievements" aria-selected="false">Achievements</a>
                    </li>
                </ul>
                <div class="tab-content" id="profileTabsContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <h4>About Me</h4>
                        <p>Hello, I'm a new user</p>
                    </div>
                    <div class="tab-pane fade" id="achievements" role="tabpanel" aria-labelledby="achievements-tab">
                        <h4>My Achievements</h4>
                        <br>
                        <h5>Certificates</h5>
                        <p>Earn a class certificate by completing a course.</p>
                        <div class="certification-section text-center">
                            <p>You haven’t earned a certificate yet. <br> Complete a course and submit to get your first class certificate.</p>
                            <button class="btn btn-primary btn-sm">Find a Course</button>
                        </div>

                        <h5 class="badges">Badges</h5>
                        <p>Get rewarded for your learning progress with one of-a-kind badges. Check out the badges you earned and learn about the next badges you could earn here</p>
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <img src="https://via.placeholder.com/50" alt="Badge 1">
                                <p class="mt-1">Start a Class</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <img src="https://via.placeholder.com/50" alt="Badge 2">
                                <p class="mt-1">Complete 3 Class</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <img src="https://via.placeholder.com/50" alt="Badge 3">
                                <p class="mt-1">Complete 5 Classes</p>
                            </div>
                            <div class="col-md-3 text-center">
                                <img src="https://via.placeholder.com/50" alt="Badge 4">
                                <p class="mt-1">Complete 10 Classes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <!-- Photo Upload -->
                        <div class="mb-3 text-center">
                            <label for="profilePhoto" class="form-label">Photo Profile</label>
                            <div class="mb-3">
                                <img id="currentPhoto" src="https://via.placeholder.com/100" alt="Current Profile" class="rounded-circle mb-3">
                                <input type="file" class="form-control" id="profilePhoto" accept="image/*">
                            </div>
                        </div>

                        <!-- Name Input -->
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required>
                        </div>

                        <!-- Email Input -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>

                        <!-- Phone Input -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                        </div>

                        <!-- GitHub Link Input -->
                        <div class="mb-3">
                            <label for="githubLink" class="form-label">GitHub</label>
                            <input type="url" class="form-control" id="githubLink" placeholder="Enter your GitHub profile">
                        </div>

                        <!-- Instagram Link Input -->
                        <div class="mb-3">
                            <label for="instagramLink" class="form-label">Instagram</label>
                            <input type="url" class="form-control" id="instagramLink" placeholder="Enter your Instagram profile">
                        </div>

                        <!-- Platform X Link Input -->
                        <div class="mb-3">
                            <label for="XLink" class="form-label">X</label>
                            <input type="url" class="form-control" id="XLink" placeholder="Enter your X profile">
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- menambahkan baground fill ke section class hero-section -->

<section class="background-fill">
    <div class="container pb-4">
        <header class="py-4">
            <nav
                class="navbar navbar-expand-lg bg-white mx-auto shadow-sm border <?= (!$this->session->userdata('userEmail')) ? 'login ' : '';?>">
                <div class="container-fluid px-5">
                    <div class="navbar-brand">
                        <img src="<?= base_url('assets/images/logo_with_text.png') ?>" alt="Logo" width="180px" />
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto d-flex grid gap-5">
                            <li class="nav-item">
                                <a class="nav-link <?= $title == 'Home' ? 'active' : ''; ?>"
                                    href="<?= base_url('home') ?>">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link <?= $title == 'Course' ? 'active' : ''; ?>"
                                    href="<?= base_url('course') ?>">
                                    Course
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('home#contact') ?>">Contact</a>
                            </li>
                        </ul>
                        <?php if (!$this->session->userdata('userEmail')): ?>
                        <div class="navbar-nav-extra d-flex gap-4">
                            <a class="btn btn-outline-primary" href="<?= base_url('login') ?>">Sign in</a>
                            <a class="btn btn-primary" href="<?= base_url('register') ?>">Sign Up</a>
                        </div>
                        <?php endif; ?>

                        <?php if ($this->session->userdata('userEmail')): ?>
                        <div class="login d-flex gap-4">
                            <a class="btn btn-outline-primary" href="<?= base_url('logout') ?>">Log Out</a>
                            <a class="btn btn-primary" href="<?= base_url('profile') ?>">Profile</a>

                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </header>
        <div class="row hero-section gy-3 my-3">
            <div class="col-12 col-lg-6">
                <img class="course-img img-fluid" src="<?= base_url('assets/images/course.jpeg'); ?>"
                    alt="Course Banner">
            </div>
            <div class="col-12 col-lg-6 d-flex flex-column justify-content-between py-0 py-lg-2">
                <div>
                    <h2><?= htmlspecialchars($course->courseName, ENT_QUOTES, 'UTF-8') ?></h2>
                    <p><?= htmlspecialchars($course->courseDescription, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <?php if (!empty($course->courseTags)): ?>
                <div class="d-flex gap-3">
                    <?php 
                        $tags = explode(',', $course->courseTags);
                        foreach($tags as $tag):
                    ?>
                    <span class="badge"><?= strtoupper(trim(htmlspecialchars($tag, ENT_QUOTES, 'UTF-8'))) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="course-section container mt-5 mb-5 p-4 rounded shadow-lg">
    <div class="row mt-3">
        <div class="col-md-8">
            <h3>Course Modules</h3>
            <div class="accordion accordion-flush d-flex flex-column gap-4" id="accordionFlushExample">
                <?php

// var_dump($course->moduleIDs);
// var_dump($course->moduleNames);
// var_dump($course->moduleDescriptions);

                    $moduleIDs = !empty($course->moduleIDs) ? explode('|', $course->moduleIDs) : [];
                    $moduleNames = !empty($course->moduleNames) ? explode('|', $course->moduleNames) : [];
                    $moduleDescriptions = !empty($course->moduleDescriptions) ? explode('|', $course->moduleDescriptions) : [];
                    

                    for ($i = 0; $i < count($moduleIDs); $i++):
                        $moduleID = $moduleIDs[$i];
                        $moduleName = $moduleNames[$i];
                        $moduleDescription = $moduleDescriptions[$i];
                    ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse<?= $moduleID ?>" aria-expanded="false" aria-controls="flush-collapse<?= $moduleID ?>">
                            <?= htmlspecialchars($moduleName, ENT_QUOTES, 'UTF-8') ?>
                        </button>
                    </h2>
                    <div id="flush-collapse<?= $moduleID ?>" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body"><?= htmlspecialchars($moduleDescription, ENT_QUOTES, 'UTF-8') ?></div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
        <div class="col-md-4 text-center">
    <div class="subs-box p-3 border rounded">
        <h4 class="fw-bold">You're One Step Away!</h4>
        <p>4 Module, 3 Hours 33 Minutes</p>
        <p class="fw-bold">Rp. <?= number_format($course->coursePrice, 0, ',', '.') ?></p>
        <!-- <button class="get-started btn">Get Started!</button> -->
        <a href="<?= base_url('learning?courseID='.$courseID.'&materialID='.$materialID) ?>" class="btn btn-primary get-started">Get Started!</a>
    </div>
</div>
        </div>
        </div>
    </div>
</section>
<!-- menambahkan baground fill ke section class hero-section -->
 
<section class="background-fill">
    <div class="container pb-4">
        <header class="py-4">
            <nav class="navbar navbar-expand-lg bg-white mx-auto shadow-sm border">
                <div class="container-fluid px-5">
                    <div class="navbar-brand">
                        <img src="<?= base_url('assets/images/logo_with_text.png') ?>" alt="Logo" width="180px" />
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto d-flex grid gap-5">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="<?= base_url('Home') ?>">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Kelas
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('Course') ?>">TI</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('Course') ?>">Management</a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url('Course') ?>">Kelas
                                            lainnya</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Learning</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('Home') ?>">Kontak</a>
                            </li>
                        </ul>
                        <div class="navbar-nav-extra d-flex gap-4">
                            <a class="btn btn-outline-primary" href="<?= base_url('Login') ?>">Sign in</a>
                            <a class="btn btn-primary" href="<?= base_url('Register') ?>">Sign Up</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <form class="d-flex me-3">
            <div class="input-group">
                <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                <button class="btn" type="button">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
        <div class="hero-section my-3 row align-items-center">
            <div class="col-md-6 order-md-1 order-2">
                <img class="course-img img-fluid" src="<?= base_url('assets/images/course.jpeg'); ?>"
                    alt="Course Banner">
            </div>
            <div class="col-md-6 order-md-2 order-1">
                <h2><?= $course->courseName ?></h2>
                <p><?= $course->courseDescription ?></p>
                <?php if ($course->courseTags): ?>
                <div class="d-flex gap-3">
                    <?php 
                        $tags = explode(',', $course->courseTags);
                        foreach($tags as $tag):
                    ?>
                    <span class="badge"><?= strtoupper(trim($tag)) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="course-section container mt-5 mb-5 p-4 rounded shadow">
    <div class="row mt-3">
        <div class="col-md-8">
            <h3>Pelajari Kelas Ini</h3>
            <ul class="list-group">
                
                <li class="list-group-item custom-list-item d-flex align-items-center" onclick="window.location.href=''">
                    <i class="bi bi-play-circle-fill me-3"></i>
                    <span>1. Pengenalan Figma dan Dasar-dasar Desain UI/UX</span>
                </li>
                <li class="list-group-item custom-list-item d-flex align-items-center">
                    <i class="bi bi-play-circle-fill me-3"></i>
                    <span>2. Pengenalan Figma dan Dasar-dasar Desain UI/UX</span>
                </li>
            </ul>
        </div>
        <div class="col-md-4 text-center">
            <div class="subs-box p-3 border rounded">
                <h4 class="fw-bold">You're One Step Away!</h4>
                <p>4 Module, 3 Hours 33 Minutes</p>
                <p class="fw-bold">Rp. <?= number_format($course->coursePrice, 0, ',', '.') ?></p>
                <button class="get-started btn">Get Started!</button>
            </div>
        </div>
    </div>
</section>
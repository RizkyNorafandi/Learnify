<!-- <nav class="navbar navbar-expand-lg sticky-top shadow "> -->
<section class="navigation">
    <header class="background-fill py-4">
        <!-- <nav class="navbar navbar-expand-lg bg-white mx-auto shadow-sm border"> -->
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
    <!-- Navbar End -->
</section>
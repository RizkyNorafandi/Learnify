<!-- <nav class="navbar navbar-expand-lg sticky-top shadow "> -->
<section class="navigation">
    <header class="background-fill py-4">
        <!-- <nav class="navbar navbar-expand-lg bg-white mx-auto shadow-sm border"> -->
        <nav class="navbar navbar-expand-lg bg-white mx-auto shadow-sm border <?= ($this->session->userdata('userEmail') != false) ? 'login ' : '' . $hidden;?>">
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
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Kelas
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?= base_url('Course') ?>">TI</a>
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url('Course') ?>">Management</a></li>
                                <li>
                                    <hr class=" dropdown-divider" />
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= base_url('Course') ?>">Kelas lainnya</a>
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
                    <?php if ($this->session->userdata('userEmail') == false): ?>
                    <div class="navbar-nav-extra d-flex gap-4">
                        <a class="btn btn-outline-primary" href="<?= base_url('Auth') ?>">Sign in</a>
                        <a class="btn btn-primary" href="<?= base_url('Auth') ?>">Sign Up</a>
                    </div>
                    <?php endif; ?>

                    <?php if ($this->session->userdata('userEmail') != false): ?>
                    <div class="login d-flex gap-4">
                    <a class="btn btn-outline-primary" href="<?= base_url('Auth') ?>">Log Out</a>
                    <a class="btn btn-primary" href="<?= base_url('Profile') ?>">Profile</a>

                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>
    <!-- Navbar End -->
</section>
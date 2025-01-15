<section class="navigation">
    <header class="background-fill py-4">
        <nav class="navbar navbar-expand-lg bg-white mx-auto shadow-sm border">
            <div class="container-fluid px-5">
                <div class="navbar-brand">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" width="180px" />
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
                            <a class="nav-link" href="#">Tentang Kami</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('Home') ?>">Kontak</a>
                        </li>
                    </ul>
                    <div class="navbar-nav-extra d-flex gap-4">
                        <a class="btn btn-outline-primary" href="<?= base_url('Login') ?>">Sign in</a>
                        <a class="btn btn-primary" href="#">Sign Up</a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Navbar End -->
</section>
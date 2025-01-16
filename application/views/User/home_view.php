<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learnify - Online Course</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') . '?v=' . time(); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap">
</head>

<body>
    <!-- Navbar Start -->
    <!-- Class background-fill untuk menambahkan gambar bg ke section atau header  -->
    <section class="" style="height: 600px;">
        <header class="background-fill py-4">
            <nav class="navbar navbar-expand-lg bg-white mx-auto shadow-sm border">
                <div class="container-fluid px-5">
                    <div class="navbar-brand">
                        <img src="<?= base_url('assets/images/') ?> logo.png" alt="Logo" width="180px" />
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul
                            class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto d-flex grid gap-5">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a
                                    class="nav-link dropdown-toggle"
                                    href="#"
                                    role="button"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    Kelas
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">TI</a></li>
                                    <li><a class="dropdown-item" href="#">Management</a></li>
                                    <li>
                                        <hr class="dropdown-divider" />
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Kelas lainnya</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Panduan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Kontak</a>
                            </li>
                        </ul>
                        <div class="navbar-nav-extra d-flex gap-4">
                            <a class="btn btn-outline-primary" href="#">Sign in</a>
                            <a class="btn btn-primary" href="#">Sign Up</a>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <!-- Navbar End -->
    </section>

    <section class="bg-white" style="height: 500px;">
        <section class="hero-section container mt-4 p-4 rounded">
            <div class="row align-items-center">
                <form class="d-flex me-3">
                    <div class="input-group">
                        <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                        <button class="btn btn-primary" type="button">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <div class="col-md-6 order-md-1 order-2">
                    <img class="course-img img-fluid" src="<?= base_url('assets/image/course.jpeg'); ?>" alt="Course Banner">
                </div>
                <div class="col-md-6 order-md-2 order-1">
                    <h2>Mastering Figma, Desain UI/UX Profesional dan Efisien</h2>
                    <p>Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet Lorem ipsum dolor sit amet</p>
                    <div class="d-flex gap-3">
                        <span class="badge">FIGMA</span>
                        <span class="badge">DESIGN</span>
                        <span class="badge">UI/UX</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="course-section container p-4 rounded shadow">
            <div class="row mt-3">
                <div class="col-md-8">
                    <h3>Pelajari Kelas Ini</h3>
                    <ul class="list-group">
                        <li class="list-group-item custom-list-item d-flex align-items-center">
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
                        <p class="fw-bold">Rp. 999.999,00</p>
                        <button class="get-started btn">Get Started!</button>
                    </div>
                </div>
            </div>
        </section>
    </section>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>
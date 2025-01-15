<!-- Filter Section -->
<div class="container py-5">
    <div class="filters">
        <button class="filter-btn">Semua</button>
        <button class="filter-btn">New</button>
        <button class="filter-btn">Popular</button>
        <div class="search-box ">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="Search..." />
        </div>
    </div>

    <!-- Course Cards Section -->
    <div class="course-grid">
        <!-- Course Card 1 -->
        <a href="<?= base_url('Course_Detail') ?>" class="course-card">
            <div class="badge-container">
                <div class="badge">New</div>
                <div class="badge secondary-badge">Popular</div>
            </div>
            <img src="<?= base_url('assets/images/figma.png'); ?>" alt="Materi Pembelajaran" class="card-image-metod">
            <div class="course-info">
                <h3>Beginner Figma Video Course</h3>
                <p>Mastering Figma, Desain UI/UX Profesional dan Efisien</p>
            </div>
        </a>

        <!-- Course Card 2 -->
        <a href="<?= base_url('Course_Detail') ?>" class="course-card">
            <div class="badge-container">
                <div class="badge">Popular</div>
            </div>
            <img src="<?= base_url('assets/images/adobetutorial.png'); ?>" alt="Materi Pembelajaran"
                class="card-image-metod">
            <div class="course-info">
                <h3>Adobe Photoshop Tutorials for Beginners</h3>
                <p>Adobe Photoshop Tutorials for Beginners</p>
            </div>
        </a>

        <!-- Course Card 3 -->
        <a href="<?= base_url('Course_Detail') ?>" class="course-card">
            <div class="badge-container">
                <div class="badge">New</div>
            </div>
            <img src="<?= base_url('assets/images/premierpro.jpg'); ?>" alt="Materi Pembelajaran"
                class="card-image-metod">
            <div class="course-info">
                <h3>Certificate Course on Adobe Premiere Pro CC</h3>
                <p>Certificate Course on Adobe Premiere Pro CC</p>
            </div>
        </a>
        <!-- Course Card 4 -->
        <a href="<?= base_url('Course_Detail') ?>" class="course-card">
            <div class="badge-container">
                <div class="badge">New</div>
                <div class="badge secondary-badge">Popular</div>
            </div>
            <img src="<?= base_url('assets/images/figma.png'); ?>" alt="Materi Pembelajaran" class="card-image-metod">
            <div class="course-info">
                <h3>Beginner Figma Video Course</h3>
                <p>Mastering Figma, Desain UI/UX Profesional dan Efisien</p>
            </div>
        </a>

        <!-- Course Card 5 -->
        <a href="<?= base_url('Course_Detail') ?>" class="course-card">
            <div class="badge-container">
                <div class="badge">Popular</div>
            </div>
            <img src="<?= base_url('assets/images/adobetutorial.png'); ?>" alt="Materi Pembelajaran"
                class="card-image-metod">
            <div class="course-info">
                <h3>Adobe Photoshop Tutorials for Beginners</h3>
                <p>Adobe Photoshop Tutorials for Beginners</p>
            </div>
        </a>

        <!-- Course Card 6 -->
        <a href="<?= base_url('Course_Detail') ?>" class="course-card">
            <div class="badge-container">
                <div class="badge">New</div>
            </div>
            <img src="<?= base_url('assets/images/premierpro.jpg'); ?>" alt="Materi Pembelajaran"
                class="card-image-metod">
            <div class="course-info">
                <h3>Certificate Course on Adobe Premiere Pro CC</h3>
                <p>Certificate Course on Adobe Premiere Pro CC</p>
            </div>
        </a>
    </div>
</div>
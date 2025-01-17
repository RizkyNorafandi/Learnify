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
        <?php 
            if (!empty($courses)) {
                foreach($courses as $index => $course): 
        ?>
            <a href="<?= base_url('course/details?id=' . $course->courseID) ?>" class="course-card">
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
        <?php 
                endforeach;
            }
        ?>
    </div>
</div>
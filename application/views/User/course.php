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
            <?php if ($course->courseTags): ?>
                <div class="badge-container">
                    <?php 
                        $categorys = explode(',', $course->courseCategory);
                        foreach($categorys as $category):
                    ?>
                    <div class="badge"><?= strtoupper(trim($category)) ?></div>
                    <div class="badge secondary-badge">Popular</div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <img src="<?= base_url('assets/images/figma.png'); ?>" alt="Materi Pembelajaran" class="card-image-metod">
                <div class="course-info">
                    <h3><?= $course->courseName ?></h3>
                    <p><?= $course->courseDescription ?></p>
                </div>
            </a>
        <?php 
                endforeach;
            }
        ?>
    </div>
</div>
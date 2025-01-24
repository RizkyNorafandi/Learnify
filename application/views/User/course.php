<!-- Filter Section -->
<div class="container-xxl py-5">

    <!-- Course Cards Section -->
    <div class="row g-5">
        <?php
        if (!empty($courses)) {
            foreach ($courses as $index => $course):
        ?>
                <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                    <a href="<?= base_url('course/details?id=' . $course->courseID) ?>" class="course-card">
                        <?php if ($course->courseTags): ?>
                            <div class="badge-container">
                                <?php
                                $tags = explode(',', $course->courseTags);
                                foreach ($tags as $tag):
                                ?>
                                    <div class="badge"><?= strtoupper(trim($tag)) ?></div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <img src="<?= base_url('assets/images/' . $course->courseThumbnail); ?>" alt="<?= $course->courseName ?>"
                            class="card-image-metod">
                        <div class="course-info">
                            <h3><?= $course->courseName ?></h3>
                            <p><?= $course->courseDescription ?></p>
                        </div>
                    </a>
                </div>
        <?php
            endforeach;
        }
        ?>
    </div>
</div>
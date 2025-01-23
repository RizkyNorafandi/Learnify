<!-- Header Section -->
<section class="header-section">
    <div class="image-section">
        <img src="<?= base_url('assets/images/header.png'); ?>" alt="Course Image" />
    </div>
</section>

<!-- Course Preview Start -->
<section class="course-prev">
    <div class="container-prev">
        <h2 class="section-title">TERBARU</h2>
        <div class="course-container">
            <div class="course-card-prev">
                <img class="course-card-img" src="<?= base_url('assets/images/figma.png'); ?>"
                    alt="Beginner Figma Video Course">
            </div>
            <div class="course-card-prev">
                <img class="course-card-img" src="<?= base_url('assets/images/adobetutorial.png'); ?>"
                    alt="Adobe Photoshop Tutorials">
            </div>
        </div>
        <div class="dots">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
    </div>
</section>
<!-- Course Preview End -->

<!-- Learning Method -->
<section class="learning-method">
    <div class="container-metod">
        <h2 class="section-title-metod">METODE PEMBELAJARAN</h2>
        <p class="section-description-metod">Lorem ipsum dolor sit amet, bahasa alien.</p>
        <div class="card-container-metod">
            <!-- Card 1 -->
            <div class="card-metod">
                <img src="<?= base_url('assets/images/vidpem.jpg'); ?>" alt="Video Pembelajaran"
                    class="card-image-metod">
                <h3 class="card-title-metod">Video Pembelajaran</h3>
                <ul class="card-list-metod">
                    <li><i class="fas fa-check-circle"></i> Lorem ipsum dolor sit amet, bahasa alien.</li>
                    <li><i class="fas fa-check-circle"></i> Lorem ipsum dolor sit amet, bahasa alien.</li>
                </ul>
            </div>
            <!-- Card 2 -->
            <div class="card-metod">
                <img src="<?= base_url('assets/images/matpem2.jpg'); ?>" alt="Materi Pembelajaran"
                    class="card-image-metod">
                <h3 class="card-title-metod">Materi Pembelajaran</h3>
                <ul class="card-list-metod">
                    <li><i class="fas fa-check-circle"></i> Lorem ipsum dolor sit amet, bahasa alien.</li>
                    <li><i class="fas fa-check-circle"></i> Lorem ipsum dolor sit amet, bahasa alien.</li>
                </ul>
            </div>
            <!-- Card 3 -->
            <div class="card-metod">
                <img src="<?= base_url('assets/images/matpem.jpg'); ?>" alt="Latihan Soal" class="card-image-metod">
                <h3 class="card-title-metod">Latihan Soal</h3>
                <ul class="card-list-metod">
                    <li><i class="fas fa-check-circle"></i> Lorem ipsum dolor sit amet, bahasa alien.</li>
                    <li><i class="fas fa-check-circle"></i> Lorem ipsum dolor sit amet, bahasa alien.</li>
                </ul>
            </div>
        </div>
        <button class="button-metod" onclick="window.location.href='<?= base_url('Course') ?>'">Belajar
            Sekarang</button>
        <!-- <button class="button-metod" href="<?= base_url('Course')?>">Belajar Sekarang</button> -->
    </div>
</section>
<!-- Learning Method End -->

<!-- FAQ -->
<section class="faq-section">
    <h2 class="faq-title">SERING DI TANYAKAN</h2>
    <div class="faq-container">
        <div class="faq-item">
            <button class="faq-question">
                Apa yang dimaksud course ?
                <span class="faq-icon">▼</span>
            </button>
            <div class="faq-answer">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
                consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
                consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">
                Apa yang dimaksud course ?
                <span class="faq-icon">▼</span>
            </button>
            <div class="faq-answer">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
                consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
                consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
            </div>
        </div>
        <div class="faq-item">
            <button class="faq-question">
                Apa yang dimaksud course ?
                <span class="faq-icon">▼</span>
            </button>
            <div class="faq-answer">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
                consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
                consectetur adipiscing elit. Aliquam sollicitudin tempor lectus.
            </div>
        </div>
        <script>
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');

            question.addEventListener('click', () => {
                item.classList.toggle('active');
            });
        });
        </script>
    </div>
</section>
<!-- FAQ End-->

<!-- Kontak -->
<section class="contact-section" id="contact">
    <div class="contact-container">
        <div class="contact-form">
            <h2 class="contact-title">KONTAK KAMI</h2>
            <p class="contact-description">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
            </p>
            <form action="<?= base_url('user/Home/sendEmail') ?>" method="POST">
                <div class="input-group-contact">
                    <input type="text" name="name" placeholder="Your name" required />
                </div>
                <div class="input-group-contact">
                    <input type="email" name="email" placeholder="Your email" required />
                </div>
                <div class="input-group-contact">
                    <textarea name="message" placeholder="Message..." required></textarea>
                </div>
                <button type="submit" class="submit-button">Submit</button>
            </form>
        </div>
        <div class="contact-map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3944.906547891004!2d115.21545681478452!3d-8.65172689378992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd2413214adbb27%3A0x2d3b2c57de11254e!2sDenpasar!5e0!3m2!1sen!2sid!4v1616552594245!5m2!1sen!2sid"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
</section>
<!-- Kontak End -->
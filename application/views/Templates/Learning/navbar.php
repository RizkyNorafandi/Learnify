<!-- Navbar Section Start -->
<section class="navbar-learning w-100">
  <div class="container-fluid d-flex justify-content-between align-items-center">
    <div>
      <button class="btn-sidebar">
        <i class="fa-solid fa-angle-left"></i>
      </button>
      <a href="<?= base_url('course') ?>" class="btn btn-outline-secondary">Back To Course</a>
    </div>
    <button class="btn-marks-complete complete" onclick="markComplete()">Marks Complete</button>
    <div>
    <button class="btn btn-secondary" onclick="goToPrevious()">Previous</button>
    <button class="btn btn-secondary" onclick="goToNext()">Next</button>
    </div>
  </div>
</section>
<!-- Navbar Section End -->
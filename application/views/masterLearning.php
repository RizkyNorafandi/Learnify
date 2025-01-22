<!DOCTYPE html>
<html lang="en">
<head>
  <?php $this->load->view($head); ?>
</head>
<body class="d-flex">
  <?php $this->load->view($sidebar); ?>

  <main class="overflow-y-auto">
    <?php $this->load->view($navbar); ?>

    <!-- Content Section Start -->
    <section class="main-content">
      <div class="container-xxl">
        <?php $this->load->view($content); ?>
      </div>
    </section>
    <!-- Content Section End -->
  </main>

  <?php $this->load->view($script); ?>
</body>
</html>
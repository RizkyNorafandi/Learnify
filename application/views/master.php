<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view($header);
    ?>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Class khusus login dan register -->
    <div class="lg:flex <?php echo isset($is_login_page) && $is_login_page ? 'justify-center items-center min-h-screen' : ''; ?>">
        <?php if (!empty($navigation)) { ?>
            <?php $this->load->view($navigation); ?>
        <?php } ?>
        <?php $this->load->view($content); ?>
    </div>
    <?php if (!empty($footer)) {
        $this->load->view($footer);
    } ?>
    <?php $this->load->view($script); ?>
</body>

</html>
<div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <!-- Login container -->
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
        <!-- Form -->
        <div class="md:w-1/2 px-8 md:px-16">
            <h2 class="font-bold text-2xl text-[#002D74]">Login Admin</h2>

            <!-- Tampilkan pesan error -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="bg-red-200 text-red-800 p-2 rounded mb-4">
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>

            <!-- Tampilkan pesan sukses -->
            <?php if ($this->session->flashdata('success')): ?>
                <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php endif; ?>

            <form id="loginAdminForm" method="post" action="<?= base_url('dashboard/auth/login') ?>" class="flex flex-col gap-4">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <input class="p-2 mt-8 rounded-xl border" type="email" name="adminEmail" id="adminEmail" placeholder="Email" required>
                <input class="p-2 rounded-xl border w-full" type="password" name="adminPassword" id="adminPassword" placeholder="Password" required>
                <button type="submit" class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300">Login</button>
            </form>
        </div>

        <!-- Image -->
        <div class="md:block hidden w-1/2">
            <img class="rounded" src="<?php echo base_url('assets/images/gradient_bullet.png'); ?>" alt="Gradient Bullet">
        </div>
    </div>
</div>

<script>
    function displayMessage(type, message) {
        const successMessage = document.getElementById('success-message');
        const errorMessage = document.getElementById('error-message');

        if (type === 'success') {
            successMessage.innerText = message;
            successMessage.style.display = 'block';
            errorMessage.style.display = 'none';
        } else {
            errorMessage.innerText = message;
            errorMessage.style.display = 'block';
            successMessage.style.display = 'none';
        }
    }
</script>
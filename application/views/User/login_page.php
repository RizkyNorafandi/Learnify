<section class="bg-gray-50 min-h-screen flex items-center justify-center">
    <!-- Login container -->
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
        <!-- Form -->
        <div class="md:w-1/2 px-8 md:px-16">
            <h2 class="font-bold text-2xl text-[#002D74]">Login</h2>
            <p class="text-xs mt-4 text-[#002D74]">If you are already a member, easily log in</p>

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

            <form id="loginForm" method="post" action="<?php echo base_url('authLogin') ?>" class="flex flex-col gap-4">
                <input type="hidden" name="<?= $csrf_token_name; ?>" value="<?= $csrf_hash; ?>" />
                <input class="p-2 mt-8 rounded-xl border" type="email" id="userEmail" name="userEmail" placeholder="Email" required>
                <div class="relative">
                    <input class="p-2 rounded-xl border w-full" type="password" id="userPassword" name="userPassword" placeholder="Password" required>
                </div>
                <button type="submit" class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300">Login</button>
            </form>

            <div class="mt-3 text-xs flex justify-between items-center text-[#002D74]">
                <p>Don't have an account?</p>
                <a href="<?= base_url('register') ?>">Register</a>
            </div>
        </div>

        <!-- Image -->
        <div class="md:block hidden w-1/2">
            <img class="rounded" src="<?php echo base_url('assets/images/gradient_bullet.png'); ?>" alt="Gradient Bullet">
        </div>
    </div>
</section>
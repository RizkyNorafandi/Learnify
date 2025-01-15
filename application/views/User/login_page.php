<section class="bg-gray-50 min-h-screen flex items-center justify-center">
    <!-- Login container -->
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
        <!-- Form -->
        <div class="md:w-1/2 px-8 md:px-16">
            <h2 class="font-bold text-2xl text-[#002D74]">Login</h2>
            <p class="text-xs mt-4 text-[#002D74]">If you are already a member, easily log in</p>

            <!-- Tampilkan pesan error jika ada -->
            <div id="error-message" class="hidden bg-red-200 text-red-800 p-2 rounded mb-4"></div>

            <form id="loginForm" method="post" action="php" class="flex flex-col gap-4">
                <input class="p-2 mt-8 rounded-xl border" type="email" id="adminEmail" name="adminEmail" placeholder="Email" required>
                <div class="relative">
                    <input class="p-2 rounded-xl border w-full" type="password" id="adminPassword" name="adminPassword" placeholder="Password" required>
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
<section class="bg-gray-50 min-h-screen flex items-center justify-center">
    <!-- Register container -->
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
        <!-- Form -->
        <div class="md:w-1/2 px-8 md:px-16">
            <h2 class="font-bold text-2xl text-[#002D74]">Register</h2>
            <p class="text-xs mt-4 text-[#002D74]">Create your account and start learning with us!</p>

            <!-- Tampilkan pesan error jika ada -->
            <div id="error-message" class="hidden bg-red-200 text-red-800 p-2 rounded mb-4"></div>

            <form id="registerForm" method="post" action="php" class="flex flex-col gap-4">
                <input type="hidden" name="<?= $csrf_token_name; ?>" value="<?= $csrf_hash; ?>" />
                <input class="p-2 mt-4 rounded-xl border" type="text" id="userFullname" name="userFullname" placeholder="Full Name" required>
                <input class="p-2 rounded-xl border" type="email" id="userEmail" name="userEmail" placeholder="Email" required>
                <input class="p-2 rounded-xl border" type="tel" id="userPhone" name="userPhone" placeholder="Phone Number" required>
                <input class="p-2 rounded-xl border" type="password" id="userPassword" name="userPassword" placeholder="Password" required>
                <input class="p-2 rounded-xl border" type="password" id="reenterPassword" name="reenterPassword" placeholder="Re-enter Password" required>

                <button type="submit" class="bg-[#002D74] rounded-xl text-white py-2 hover:scale-105 duration-300">Register</button>
            </form>

            <div class="mt-3 text-xs flex justify-between items-center py-4 text-[#002D74]">
                <p>Already have an account? </p>
                <a href="<?= base_url('login') ?>">Login</a>
            </div>
        </div>

        <!-- Image -->
        <div class="md:block hidden w-1/2">
            <img class="rounded" src="<?php echo base_url('assets/images/gradient_bullet.png'); ?>" alt="Gradient Bullet">
        </div>
    </div>
</section>
<script>
    // Handle form submission
    document.getElementById('registerForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Collect form data
        const formData = {
            userFullname: document.getElementById('userFullname').value,
            userEmail: document.getElementById('userEmail').value,
            userPhone: document.getElementById('userPhone').value,
            userPassword: document.getElementById('userPassword').value,
            reenterPassword: document.getElementById('reenterPassword').value,
        };

        // Check if passwords match
        if (formData.userPassword !== formData.reenterPassword) {
            document.getElementById('error-message').classList.remove('hidden');
            document.getElementById('error-message').innerText = 'Passwords do not match';
            return;
        }

        try {
            // Send POST request to API
            const response = await fetch('http://localhost/learnify/registerAPI', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            const result = await response.json();

            if (response.ok) {
                alert('Registration successful');
                window.location.href = '/login'; // Redirect to login page
            } else {
                document.getElementById('error-message').classList.remove('hidden');
                document.getElementById('error-message').innerText = result.message || 'Failed to register';
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('error-message').classList.remove('hidden');
            document.getElementById('error-message').innerText = 'An error occurred. Please try again later.';
        }
    });
</script>
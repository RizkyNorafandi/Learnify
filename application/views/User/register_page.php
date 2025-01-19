<section class="bg-gray-50 min-h-screen flex items-center justify-center">
    <!-- Register container -->
    <div class="bg-gray-100 flex rounded-2xl shadow-lg max-w-3xl p-5 items-center">
        <!-- Form -->
        <div class="md:w-1/2 px-8 md:px-16">
            <h2 class="font-bold text-2xl text-[#002D74]">Register</h2>
            <p class="text-xs mt-4 text-[#002D74]">Create your account and start learning with us!</p>

            <!-- Tampilkan pesan error jika ada -->
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

            <form id="registerForm" method="post" action="" class="flex flex-col gap-4">
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
    document.getElementById('registerForm').addEventListener('submit', handleRegister);

    function handleRegister(event) {
        event.preventDefault();

        const userFullname = document.getElementById('userFullname').value;
        const userEmail = document.getElementById('userEmail').value;
        const userPhone = document.getElementById('userPhone').value;
        const userPassword = document.getElementById('userPassword').value;
        const reenterPassword = document.getElementById('reenterPassword').value;

        const csrfToken = document.querySelector('input[name="<?= $csrf_token_name; ?>"]').value;

        fetch('<?php echo base_url('api/auth/register'); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    '<?= $csrf_token_name; ?>': csrfToken
                },
                body: JSON.stringify({
                    userFullname,
                    userEmail,
                    userPhone,
                    userPassword,
                    reenterPassword
                })
            })

            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    displayMessage('success', data.message);
                } else {
                    displayMessage('error', data.message);
                }
            })
            .catch(error => {
                displayMessage('error', 'An error occurred. Please try again.');
            });

    }

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
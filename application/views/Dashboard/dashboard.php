<div class="flex-1 p-6">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h2>
        <!-- Stat Cards -->
        <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6 transform transition duration-200 hover:scale-105">
                <a href="<?= site_url('admin/course') ?>">
                    <svg class="w-12 h-12 text-blue-500 mb-4 mx-auto" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 12V4C20 2.89543 19.1046 2 18 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V18.5" />
                        <path d="M13 2V14L16.8182 11L20 14V5" />
                    </svg>
                    <h3 id="course-count" class="text-2xl font-semibold text-center text-gray-800">Loading...</h3>
                    <p class="text-gray-500 text-center">Courses</p>
                </a>

            </div>
            <div class="bg-white rounded-lg shadow p-6 transform transition duration-200 hover:scale-105">
                <a href="<?= site_url('admin/user') ?>">
                    <svg class="w-12 h-12 text-blue-500 mb-4 mx-auto" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"></path>
                    </svg>
                    <h3 id="user-count" class="text-2xl font-semibold text-center text-gray-800">Loading...</h3>
                    <p class="text-gray-500 text-center">Users</p>
                </a>
            </div>
            <div class="bg-white rounded-lg shadow p-6 transform transition duration-200 hover:scale-105">
                <a href="<?= site_url('admin/module') ?>">
                    <svg class="w-12 h-12 text-blue-500 mb-4 mx-auto bi bi-file-earmark" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" viewBox="0 0 16 16">
                        <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5z" />
                    </svg>
                    <h3 id="module-count" class="text-2xl font-semibold text-center text-gray-800">Loading...</h3>
                    <p class="text-gray-500 text-center">Module</p>
                </a>
            </div>
            <div class="bg-white rounded-lg shadow p-6 transform transition duration-200 hover:scale-105">
                <svg class="w-12 h-12 text-blue-500 mb-4 mx-auto" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <h3 class="text-2xl font-semibold text-center text-gray-800">46</h3>
                <p class="text-gray-500 text-center">Places</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('<?php echo base_url('api/Courses/count'); ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    document.getElementById('course-count').innerText = data.course_count;
                } else {
                    document.getElementById('course-count').innerText = 'Error';
                }
            })
            .catch(error => {
                document.getElementById('course-count').innerText = 'Error';
            });
    });

    document.addEventListener('DOMContentLoaded', function() {
        fetch('<?php echo base_url('api/Users/count'); ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    document.getElementById('user-count').innerText = data.user_count;
                } else {
                    document.getElementById('user-count').innerText = 'Error';
                }
            })
            .catch(error => {
                document.getElementById('user-count').innerText = 'Error';
            });
    });

    document.addEventListener('DOMContentLoaded', function() {
        fetch('<?php echo base_url('api/Modules/count'); ?>')
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    document.getElementById('module-count').innerText = data.module_count;
                } else {
                    document.getElementById('module-count').innerText = 'Error';
                }
            })
            .catch(error => {
                document.getElementById('module-count').innerText = 'Error';
            });
    });
</script>
<section class="p-6 bg-gray-100 flex-1">
    <h1 class="text-2xl font-bold mb-6"><?= $title ?></h1>

    <!-- Validation -->
    <?php if ($this->session->flashdata('validation_errors')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?= $this->session->flashdata('validation_errors') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            <?= $this->session->flashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            <?= $this->session->flashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Add Button -->
    <div class="mb-6">
        <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Course</button>
    </div>

    <div class="relative overflow-x-auto">
        <table id="coursesTable" class="w-full text-sm text-left rtl:text-right text-gray-950 dark:text-neutral-950">
            <thead class="bg-blue-200 text-black uppercase test-xs">
                <tr>
                    <th class="py-6 px-6 border-b">No</th>
                    <th class="py-6 px-6 border-b">Nama Course</th>
                    <th class="py-6 px-6 border-b">Thumbnail</th>
                    <th class="py-6 px-6 border-b">Kategori</th>
                    <th class="py-6 px-6 border-b">Deskripsi</th>
                    <th class="py-6 px-6 border-b">Harga</th>
                    <th class="py-6 px-6 border-b">Tags</th>
                    <th class="py-6 px-6 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($courses): ?>
                    <?php foreach ($courses as $index => $course): ?>
                        <tr class="hover:bg-blue-100">
                            <td class="py-6 px-6 border-b"><?= $index + 1 ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->courseName) ? html_escape($course->courseName) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->courseThumbnail) ? html_escape($course->courseThumbnail) : '-' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->courseCategory) ? html_escape($course->courseCategory) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b"><?= !empty($course->courseDescription) ? html_escape($course->courseDescription) : 'Deskripsi tidak tersedia' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->coursePrice) ? 'Rp. ' . number_format($course->coursePrice, 0, ',', '.') : 'Gratis' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->courseTags) ? html_escape($course->courseTags) : 'Tidak ada tag' ?></td>
                            <td class="py-6 px-6 border-b">
                                <button class="text-green-600 hover:underline open-modal" data-course-id="<?= $course->courseID ?>" data-course-name="<?= html_escape($course->courseName) ?>" data-course-thumbnail="<?= html_escape($course->courseThumbnail) ?>" data-course-category="<?= html_escape($course->courseCategory) ?>" data-course-description="<?= html_escape($course->courseDescription) ?>" data-course-price="<?= $course->coursePrice ?>" data-course-tags="<?= $course->courseTags ?>">Edit</button> |
                                <button class="text-red-600 hover:underline openModalButton" data-course-id="<?= $course->courseID ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="py-6 px-6 text-center">Tidak ada data course.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Tambah -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="modal-overlay bg-white p-6 rounded-lg shadow-lg w-full max-w-xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Tambah Course</h2>
        <form enctype="multipart/form-data" action="<?= site_url('course/store') ?>" method="post" class="grid grid-cols-2 gap-4 text-sm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <!-- Course Name -->
            <div class="col-span-2 sm:col-span-1">
                <label for="addCourseName" class="block font-semibold text-gray-700 mb-1">Nama Course</label>
                <input required type="text" id="addCourseName" name="courseName" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Thumbnail -->
            <div class="col-span-2 sm:col-span-1">
                <label for="addCourseThumbnail" class="block font-semibold text-gray-700 mb-1">Thumbnail Course</label>
                <input type="file" id="addCourseThumbnail" name="courseThumbnail" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Price -->
            <div class="col-span-2 sm:col-span-1">
                <label for="addCoursePrice" class="block font-semibold text-gray-700 mb-1">Harga</label>
                <input required type="number" id="addCoursePrice" name="coursePrice" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Tags -->
            <div class="col-span-2 sm:col-span-1">
                <label for="addCourseTags" class="block font-semibold text-gray-700 mb-1">Tags</label>
                <input required type="text" id="addCourseTags" name="courseTags" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Description -->
            <div class="col-span-2">
                <label for="addCourseDescription" class="block font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea id="addCourseDescription" name="courseDescription" rows="3" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
            </div>

            <!-- Modules -->
            <div class="col-span-2">
                <label for="addCourseModules" class="block font-semibold text-gray-700 mb-1">Pilih Modules</label>
                <select id="addCourseModules" name="modules[]" multiple class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="" disabled>Loading Modules...</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Tekan Ctrl / Cmd untuk memilih lebih dari satu module.</p>
            </div>

            <!-- Actions -->
            <div class="col-span-2 flex justify-end space-x-3">
                <button type="button" id="closeAddModal" class="py-2 px-3 text-gray-500 border border-gray-300 rounded-md hover:text-gray-700 hover:border-gray-400 transition duration-200">Cancel</button>
                <button type="submit" class="py-2 px-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 shadow-md transition duration-200">Save</button>
            </div>
        </form>
    </div>
</div>




<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="modal-overlay bg-white p-6 rounded-lg shadow-lg w-full max-w-xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Course</h2>
        <form enctype="multipart/form-data" action="<?= site_url('course/update') ?>" method="post" class="grid grid-cols-2 gap-4 text-sm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="courseID" id="modal-courseID">
            <!-- Course Name -->
            <div class="col-span-2 sm:col-span-1">
                <label for="editCourseName" class="block font-semibold text-gray-700 mb-1">Nama Course</label>
                <input required type="text" id="modal-courseName" name="courseName" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Thumbnail -->
            <div class="col-span-2 sm:col-span-1">
                <label for="editCourseThumbnail" class="block font-semibold text-gray-700 mb-1">Thumbnail Course</label>
                <input type="file" id="modal-courseThumbnail" name="courseThumbnail" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Price -->
            <div class="col-span-2 sm:col-span-1">
                <label for="editCoursePrice" class="block font-semibold text-gray-700 mb-1">Harga</label>
                <input required type="number" id="modal-coursePrice" name="coursePrice" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Tags -->
            <div class="col-span-2 sm:col-span-1">
                <label for="editCourseTags" class="block font-semibold text-gray-700 mb-1">Tags</label>
                <input required type="text" id="modal-courseTags" name="courseTags" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
            </div>

            <!-- Description -->
            <div class="col-span-2">
                <label for="editCourseDescription" class="block font-semibold text-gray-700 mb-1">Deskripsi</label>
                <textarea id="editCourseDescription" name="modal-courseDescription" rows="3" class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200"></textarea>
            </div>

            <!-- Modules -->
            <div class="col-span-2">
                <label for="editCourseModules" class="block font-semibold text-gray-700 mb-1">Pilih Modules</label>
                <select id="editCourseModules" name="modules[]" multiple class="w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                    <option value="" disabled>Loading Modules...</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Tekan Ctrl / Cmd untuk memilih lebih dari satu module.</p>
            </div>

            <!-- Actions -->
            <div class="col-span-2 flex justify-end space-x-3">
                <button type="button" id="closeEditModal" class="py-2 px-3 text-gray-500 border border-gray-300 rounded-md hover:text-gray-700 hover:border-gray-400 transition duration-200">Cancel</button>
                <button type="submit" class="py-2 px-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 shadow-md transition duration-200">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Delete Course</h2>
        <p class="mb-6 text-gray-600">Are you sure you want to delete this course? This action cannot be undone.</p>
        <form action="<?= base_url('course/drop') ?>" method="post">
            <!-- CSRF Token -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <!-- Course ID -->
            <input type="hidden" name="courseID" id="modal-delete-courseID">
            <div class="flex justify-center">
                <button type="button" id="closeDeleteModal" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
            </div>
        </form>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // URL API Module
        const apiUrl = 'http://localhost/learnify/api/Modules/';

        // Elemen select untuk modules
        const moduleSelect = document.getElementById('addCourseModules');

        // Function to fetch modules and populate the select element
        function fetchModules() {
            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data modules');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status) {
                        // Kosongkan opsi sebelumnya
                        moduleSelect.innerHTML = '';

                        // Tambahkan opsi ke dalam select
                        data.data.forEach(module => {
                            const option = document.createElement('option');
                            option.value = module.moduleID;
                            option.textContent = module.moduleName;
                            moduleSelect.appendChild(option);
                        });
                    } else {
                        moduleSelect.innerHTML = '<option disabled>Modules tidak tersedia</option>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    moduleSelect.innerHTML = '<option disabled>Gagal memuat modules</option>';
                });
        }

        fetchModules();
    });



    $(document).ready(function() {
        $('#coursesTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/eng.json'
            }
        });

        // Edit Modal
        const editModal = $('#editModal');
        const closeEditModal = $('#closeEditModal');
        const modalInputs = {
            courseID: $('#modal-courseID'),
            courseName: $('#modal-courseName'),
            courseThumbnail: $('#modal-courseThumbnail'),
            courseDescription: $('#modal-courseDescription'),
            coursePrice: $('#modal-coursePrice'),
            courseTags: $('#modal-courseTags'),
        };

        $('.open-modal').on('click', function() {
            const button = $(this);
            modalInputs.courseID.val(button.data('course-id'));
            modalInputs.courseName.val(button.data('course-name'));
            modalInputs.courseThumbnail.val(button.data('course-thumbnail'));
            modalInputs.classCategory.val(button.data('course-category'));
            modalInputs.courseDescription.val(button.data('course-description'));
            modalInputs.coursePrice.val(button.data('course-price'));
            modalInputs.courseTags.val(button.data('course-tags'));

            editModal.removeClass('hidden');
        });

        closeEditModal.on('click', function() {
            editModal.addClass('hidden');
        });

        // Add Modal
        const addModal = $('#addModal');
        const openAddModal = $('#openAddModal');
        const closeAddModal = $('#closeAddModal');

        openAddModal.on('click', function() {
            addModal.removeClass('hidden');
        });

        closeAddModal.on('click', function() {
            addModal.addClass('hidden');
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetch('<?= site_url('api/Modules') ?>')
                .then(response => response.json())
                .then(data => {
                    const modulesSelect = document.getElementById('addCourseModules');
                    if (data.status && data.modules) {
                        data.modules.forEach(module => {
                            const option = document.createElement('option');
                            option.value = module.id;
                            option.textContent = module.name;
                            modulesSelect.appendChild(option);
                        });
                    } else {
                        alert('Gagal memuat data modules.');
                    }
                })
                .catch(error => console.error('Error fetching modules:', error));
        });



        // Delete Modal
        const deleteModal = document.getElementById('deleteModal');
        const closeDeleteModalButton = document.getElementById('closeDeleteModal');
        const openModalButtons = document.querySelectorAll('.openModalButton');
        const courseIDInput = document.getElementById('modal-delete-courseID');

        // Tambahkan event listener pada tombol "Hapus"
        openModalButtons.forEach(button => {
            button.addEventListener('click', () => {
                const courseID = button.getAttribute('data-course-id');
                courseIDInput.value = courseID;
                deleteModal.classList.remove('hidden');
            });
        });


        closeDeleteModalButton.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
        });

        // Tutup modal saat pengguna mengklik area di luar modal
        deleteModal.addEventListener('click', (event) => {
            if (event.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });

    });
</script>
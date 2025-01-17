

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

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table id="coursesTable" class="w-full text-sm text-left rtl:text-right text-gray-950 dark:text-neutral-950">
            <thead class="bg-blue-200 text-black uppercase test-xs">
                <tr>
                    <th class="py-6 px-6 border-b">No</th>
                    <th class="py-6 px-6 border-b">Nama Course</th>
                    <th class="py-6 px-6 border-b">Kategori</th>
                    <th class="py-6 px-6 border-b">Deskripsi</th>
                    <th class="py-6 px-6 border-b">Rating</th>
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
                            <td class="py-6 px-6 border-b"><?= isset($course->courseCategory) ? html_escape($course->courseCategory) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b"><?= !empty($course->courseDescription) ? html_escape($course->courseDescription) : 'Deskripsi tidak tersedia' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->courseRating) ? html_escape($course->courseRating) : '-' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->coursePrice) ? 'Rp. ' . number_format($course->coursePrice, 0, ',', '.') : 'Gratis' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($course->courseTags) ? html_escape($course->courseTags) : 'Tidak ada tag' ?></td>
                            <td class="py-6 px-6 border-b">
                                <button class="text-green-600 hover:underline open-modal" data-course-id="<?= $course->courseID ?>" data-course-name="<?= html_escape($course->courseName) ?>" data-course-category="<?= html_escape($course->courseCategory) ?>" data-course-description="<?= html_escape($course->courseDescription) ?>" data-course-price="<?= $course->coursePrice ?>" data-course-tags="<?= $course->courseTags ?>">Edit</button> |
                                <button class="text-red-600 hover:underline openModalButton " data-course-id="<?= $course->courseID ?>">Hapus</button>
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


<!-- Modal -->

<!-- Modal Tambah -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Tambah Course</h2>
        <form action="<?= site_url('course/store') ?>" method="post">
            <input type="hidden" name="<?= $csrf_token_name; ?>" value="<?= $csrf_hash; ?>" />
            <div class="mb-4">
                <label for="addCourseName" class="block text-sm font-medium text-gray-700">Nama Course</label>
                <input required type="text" id="addCourseName" name="courseName" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="addCourseCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select required id="addCourseCategory" name="courseCategory" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="1">Kategori 1</option>
                    <option value="2">Kategori 2</option>
                    <option value="3">Kategori 3</option>
                    <option value="4">Kategori 4</option>
                    <option value="5">Kategori 5</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="addCourseDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="addCourseDescription" name="courseDescription" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="addCoursePrice" class="block text-sm font-medium text-gray-700">Harga</label>
                <input required type="number" id="addCoursePrice" name="coursePrice" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="addCourseTags" class="block text-sm font-medium text-gray-700">Tags</label>
                <input required type="text" id="addCourseTags" name="courseTags" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeAddModal" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>


<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Course</h2>
        <form action="<?= site_url('course/update') ?>" method="post">
            <input type="hidden" name="<?= $csrf_token_name; ?>" value="<?= $csrf_hash; ?>" />
            <input type="hidden" name="courseID" id="modal-courseID">
            <div class="mb-4">
                <label for="courseName" class="block text-sm font-medium text-gray-700">Nama Course</label>
                <input required type="text" id="modal-courseName" name="courseName" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="courseCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select required id="modal-courseCategory" name="courseCategory" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="1">Kategori 1</option>
                    <option value="2">Kategori 2</option>
                    <option value="3">Kategori 3</option>
                    <option value="4">Kategori 4</option>
                    <option value="5">Kategori 5</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="courseDescription" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea id="modal-courseDescription" name="courseDescription" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
            </div>
            <div class="mb-4">
                <label for="coursePrice" class="block text-sm font-medium text-gray-700">Harga</label>
                <input required type="number" id="modal-coursePrice" name="coursePrice" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
            </div>
            <div class="mb-4">
                <label for="courseTags" class="block text-sm font-medium text-gray-700">Tags</label>
                <input required type="text" id="modal-courseTags" name="courseTags" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Delete Course</h2>
        <p class="mb-6 text-gray-600">Are you sure you want to delete this course? This action cannot be undone.</p>
        <form action="<?= site_url('course/delete') ?>" method="post">
            <input type="hidden" name="<?= $csrf_token_name; ?>" value="<?= $csrf_hash; ?>" />
            <input type="hidden" name="courseID" id="modal-courseID">
            <div class="flex justify-center">
                <button type="button" id="closeModal" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Delete</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"> </script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('editModal');
        const closeModal = document.getElementById('closeModal');
        const modalInputs = {
            courseID: document.getElementById('modal-courseID'),
            courseName: document.getElementById('modal-courseName'),
            courseCategory: document.getElementById('modal-courseCategory'),
            courseDescription: document.getElementById('modal-courseDescription'),
            coursePrice: document.getElementById('modal-coursePrice'),
            courseTags: document.getElementById('modal-courseTags'),
        };

        document.querySelectorAll('.open-modal').forEach(button => {
            button.addEventListener('click', () => {
                modalInputs.courseID.value = button.dataset.courseId;
                modalInputs.courseName.value = button.dataset.courseName;
                modalInputs.courseCategory.value = button.dataset.courseCategory;
                modalInputs.courseDescription.value = button.dataset.courseDescription;
                modalInputs.coursePrice.value = button.dataset.coursePrice;
                modalInputs.courseTags.value = button.dataset.courseTags;

                modal.classList.remove('hidden');
            });
        });

        closeModal.addEventListener('click', () => {
            modal.classList.add('hidden');
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const addModal = document.getElementById('addModal');
        const openAddModal = document.getElementById('openAddModal');
        const closeAddModal = document.getElementById('closeAddModal');

        openAddModal.addEventListener('click', () => {
            addModal.classList.remove('hidden');
        });

        closeAddModal.addEventListener('click', () => {
            addModal.classList.add('hidden');
        });
    });


    document.addEventListener('DOMContentLoaded', () => {
        const deleteModal = document.getElementById('deleteModal');
        const closeModalButton = document.getElementById('closeModal');
        const openDeleteModal = document.querySelector('.openModalButton'); // Asumsikan class ini untuk tombol pembuka modal

        // Event listener untuk membuka modal
        openDeleteModal.addEventListener('click', () => {
            deleteModal.classList.remove('hidden');
        });

        // Event listener untuk menutup modal
        closeModalButton.addEventListener('click', () => {
            deleteModal.classList.add('hidden');
        });

        // Menutup modal jika klik di luar modal
        deleteModal.addEventListener('click', (e) => {
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });
    });


    $(document).ready(function() {
        $('#coursesTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/eng.json' // Bahasa Indonesia
            }
        });
    });
</script>
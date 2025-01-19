<section class="p-6 bg-gray-100 flex-1">
    <h1 class="text-2xl font-bold mb-6">Daftar <?= $title ?></h1>

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
        <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Module</button>
    </div>

    <div class="relative overflow-x-auto">
        <table id="modulesTable" class="w-full text-sm text-left rtl:text-right text-gray-950 dark:text-neutral-950">
            <thead class="bg-blue-200 text-black uppercase test-xs">
                <tr>
                    <th class="py-6 px-6 border-b">No</th>
                    <th class="py-6 px-6 border-b">Nama Module</th>
                    <th class="py-6 px-6 border-b">Module Tags</th>
                    <th class="py-6 px-6 border-b">Deskripsi</th>
                    <th class="py-6 px-6 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($modules)): ?>
                    <?php foreach ($modules as $index => $module): ?>
                        <tr class="hover:bg-blue-100">
                            <td class="py-6 px-6 border-b"><?= $index + 1 ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($module->moduleName) ? html_escape($module->moduleName) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($module->moduleTags) ? html_escape($module->moduleTags) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b"><?= !empty($module->moduleDescription) ? html_escape($module->moduleDescription) : 'Deskripsi tidak tersedia' ?></td>
                            <td class="py-6 px-6 border-b">
                                <button class="text-green-600 hover:underline open-modal" data-module-id="<?= $module->moduleID ?>" data-module-name="<?= html_escape($module->moduleName) ?>" data-module-category="<?= html_escape($module->moduleTags)  ?>" data-module-description="<?= html_escape($module->moduleDescription) ?>">Edit</button> |
                                <button class="text-red-600 hover:underline openModalButton" data-module-id="<?= $module->moduleID ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="py-6 px-6 text-center">Tidak ada data <?= $title ?>.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

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
                <label for="addClassCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select required id="addClassCategory" name="classCategory" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
                <label for="classCategory" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select required id="modal-classCategory" name="classCategory" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
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
                <input required type="number" id="modal-coursePrice" name="coursePrice" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="mb-4">
                <label for="courseTags" class="block text-sm font-medium text-gray-700">Tags</label>
                <input required type="text" id="modal-courseTags" name="courseTags" class="mt-1 block w-full rounded-sm border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            <div class="flex justify-end">
                <button type="button" id="closeEditModal" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
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
    $(document).ready(function() {
        $('#modulesTable').DataTable({
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
            classCategory: $('#modal-classCategory'),
            courseDescription: $('#modal-courseDescription'),
            coursePrice: $('#modal-coursePrice'),
            courseTags: $('#modal-courseTags'),
        };

        $('.open-modal').on('click', function() {
            const button = $(this);
            modalInputs.courseID.val(button.data('course-id'));
            modalInputs.courseName.val(button.data('course-name'));
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

        // Delete Modal
        const deleteModal = $('#deleteModal');
        const closeDeleteModal = $('#closeDeleteModal');
        const openDeleteModal = $('.openModalButton');

        openDeleteModal.on('click', function() {
            const button = $(this);
            $('#modal-delete-courseID').val(button.data('course-id'));
            deleteModal.removeClass('hidden');
        });

        closeDeleteModal.on('click', function() {
            deleteModal.addClass('hidden');
        });

        // Close modal if click outside
        $(window).on('click', function(event) {
            if ($(event.target).is(deleteModal)) {
                deleteModal.addClass('hidden');
            }
            if ($(event.target).is(editModal)) {
                editModal.addClass('hidden');
            }
            if ($(event.target).is(addModal)) {
                addModal.addClass('hidden');
            }
        });
    });
</script>
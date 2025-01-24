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
                    <th class="py-6 px-6 border-b">Material</th>
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
                            <td class="py-6 px-6 border-b"><?= isset($module->materialNames) ? html_escape($module->materialNames) : 'Material tidak tersedia' ?></td>
                            <td class="py-6 px-6 border-b">
                                <button class="text-green-600 hover:underline open-modal" data-module-id="<?= $module->moduleID ?>" data-module-name="<?= html_escape($module->moduleName) ?>" data-module-tags="<?= html_escape($module->moduleTags)  ?>" data-module-description="<?= html_escape($module->moduleDescription) ?>"
                                    data-module-hasMaterial="<?= html_escape($module->materialNames) ?>">Edit</button> |
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
<div id="addModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white w-full max-w-lg p-6 rounded-sm relative">
        <button id="closeAddModal" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            &#x2715;
        </button>
        <h2 class="text-xl font-bold mb-4">Tambah Module</h2>
        <form action="<?= site_url('dashboard/Module/store') ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <!-- Nama Module -->
            <div class="mb-4">
                <label for="moduleName" class="block text-sm font-medium text-gray-700">Nama Modul</label>
                <input type="text" id="moduleName" name="moduleName" class="mt-1 px-4 py-2 border rounded w-full" required>
            </div>

            <!-- Tags Module -->
            <div class="mb-4">
                <label for="moduleTags" class="block text-sm font-medium text-gray-700">Tags Modul</label>
                <input type="text" id="moduleTags" name="moduleTags" class="mt-1 px-4 py-2 border rounded w-full">
                <small class="text-gray-500">Pisahkan tag dengan koma (misal: tag1, tag2, tag3).</small>
            </div>

            <!-- Deskripsi Module -->
            <div class="mb-4">
                <label for="moduleDescription" class="block text-sm font-medium text-gray-700">Deskripsi Modul</label>
                <textarea id="moduleDescription" name="moduleDescription" class="mt-1 px-4 py-2 border rounded w-full" rows="4"></textarea>
            </div>

            <!-- Pilihan Materials -->
            <div class="col-span-2">
                <label class="block font-semibold text-gray-700 mb-1">Pilih Materials</label>
                <div class="space-y-2">
                    <?php if (!empty($materials)): ?>
                        <?php foreach ($materials as $key => $material): ?>
                            <div>
                                <input
                                    type="checkbox"
                                    id="material_<?= $material->materialID ?>"
                                    name="materials[]"
                                    value="<?= $material->materialID ?>"
                                    class="mr-2">
                                <label for="material_<?= $material->materialID ?>" class="text-gray-700">
                                    <?= $material->materialName ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500">No Materials Available</p>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-gray-500 mt-1">Centang material yang ingin dipilih.</p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end">
                <button type="button" id="cancelAddModal" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>



<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class=" bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Module</h2>
        <form action="<?= site_url('dashboard/module/update') ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="moduleID" id="modal-moduleID">
            <div class="mb-4">
                <label for="moduleName" class="block text-sm font-medium text-gray-700">Nama Modul</label>
                <input type="text" id="modal-moduleName" name="moduleName" class="mt-1 px-4 py-2 border rounded w-full" required>
            </div>
            <div class="mb-4">
                <label for="moduleTags" class="block text-sm font-medium text-gray-700">Tags Modul</label>
                <input type="text" id="modal-moduleTags" name="moduleTags" class="mt-1 px-4 py-2 border rounded w-full">
                <small class="text-gray-500">Pisahkan tag dengan koma (misal: tag1, tag2, tag3).</small>
            </div>
            <div class="mb-4">
                <label for="moduleDescription" class="block text-sm font-medium text-gray-700">Deskripsi Modul</label>
                <textarea id="modal-moduleDescription" name="moduleDescription" class="mt-1 px-4 py-2 border rounded w-full" rows="4"></textarea>
            </div>

            <?php
            $selectedMaterials = isset($module->moduleID) ? explode('|', $module->moduleID) : [];
            ?>
            <div class="col-span-2">
                <label class="block font-semibold text-gray-700 mb-1">Pilih Modules</label>
                <div class="space-y-2">
                    <?php if (!empty($materials)): ?>
                        <?php foreach ($materials as $material): ?>
                            <?php
                            $isChecked = in_array($material->materialID, $selectedMaterials); // Apakah material ini ada di database
                            ?>
                            <div>
                                <input
                                    type="checkbox"
                                    id="module_<?= $material->materialID ?>"
                                    name="materials[]"
                                    value="<?= $material->materialID ?>"
                                    class="mr-2"
                                    <?= $isChecked ? 'checked' : '' ?>>
                                <label for="module_<?= $material->materialID ?>" class="text-gray-700">
                                    <?= $material->materialName ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500">No Modules Available</p>
                    <?php endif; ?>
                </div>
                <p class="text-xs text-gray-500 mt-1">Centang modul yang ingin dipilih.</p>
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
        <h2 class="text-xl font-bold mb-4">Delete Module</h2>
        <p class="mb-6 text-gray-600">Are you sure you want to delete this module? This action cannot be undone.</p>
        <form action="<?= site_url('dashboard/module/delete') ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="moduleID" id="modal-delete-moduleID">
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
            moduleID: $('#modal-moduleID'),
            moduleName: $('#modal-moduleName'),
            moduleTags: $('#modal-moduleTags'),
            moduleDescription: $('#modal-moduleDescription'),
        };

        $('.open-modal').on('click', function() {
            const button = $(this);
            modalInputs.moduleID.val(button.data('module-id'));
            modalInputs.moduleName.val(button.data('module-name'));
            modalInputs.moduleTags.val(button.data('module-tags'));
            modalInputs.moduleDescription.val(button.data('module-description'));

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
<section class="p-6 bg-gray-100 flex-1">
    <h1 class="text-2xl font-bold mb-6">Daftar <?= $title ?></h1>

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
        <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah Material</button>
    </div>

    <div class="relative overflow-x-auto">
        <table id="materialsTable" class="w-full text-sm text-left rtl:text-right text-gray-950 dark:text-neutral-950">
            <thead class="bg-blue-200 text-black uppercase test-xs">
                <tr>
                    <th class="py-6 px-6 border-b">Id</th>
                    <th class="py-6 px-6 border-b">Nama Material</th>
                    <th class="py-6 px-6 border-b">Konten</th>
                    <th class="py-6 px-6 border-b">Media</th>
                    <th class="py-6 px-6 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($materials)): ?>
                    <?php foreach ($materials as $index => $material): ?>
                        <tr class="hover:bg-blue-100">
                            <td class="py-6 px-6 border-b"><?= $material->materialID ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($material->materialName) ? html_escape($material->materialName) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($material->mediaNames) ? html_escape($material->mediaNames) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b"><?= isset($material->materialContent) ? html_escape($material->materialContent) : 'N/A' ?></td>
                            <td class="py-6 px-6 border-b">
                                <button class="text-green-600 hover:underline open-modal" data-material-id="<?= $material->materialID ?>" data-material-name="<?= html_escape($material->materialName) ?>" data-material-content="<?= html_escape($material->materialContent) ?>" data-material-tags="<?= html_escape($material->materialTags) ?>">Edit</button> |
                                <button class="text-red-600 hover:underline openModalButton" data-material-id="<?= $material->materialID ?>">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="py-6 px-6 text-center">Tidak ada data <?= $title ?>.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Modal Tambah -->
<div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Tambah Material</h2>
        <form action="<?= site_url('dashboard/material/store') ?>" method="post">
            <!-- CSRF Token -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <!-- Nama Material -->
            <div class="mb-4">
                <label for="materialName" class="block text-sm font-medium text-gray-700">Nama Material</label>
                <input
                    type="text"
                    id="materialName"
                    name="materialName"
                    class="mt-1 px-4 py-2 border rounded w-full"
                    required>
            </div>

            <!-- Konten Material -->
            <div class="mb-4">
                <label for="materialContent" class="block text-sm font-medium text-gray-700">Konten Material</label>
                <textarea
                    id="materialContent"
                    name="materialContent"
                    class="mt-1 px-4 py-2 border rounded w-full"
                    rows="4"></textarea>
            </div>

            <!-- Tags Material -->
            <div class="mb-4">
                <label for="materialTags" class="block text-sm font-medium text-gray-700">Tags Material</label>
                <input
                    type="text"
                    id="materialTags"
                    name="materialTags"
                    class="mt-1 px-4 py-2 border rounded w-full">
                <small class="text-gray-500">Pisahkan tag dengan koma (misal: tag1, tag2, tag3).</small>
            </div>

            <!-- URL Media -->
            <div class="mb-4">
                <label for="materialMediaUrl" class="block text-sm font-medium text-gray-700">URL Media</label>
                <input
                    type="url"
                    id="materialMediaUrl"
                    name="materialMediaUrl"
                    class="mt-1 px-4 py-2 border rounded w-full"
                    placeholder="https://www.youtube.com/embed/"
                    required>
                <small class="text-gray-500">Masukkan URL media, seperti video atau gambar (misal: https://www.youtube.com/embed/videoId).</small>
            </div>

            <!-- Actions -->
            <div class="flex justify-end">
                <button
                    type="button"
                    id="closeAddModal"
                    class="text-gray-500 hover:text-gray-700 mr-4">Cancel</button>
                <button
                    type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>



<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-xl font-bold mb-4">Edit Material</h2>
        <form action="<?= site_url('dashboard/material/update') ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="materialID" id="modal-materialID">

            <div class="mb-4">
                <label for="materialName" class="block text-sm font-medium text-gray-700">Nama Material</label>
                <input type="text" id="modal-materialName" name="materialName" class="mt-1 px-4 py-2 border rounded w-full" required>
            </div>

            <div class="mb-4">
                <label for="materialContent" class="block text-sm font-medium text-gray-700">Konten Material</label>
                <textarea id="modal-materialContent" name="materialContent" class="mt-1 px-4 py-2 border rounded w-full" rows="4"></textarea>
            </div>

            <div class="mb-4">
                <label for="materialTags" class="block text-sm font-medium text-gray-700">Tags Material</label>
                <input type="text" id="modal-materialTags" name="materialTags" class="mt-1 px-4 py-2 border rounded w-full">
                <small class="text-gray-500">Pisahkan tag dengan koma (misal: tag1, tag2, tag3).</small>
            </div>

            <div class="mb-4">
                <label for="materialMediaUrl" class="block text-sm font-medium text-gray-700">URL Media</label>
                <input type="url" id="modal-materialMediaUrl" name="materialMediaUrl" class="mt-1 px-4 py-2 border rounded w-full" placeholder="https://example.com/media.mp4" required>
                <small class="text-gray-500">Masukkan URL media, seperti video atau gambar (misal: https://video.com/sample.mp4).</small>
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
        <h2 class="text-xl font-bold mb-4">Delete Material</h2>
        <p class="mb-6 text-gray-600">Are you sure you want to delete this material? This action cannot be undone.</p>
        <form action="<?= site_url('dashboard/Material/delete') ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="materialID" id="modal-delete-materialID">
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
        $('#materialsTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/eng.json'
            }
        });

        // Edit Modal
        const editModal = $('#editModal');
        const closeEditModal = $('#closeEditModal');
        const modalInputs = {
            materialID: $('#modal-materialID'),
            materialName: $('#modal-materialName'),
            materialContent: $('#modal-materialContent'),
            materialTags: $('#modal-materialTags'),
        };

        $('.open-modal').on('click', function() {
            const button = $(this);
            modalInputs.materialID.val(button.data('material-id'));
            modalInputs.materialName.val(button.data('material-name'));
            modalInputs.materialContent.val(button.data('material-content'));
            modalInputs.materialTags.val(button.data('material-tags'));

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
            $('#modal-delete-materialID').val(button.data('material-id'));
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
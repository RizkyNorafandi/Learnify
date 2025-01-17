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
        <button id="openAddModal" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Tambah User</button>
    </div>
    <div class="overflow-x-auto">
        <div class="ml-auto">
            <table id="userTable" class="w-full text-sm text-left rtl:text-right bg-white border border-gray-300">
                <thead class="bg-blue-200 text-black uppercase test-xs">
                    <tr>
                        <th class="py-6 px-6 border-b">No</th>
                        <th class="py-6 px-6 border-b">Nama User</th>
                        <th class="py-6 px-6 border-b">Email</th>
                        <th class="py-6 px-6 border-b">No. Telepon</th>
                        <th class="py-6 px-6 border-b">Alamat</th>
                        <th class="py-6 px-6 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $index => $user): ?>
                            <tr class="hover:bg-blue-100">
                                <td class="py-6 px-6 border-b"><?= $index + 1 ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($user->userFullname) ? html_escape($user->userFullname) : 'N/A' ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($user->userEmail) ? html_escape($user->userEmail) : 'N/A' ?></td>
                                <td class="py-6 px-6 border-b"><?= !empty($user->userPhone) ? html_escape($user->userPhone) : 'Deskripsi tidak tersedia' ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($user->userAddress) ? html_escape($user->userAddress) : '-' ?></td>
                                <td class="py-6 px-6 border-b">
                                    <a href="<?= site_url('user/edit/' . $user->userID) ?>" class="text-green-600 hover:underline">Edit</a> |
                                    <a href="<?= site_url('user/delete/' . $user->userID) ?>" class="text-red-600 hover:underline">Hapus</a>
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
    </div>
</section>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script>
    $('#userTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/eng.json'
        }
    });
</script>
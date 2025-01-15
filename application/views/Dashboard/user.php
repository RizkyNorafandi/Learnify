<section class="p-6 bg-gray-100 flex-1">
    <h1 class="text-2xl font-bold mb-6"><?= $title ?></h1>
    <div class="overflow-x-auto">
        <div class="ml-auto">
            <table class="w-full bg-white border border-gray-300 text-lg rounded-2xl">
                <thead class="bg-blue-200 text-black">
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
                    <?php if (!empty($courses)): ?>
                        <?php foreach ($courses as $index => $course): ?>
                            <tr class="hover:bg-blue-100">
                                <td class="py-6 px-6 border-b"><?= $index + 1 ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($course->courseName) ? html_escape($course->courseName) : 'N/A' ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($course->classCategory) ? html_escape($course->classCategory) : 'N/A' ?></td>
                                <td class="py-6 px-6 border-b"><?= !empty($course->courseDescription) ? html_escape($course->courseDescription) : 'Deskripsi tidak tersedia' ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($course->courseRating) ? html_escape($course->courseRating) : '-' ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($course->coursePrice) ? 'Rp. ' . number_format($course->coursePrice, 0, ',', '.') : 'Gratis' ?></td>
                                <td class="py-6 px-6 border-b"><?= isset($course->courseTags) ? html_escape($course->courseTags) : 'Tidak ada tag' ?></td>
                                <td class="py-6 px-6 border-b">
                                    <a href="<?= site_url('course/edit/' . $course->courseID) ?>" class="text-green-600 hover:underline">Edit</a> |
                                    <a href="<?= site_url('course/delete/' . $course->courseID) ?>" class="text-red-600 hover:underline">Hapus</a>
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
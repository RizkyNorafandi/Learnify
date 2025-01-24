<aside class="sidebar fixed lg:relative top-0 bottom-0 left-0 lg:left-0 lg:w-[300px] w-[300px] duration-500 p-4 bg-gray-900 text-white shadow min-h-screen">
    <div>
        <!-- Sidebar Header -->
        <div class="flex items-center p-2.5 rounded-md">
            <i class="bi bi-app-indicator px-2 py-1 bg-blue-600 rounded-md"></i>
            <h1 class="text-xl ml-3 font-bold">Learnify</h1>
            <i class="bi bi-x ml-auto cursor-pointer lg:hidden" onclick="toggleSidebar()"></i>
        </div>
        <hr class="my-2 border-gray-600">

        <!-- Sidebar Links -->
        <nav>
            <a href="<?= site_url('admin/dashboard') ?>" class="flex items-center p-2.5 mt-2 rounded-md px-4 duration-300 hover:bg-blue-600">
                <i class="bi bi-house-door-fill"></i>
                <span class="ml-4 text-sm">Dashboard</span>
            </a>
            <a href="<?= site_url('admin/course') ?>" class="flex items-center p-2.5 mt-2 rounded-md px-4 duration-300 hover:bg-blue-600">
                <i class="bi bi-book-fill"></i>
                <span class="ml-4 text-sm">Course</span>
            </a>
            <a href="<?= site_url('admin/module') ?>" class="flex items-center p-2.5 mt-2 rounded-md px-4 duration-300 hover:bg-blue-600">
                <i class="bi bi-file-earmark-fill"></i>
                <span class="ml-4 text-sm">Module</span>
            </a>
            <a href="<?= site_url('admin/user') ?>" class="flex items-center p-2.5 mt-2 rounded-md px-4 duration-300 hover:bg-blue-600">
                <i class="bi bi-person-fill"></i>
                <span class="ml-4 text-sm">User</span>
            </a>
            <a href="<?= site_url('admin/material') ?>" class="flex items-center p-2.5 mt-2 rounded-md px-4 duration-300 hover:bg-blue-600">
                <i class="bi bi-box"></i>
                <span class="ml-4 text-sm">Material</span>
            </a>
            <hr class="my-4 border-gray-600">
            <a href="<?= site_url('admin/logout') ?>" class="flex items-center p-2.5 rounded-md px-4 duration-300 hover:bg-blue-600">
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="ml-4 text-sm">Logout</span>
            </a>
        </nav>
    </div>
</aside>
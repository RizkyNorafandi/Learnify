<!-- Sidebar Section Start -->
<aside>
    <div class="container-fluid h-100 d-flex flex-column p-0">
        <div class="box p-4">
            <h4><?= $title ?></h4>
            <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" style="width: 25%"></div>
            </div>
            <p>25% Complete</p>
        </div>
        <!-- Batas progress dengan sub modul -->
        <div class="accordion overflow-y-auto" id="accordionExample">
            <?php
                $modules = $sidebarData->modules; // Akses modul dari sidebarData
                foreach ($modules as $module): // Iterasi melalui modul
            ?>
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                            data-bs-target="#module-<?= $module->moduleID ?>" aria-expanded="true" aria-controls="module-<?= $module->moduleID ?>">
                            <?= $module->moduleName ?>
                        </button>
                    </h2>
                    <div id="module-<?= $module->moduleID ?>" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                            <div class="box-materi d-flex flex-column ps-3 gap-2">
                                <?php
                                    if (!empty($module->materials)): // Periksa apakah ada materi
                                        foreach ($module->materials as $material): // Iterasi melalui materi
                                ?>
                                <div class="materi">
                                    <div class="materi-circle done"></div>
                                    <a class="materi-link <?= $material->materialID == $activeMaterialID ? 'link-underline-primary' : '' ?>" 
                                       href="<?= base_url('learning?courseID='.$sidebarData->courseID.'&materialID='.$material->materialID); ?>">
                                       <?= $material->materialName ?>
                                    </a>
                                </div>
                                <?php
                                        endforeach; // Akhiri iterasi materi
                                    else: // Jika tidak ada materi
                                ?>
                                <p class="text-muted">Tidak ada materi tersedia.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</aside>
<!-- Sidebar End -->

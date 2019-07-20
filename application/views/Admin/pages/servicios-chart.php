<section class="bs-page-section bs-page-administradores">

    <div class="bs-page-section-table">
        <div class="bs-page-section-header">
            <div class="ps-header-section-left">
                <h4 class="bs-page-section-title"><?= $page_title ?> Graficos</h4>
            </div>
            <div class="bs-header-section-right">
                <a href="<?= base_url() ?>BackOffice/<?= $section ?>/create_pdf?type=pagos" class="bs-section-download"><i class="fas fa-file-export"></i></a>
            </div>
        </div>
        <div class="bs-page-section-body">
            <div class="bs-page-chart-container">
                <canvas class="bs-page-chart" id="bs-services-chart"></canvas>
            </div>
        </div>
    </div>

</section>
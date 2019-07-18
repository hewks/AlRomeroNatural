<!-- Admin section -->
<section class="bs-page-section bs-page-administradores">

    <!-- Table -->
    <div class="bs-page-section-table">
        <div class="bs-page-section-header">
            <div class="ps-header-section-left">
                <h4 class="bs-page-section-title"><?= $page_title ?></h4>
            </div>
            <div class="bs-header-section-right">
                <a href="<?= base_url() ?>Back/<?= $section ?>/create_pdf?type=compras" class="bs-section-download"><i class="fas fa-file-export"></i></a>
                <button class="bs-section-add" data-toggle="modal" data-target="#addModal">Agregar</button>
            </div>
        </div>
        <div class="bs-page-section-body">
            <table class="bs-table table table-striped table-bordered" style="width: 100% !important;" id="tableSectionTable">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Producto</td>
                        <td>Cantidad</td>
                        <td>Unidad</td>
                        <td>Total</td>
                        <td>Usuario</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td>ID</td>
                        <td>Producto</td>
                        <td>Cantidad</td>
                        <td>Unidad</td>
                        <td>Total</td>
                        <td>Usuario</td>
                        <td>Fecha</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Table -->

</section>
<!-- Admin section -->

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="tableSection();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="bs-admin-form" id="bs-send-form">
                    <div class="bs-admin-form-group">
                        <label for="product">Producto</label>
                        <select name="product" data-name="Producto" class="bs-admin-input productSelect">
                        </select>
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="quantity">Cantidad</label>
                        <input type="text" name="quantity" data-name="Cantidad" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="buyPrice">Precio de Compra (Unidad)</label>
                        <input type="text" name="buyPrice" data-name="Precio de Compra (Unidad)" class="bs-admin-input">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="tableSection();">Cerrar</button>
                <button type="button" class="btn btn-primary" id="bs-send-form-button">Comprar</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->
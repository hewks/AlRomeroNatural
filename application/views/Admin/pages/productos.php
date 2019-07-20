<!-- Admin section -->
<section class="bs-page-section bs-page-administradores">

    <!-- Table -->
    <div class="bs-page-section-table">
        <div class="bs-page-section-header">
            <div class="ps-header-section-left">
                <h4 class="bs-page-section-title"><?= $page_title ?></h4>
            </div>
            <div class="bs-header-section-right">
                <a href="<?= base_url() ?>BackOffice/<?= $section ?>/create_pdf?type=products" class="bs-section-download"><i class="fas fa-file-export"></i></a>
                <button class="bs-section-add" data-toggle="modal" data-target="#addModal">Agregar</button>
            </div>
        </div>
        <div class="bs-page-section-body">
            <table class="bs-table table table-striped table-bordered" style="width: 100% !important;" id="tableSectionTable">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Producto</td>
                        <td>Categoria</td>
                        <td>Valor</td>
                        <td>Ultima Compra</td>
                        <td>Descuento</td>
                        <td>Inventario</td>
                        <td>Status</td>
                        <td>Act</td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <td>ID</td>
                        <td>Producto</td>
                        <td>Categoria</td>
                        <td>Valor</td>
                        <td>Ultima Compra</td>
                        <td>Descuento</td>
                        <td>Inventario</td>
                        <td>Status</td>
                        <td>Act</td>
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
                        <input type="text" name="product" data-name="Producto" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="category">Categoria</label>
                        <select name="category" data-name="Categoria" class="bs-admin-input categoriesSelect">

                        </select>
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="price">Valor</label>
                        <input type="text" name="price" data-name="Valor" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="discount">Descuento</label>
                        <input type="text" name="discount" data-name="Descuento" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="largeDescription">Descripcion Larga</label>
                        <input type="text" name="largeDescription" data-name="Descripcion Larga" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="shortDescription">Descripcion Corta</label>
                        <input type="text" name="shortDescription" data-name="Descripcion Corta" class="bs-admin-input">
                    </div>
                    <!-- <div class="bs-admin-form-group">
                        <label for="image">Imagen</label>
                        <input type="file" name="image" data-name="Imagen" class="bs-admin-input">
                    </div> -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="tableSection();">Cerrar</button>
                <button type="button" class="btn btn-primary" id="bs-send-form-button">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Modal -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= $page_title ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="tableSection();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="bs-admin-form" id="bs-edit-form">
                    <div class="bs-admin-form-group">
                        <label for="product">Producto</label>
                        <input type="text" name="product" data-name="Producto" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="category">Categoria</label>
                        <select name="category" data-name="Categoria" class="bs-admin-input categoriesSelect">
                        </select>
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="price">Valor</label>
                        <input type="text" name="price" data-name="Valor" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="discount">Descuento</label>
                        <input type="text" name="discount" data-name="Descuento" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="largeDescription">Descripcion Larga</label>
                        <input type="text" name="largeDescription" data-name="Descripcion Larga" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="shortDescription">Descripcion Corta</label>
                        <input type="text" name="shortDescription" data-name="Descripcion Corta" class="bs-admin-input">
                    </div>
                    <div class="bs-admin-form-group">
                        <label for="stock">Ineventario</label>
                        <input type="text" name="stock" data-name="Inventario" class="bs-admin-input">
                    </div>
                    <!-- <div class="bs-admin-form-group">
                        <label for="image">Imagen</label>
                        <input type="file" name="image" data-name="Imagen" class="bs-admin-input">
                    </div> -->
                    <input type="hidden" name="id" data-name="ID" class="bs-admin-input">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="tableSection();">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="editSection();">Agregar</button>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal -->
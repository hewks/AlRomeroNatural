<h1 class="hw-font-theme hw-text-center hw-mt-20 hw-mb-50"><?= $fullname ?></h1>
<div class="hw-row-container hw-fluid-container hw-sm-mt-20 hw-theme-bg-tr hw-rounded-20 hw-pt-20">
    <div class="hw-row-col-50 hw-total-center-container">
        <div class="hw-profile-avatar" style="background-image: url('<?= $avatar_image ?>')"></div>
    </div>
    <div class="hw-row-col-50">
        <div class="hw-total-center-container hw-mb-50 hw-pt-20 hw-column-container">
            <div class="hw-form-selector hw-tw-90 hw-mt-40">
                <button class="hw-btn-form-selector hw-pb-20 hw-fs-2 hw-sm-pb-60 hw-active-selector" data-form="hw-edit-form">Mis datos</button>
                <button class="hw-btn-form-selector hw-pb-20 hw-fs-2 hw-sm-pb-60" data-form="hw-password-form">Cambiar Contrasena</button>
            </div>
            <form class="hw-theme-user-form hw-active-form hw-transparent-bg hw-pt-10" id="hw-edit-form">
                <div class="hw-form-group">
                    <input type="text" name="name" data-name="Nombre" class="hw-form-input" value="<?= $name ?>" placeholder="Nombre">
                </div>
                <div class="hw-form-group">
                    <input type="text" name="lastname" data-name="Apellido" class="hw-form-input" value="<?= $lastname ?>" placeholder="Apellido">
                </div>
                <div class="hw-form-group">
                    <input type="text" name="username" data-name="Nombre de usuario" class="hw-form-input" value="<?= $username ?>" placeholder="Nombre de Usuario">
                </div>
                <div class="hw-form-group">
                    <input type="text" name="document" data-name="Documento" class="hw-form-input" value="<?= $document ?>" placeholder="Documento">
                </div>
                <div class="hw-form-group">
                    <input type="text" name="phone" data-name="Celular" class="hw-form-input" value="<?= $phone ?>" placeholder="Celular">
                </div>
                <input type="hidden" name="id" class="hw-form-input" value="<?= $id ?>">
                <button class="hw-btn hw-send-form" data-send="hw-edit-form">Guardar</button>
            </form>
            <form class="hw-theme-user-form hw-transparent-bg hw-pt-20" id="hw-password-form">
                <div class="hw-form-group">
                    <input type="password" name="password" id="password_1" data-name="Contraseña" class="hw-form-input" placeholder="Nueva Contraseña">
                </div>
                <div class="hw-form-group">
                    <input type="password" name="password_2" id="password_2" data-name="Repetir Contraseña" class="hw-form-input" placeholder="Repetir Contraseña">
                </div>
                <input type="hidden" name="id" class="hw-form-input" value="<?= $id ?>">
                <button class="hw-btn hw-send-form" data-send="hw-password-form">Guardar</button>
            </form>
        </div>
    </div>
</div>
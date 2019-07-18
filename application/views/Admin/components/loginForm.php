<section class="bs-fix-section bs-flex-center-wrapper bs-super-wrapper">
    <form class="bs-form bs-d-block bs-login-form" id="bs-send-form">
        <div class="bs-form-group">
            <label for="username">Usuario</label>
            <input type="text" class="bs-form-input" placeholder="Username" name="username" data-name="Usuario">
        </div>
        <div class="bs-form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="bs-form-input" placeholder="Password" name="password" data-name="Contraseña">
        </div>
        <div class="bs-form-btn-group">
            <button class="bs-btn bs-btn-primary" id="bs-send-form-button">Ingresar</button>
            <a href="<?= base_url() ?>Admin/Register" class="bs-btn bs-btn-secondary">Registro</a>
        </div>
    </form>
</section>
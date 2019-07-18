<section class="bs-fix-section bs-flex-center-wrapper bs-super-wrapper">
    <form class="bs-form bs-d-block bs-register-form" id="bs-send-form">
        <div class="bs-form-group">
            <label for="username">Usuario</label>
            <input type="text" class="bs-form-input" placeholder="Username" name="username" data-name="Usuario">
        </div>
        <div class="bs-form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="passwordOne" class="bs-form-input" placeholder="Password" name="password" data-name="Contraseña">
        </div>
        <div class="bs-form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="passwordTwo" class="bs-form-input" placeholder="Password" name="password" data-name="Contraseña 2">
        </div>
        <div class="bs-form-group">
            <label for="email">Email</label>
            <input type="email" class="bs-form-input" placeholder="Email" name="email" data-name="Correo electronico">
        </div>
        <div class="bs-form-btn-group">
            <button class="bs-btn bs-btn-primary" id="bs-send-form-button">Registrar</button>
            <a href="<?= base_url() ?>Admin" class="bs-btn bs-btn-secondary">Ingresar</a>
        </div>
    </form>
</section>
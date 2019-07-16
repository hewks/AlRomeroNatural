<div class="hw-full-page-container hw-total-center-container hw-sm-mt-20 hw-sm-mb-50">
    <div class="hw-flex-column hw-row-col-50">
        <div class="hw-form-selector">
            <button class="hw-btn-form-selector <?= $login_btn ?>" data-form="hw-login-form">Ingreso</button>
            <button class="hw-btn-form-selector <?= $register_btn ?>" data-form="hw-register-form">Registro</button>
        </div>
        <form class="hw-theme-user-form <?= $login ?>" id="hw-login-form">
            <div class="hw-form-group">
                <input type="email" name="email" class="hw-form-input" data-name="Correo Electronico" placeholder="Correo Electronico" require>
            </div>
            <div class="hw-form-group">
                <input type="password" name="password" class="hw-form-input" data-name="Contraseña" placeholder="Contraseña" require>
            </div>
            <button class="hw-btn hw-btn-login">Ingresar</button>
        </form>
        <form class="hw-theme-user-form <?= $register ?>" id="hw-register-form">
            <div class="hw-form-group">
                <input type="email" name="email" class="hw-form-input" data-name="Correo Electronico" placeholder="Correo Electronico" require>
            </div>
            <div class="hw-form-group">
                <input type="text" name="username" class="hw-form-input" data-name="Nombre de usuario" placeholder="Nombre de usuario" require>
            </div>
            <div class="hw-form-group">
                <input type="password" name="password" class="hw-form-input" data-name="Contraseña" placeholder="Contraseña" require>
            </div>
            <div class="hw-form-group">
                <input type="password" name="password_2" class="hw-form-input" data-name="Contraseña" placeholder="Contraseña" require>
            </div>
            <div class="hw-form-group">
                <input type="text" name="name" class="hw-form-input" data-name="Nombre" placeholder="Nombre" require>
            </div>
            <div class="hw-form-group">
                <input type="text" name="lastname" class="hw-form-input" data-name="Apellido" placeholder="Apellido" require>
            </div>
            <button class="hw-btn">Registrar</button>
        </form>
    </div>
</div>
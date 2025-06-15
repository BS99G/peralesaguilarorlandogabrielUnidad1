<div class="login-container">
    <div id="loginAlert" class="alert alert-error mb-6 hidden">
        <div class="alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div id="loginAlertMessage">Correo electrónico o contraseña incorrectos.</div>
    </div>

    <form id="loginForm" class="login-form glow-border max-w-md mx-auto w-full">
        <div class="login-header text-center">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#ff0033] to-[#cc0022] flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold">Bienvenido de nuevo</h3>
            <p class="text-gray-400">Ingresa tus credenciales para acceder</p>
        </div>

        <!-- Campo de correo electrónico -->
        <div class="form-group mt-6">
            <label for="email" class="block mb-2">Correo Electrónico</label>
            <div class="relative">
                <input type="email" id="email" name="email" class="cyber-input w-full pl-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
        </div>

        <!-- Campo de contraseña -->
        <div class="form-group mt-4">
            <label for="password" class="block mb-2">Contraseña</label>
            <div class="relative">
                <input type="password" id="password" name="password" class="cyber-input w-full pl-10 pr-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                <span class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer" onclick="togglePasswordVisibility('password', 'passwordToggle')">
                    <i class="fas fa-eye" id="passwordToggle"></i>
                </span>
            </div>
        </div>

        <!-- Opciones adicionales -->
        <div class="flex justify-end items-center mb-6 mt-4">
            <a href="recovery.php" class="text-[#ff0033] hover:text-white text-sm">¿Olvidaste tu contraseña?</a>
        </div>


        <!-- Botón de envío -->
        <button type="submit" class="cyber-btn w-full pulse-btn" id="loginButton">
            <i class="fas fa-sign-in-alt mr-2"></i> Iniciar Sesión
        </button>

        <!-- Enlace para registro -->
        <div class="login-footer mt-6 text-center">
            <p class="text-gray-400">¿No tienes una cuenta? <a href="register.php" class="text-[#ff0033] hover:text-white">Regístrate ahora</a></p>
        </div>
    </form>
</div>

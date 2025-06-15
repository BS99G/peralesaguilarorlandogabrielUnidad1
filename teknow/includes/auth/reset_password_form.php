<div class="register-container">
    <!-- Mensaje de error global (inicialmente oculto) -->
    <div id="resetError" class="text-red-600 mb-6 hidden"></div>

    <!-- Formulario de restablecimiento -->
    <form id="resetPasswordForm" class="register-form glow-border">
        <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

        <div class="register-header">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#ff0033] to-[#cc0022] flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-white">Restablecer contraseña</h3>
            <p class="text-gray-400">Introduce tu nueva contraseña para continuar</p>
        </div>

        <!-- Nueva contraseña -->
        <div class="form-group">
            <label for="new_password" class="block mb-2 text-white">Nueva contraseña</label>
            <div class="relative">
                <input type="password" id="new_password" name="new_password" class="cyber-input pl-10 pr-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                <span class="password-toggle" onclick="togglePasswordVisibility('new_password', 'eye1')">
                    <i class="fas fa-eye" id="eye1"></i>
                </span>
            </div>

            <!-- Requisitos de contraseña -->
            <div class="password-requirements mt-3">
                <p class="mb-2 text-gray-300">La contraseña debe contener:</p>
                <div class="requirement" id="length">
                    <i class="fas fa-circle"></i>
                    <span>Al menos 8 caracteres</span>
                </div>
                <div class="requirement" id="uppercase">
                    <i class="fas fa-circle"></i>
                    <span>Al menos una letra mayúscula</span>
                </div>
                <div class="requirement" id="lowercase">
                    <i class="fas fa-circle"></i>
                    <span>Al menos una letra minúscula</span>
                </div>
                <div class="requirement" id="number">
                    <i class="fas fa-circle"></i>
                    <span>Al menos un número</span>
                </div>
                <div class="requirement" id="special">
                    <i class="fas fa-circle"></i>
                    <span>Al menos un carácter especial (!@#$%^&*)</span>
                </div>
            </div>
        </div>

        <!-- Confirmar contraseña -->
        <div class="form-group">
            <label for="confirm_password" class="block mb-2 text-white">Confirmar contraseña</label>
            <div class="relative">
                <input type="password" id="confirm_password" name="confirm_password" class="cyber-input pl-10 pr-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                <span class="password-toggle" onclick="togglePasswordVisibility('confirm_password', 'eye2')">
                    <i class="fas fa-eye" id="eye2"></i>
                </span>
            </div>
        </div>

        <!-- Botón de envío -->
        <button type="submit" class="cyber-btn w-full pulse-btn">
            <i class="fas fa-key mr-2"></i> Cambiar contraseña
        </button>

        <!-- Mensaje de redirección (opcional si lo deseas en JS) -->
        <div id="resetSuccess" class="alert alert-success mt-6 hidden text-center">
            <i class="fas fa-check-circle mr-2"></i>
            Contraseña actualizada correctamente. Redirigiendo...
        </div>
    </form>
</div>

<div class="login-container max-w-md mx-auto">
    <form id="recoveryForm" class="login-form glow-border">
        <div class="login-header text-center">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#ff0033] to-[#cc0022] flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-key text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold">¿Olvidaste tu contraseña?</h3>
            <p class="text-gray-400">Ingresa tu correo para recibir instrucciones</p>
        </div>

        <div class="form-group mt-6">
            <label for="recoveryEmail" class="block mb-2">Correo Electrónico</label>
            <div class="relative">
                <input type="email" id="recoveryEmail" name="recoveryEmail" class="cyber-input w-full pl-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="cyber-btn w-full pulse-btn mt-6" id="recoveryButton">
            <i class="fas fa-paper-plane mr-2"></i> Enviar Enlace
        </button>

        <div id="recoveryMessage" class="text-center mt-4 text-sm font-medium"></div>

        <div class="login-footer mt-6 text-center">
            <p class="text-gray-400">¿Ya tienes una cuenta? <a href="login.php" class="text-[#ff0033] hover:text-white">Inicia sesión</a></p>
        </div>
    </form>
</div>

<script src="assets/js/recovery.js"></script>

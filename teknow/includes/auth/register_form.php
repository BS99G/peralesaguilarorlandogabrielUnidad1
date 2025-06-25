<div class="register-container">
    <!-- Mensaje de éxito (inicialmente oculto) -->
    <div id="registerSuccess" class="alert alert-success mb-6 hidden">
        <div class="alert-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div>¡Registro exitoso! Redirigiendo al inicio de sesión...</div>
    </div>
    
    <!-- Mensaje de error global (inicialmente oculto) -->
    <div id="registerError" class="text-red-600 mb-6 hidden"></div>
    
    <!-- Formulario -->
    <form id="registerForm" class="register-form glow-border" novalidate>
        <div class="register-header">
            <div class="w-20 h-20 rounded-full bg-gradient-to-br from-[#ff0033] to-[#cc0022] flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-user-plus text-3xl text-white"></i>
            </div>
            <h3 class="text-2xl font-bold text-white">Crear una cuenta</h3>
            <p class="text-gray-400">Únete a la comunidad de NexusGaming</p>
        </div>
        
        <!-- Campos del formulario -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nombre -->
            <div class="form-group">
                <label for="firstName" class="block mb-2 text-white">Nombre</label>
                <div class="relative">
                    <input type="text" id="firstName" name="firstName" class="cyber-input pl-10" required>
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                <div id="firstNameError" class="text-[#ff0033] text-sm mt-1 hidden"></div>
            </div>
            
            <!-- Apellido -->
            <div class="form-group">
                <label for="lastName" class="block mb-2 text-white">Apellido</label>
                <div class="relative">
                    <input type="text" id="lastName" name="lastName" class="cyber-input pl-10" required>
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
                <div id="lastNameError" class="text-[#ff0033] text-sm mt-1 hidden"></div>
            </div>
        </div>
        
        <!-- Nombre de usuario -->
        <div class="form-group">
            <label for="username" class="block mb-2 text-white">Nombre de usuario</label>
            <div class="relative">
                <input type="text" id="username" name="username" class="cyber-input pl-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-user-tag"></i>
                </span>
            </div>
            <div id="usernameError" class="text-[#ff0033] text-sm mt-1 hidden"></div>
        </div>
        
        <!-- Correo electrónico -->
        <div class="form-group">
            <label for="email" class="block mb-2 text-white">Correo electrónico</label>
            <div class="relative">
                <input type="email" id="email" name="email" class="cyber-input pl-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
            <div id="emailError" class="text-[#ff0033] text-sm mt-1 hidden"></div>
        </div>
        
        <!-- Contraseña -->
        <div class="form-group">
            <label for="password" class="block mb-2 text-white">Contraseña</label>
            <div class="relative">
                <input type="password" id="password" name="password" class="cyber-input pl-10 pr-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                <span class="password-toggle" onclick="togglePasswordVisibility('password', 'passwordToggle')">
                    <i class="fas fa-eye" id="passwordToggle"></i>
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
            <label for="confirmPassword" class="block mb-2 text-white">Confirmar contraseña</label>
            <div class="relative">
                <input type="password" id="confirmPassword" name="confirmPassword" class="cyber-input pl-10 pr-10" required>
                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                    <i class="fas fa-lock"></i>
                </span>
                <span class="password-toggle" onclick="togglePasswordVisibility('confirmPassword', 'confirmPasswordToggle')">
                    <i class="fas fa-eye" id="confirmPasswordToggle"></i>
                </span>
            </div>
            <div id="confirmPasswordError" class="text-[#ff0033] text-sm mt-1 hidden"></div>
        </div>

        <button
                type="submit"
                class="cyber-btn w-full pulse-btn g-recaptcha"
                id="registerButton"
                data-sitekey=""
                data-callback="onSubmit"
                data-action="submit"
            >
                <i class="fas fa-user-plus mr-2"></i> Crear cuenta
            </button>
        
        <!-- Enlace para inicio de sesión -->
        <div class="register-footer">
            <p class="text-gray-400">¿Ya tienes una cuenta? <a href="login.html" class="text-[#ff0033] hover:underline">Inicia sesión</a></p>
        </div>
    </form>
</div>

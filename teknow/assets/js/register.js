// Configuración de Tailwind para temas
tailwind.config = {
    theme: {
        extend: {
            colors: {
                'neon-red': '#ff0033',
                'neon-red-dark': '#cc0022',
                'neon-red-light': '#ff3355',
                'dark-bg': '#0a0a0a',
                'darker-bg': '#050505',
                'medium-bg': '#121212',
                'light-bg': '#1a1a1a',
            }
        }
    }
}

// Función para alternar la visibilidad de la contraseña
function togglePasswordVisibility(inputId, toggleId) {
    const passwordInput = document.getElementById(inputId);
    const toggleIcon = document.getElementById(toggleId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}

// Funciones para mostrar/ocultar error
function showError(elementId, message) {
    const errorElement = document.getElementById(elementId + 'Error');
    errorElement.textContent = message;
    errorElement.classList.remove('hidden');
    document.getElementById(elementId).classList.add('border-[#ff0033]');
}
function hideError(elementId) {
    const errorElement = document.getElementById(elementId + 'Error');
    errorElement.classList.add('hidden');
    document.getElementById(elementId).classList.remove('border-[#ff0033]');
}

// Validación de email
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Validación de contraseña
function validatePassword(password) {
    const minLength = password.length >= 8;
    const hasUppercase = /[A-Z]/.test(password);
    const hasLowercase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecial = /[!@#$%^&*]/.test(password);
    
    return {
        length: minLength,
        uppercase: hasUppercase,
        lowercase: hasLowercase,
        number: hasNumber,
        special: hasSpecial,
        isValid: minLength && hasUppercase && hasLowercase && hasNumber && hasSpecial
    };
}

// Actualizar indicadores de requisitos
function updatePasswordRequirements(password) {
    const validation = validatePassword(password);
    const requirements = ['length', 'uppercase', 'lowercase', 'number', 'special'];
    
    requirements.forEach(req => {
        const element = document.getElementById(req);
        if (validation[req]) {
            element.classList.add('valid');
            element.classList.remove('invalid');
            element.querySelector('i').classList.remove('fa-circle');
            element.querySelector('i').classList.add('fa-check-circle');
        } else {
            element.classList.add('invalid');
            element.classList.remove('valid');
            element.querySelector('i').classList.remove('fa-check-circle');
            element.querySelector('i').classList.add('fa-circle');
        }
    });
    
    return validation.isValid;
}

// Validación completa del formulario (sin reCAPTCHA)
function validateForm() {
    let isValid = true;
    
    // Nombre
    const firstName = document.getElementById('firstName').value.trim();
    if (firstName === '') {
        showError('firstName', 'El nombre es obligatorio');
        isValid = false;
    } else {
        hideError('firstName');
    }
    
    // Apellido
    const lastName = document.getElementById('lastName').value.trim();
    if (lastName === '') {
        showError('lastName', 'El apellido es obligatorio');
        isValid = false;
    } else {
        hideError('lastName');
    }
    
    // Usuario
    const username = document.getElementById('username').value.trim();
    if (username === '') {
        showError('username', 'El nombre de usuario es obligatorio');
        isValid = false;
    } else if (username.length < 4) {
        showError('username', 'El nombre de usuario debe tener al menos 4 caracteres');
        isValid = false;
    } else {
        hideError('username');
    }
    
    // Email
    const email = document.getElementById('email').value.trim();
    if (email === '') {
        showError('email', 'El correo electrónico es obligatorio');
        isValid = false;
    } else if (!isValidEmail(email)) {
        showError('email', 'Ingresa un correo electrónico válido');
        isValid = false;
    } else {
        hideError('email');
    }
    
    // Contraseña
    const password = document.getElementById('password').value;
    const passwordValid = updatePasswordRequirements(password);
    if (!passwordValid) {
        isValid = false;
    }
    
    // Confirmar contraseña
    const confirmPassword = document.getElementById('confirmPassword').value;
    if (confirmPassword === '') {
        showError('confirmPassword', 'Confirma tu contraseña');
        isValid = false;
    } else if (confirmPassword !== password) {
        showError('confirmPassword', 'Las contraseñas no coinciden');
        isValid = false;
    } else {
        hideError('confirmPassword');
    }
    
    return isValid;
}

// Función que se llama cuando reCAPTCHA devuelve el token
async function onSubmit(token) {
    // Primero valida el formulario completo
    if (!validateForm()) {
        // Si hay errores, no enviamos el formulario ni el token
        return;
    }

    // Ocultar mensajes anteriores
    const successMessage = document.getElementById('registerSuccess');
    const errorMessage = document.getElementById('registerError');
    successMessage.classList.add('hidden');
    errorMessage.classList.add('hidden');

    // Preparar datos para enviar, incluyendo el token reCAPTCHA
    const data = {
        firstName: document.getElementById('firstName').value.trim(),
        lastName: document.getElementById('lastName').value.trim(),
        username: document.getElementById('username').value.trim(),
        email: document.getElementById('email').value.trim(),
        password: document.getElementById('password').value,
        confirmPassword: document.getElementById('confirmPassword').value,
        recaptchaToken: token  // <== token enviado al backend para validar
    };

    try {
        const response = await fetch('includes/auth/process_register.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(data)
        });
        const result = await response.json();

        if (result.success) {
            successMessage.textContent = result.message;
            successMessage.classList.remove('hidden');
            errorMessage.classList.add('hidden');
            document.getElementById('registerForm').reset();
            // Redirigir después de 3 segundos
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 3000);
        } else {
            errorMessage.textContent = result.message;
            errorMessage.classList.remove('hidden');
            successMessage.classList.add('hidden');
        }
    } catch (error) {
        errorMessage.textContent = 'Error inesperado. Intenta más tarde.';
        errorMessage.classList.remove('hidden');
        successMessage.classList.add('hidden');
        console.error('Error en registro:', error);
    }
}

// Configurar eventos cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', function() {
    // Validación en tiempo real
    const formInputs = ['firstName', 'lastName', 'username', 'email', 'password', 'confirmPassword'];
    formInputs.forEach(inputId => {
        document.getElementById(inputId).addEventListener('input', validateForm);
    });

    // Validación contraseña
    document.getElementById('password').addEventListener('input', function() {
        updatePasswordRequirements(this.value);
        validateForm();
    });

    // No necesitamos capturar evento submit, porque se hace con reCAPTCHA y el callback onSubmit
});

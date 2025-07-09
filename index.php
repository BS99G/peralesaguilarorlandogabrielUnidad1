<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Encuestas Estudiantiles</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --olive-green: #556B2F;
            --royal-blue: #1E3A8A;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23556b2f' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .btn-primary {
            background-color: var(--royal-blue);
            color: white;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #2d4eaa;
            transform: translateY(-2px);
        }
        
        .header-bg {
            background-color: var(--royal-blue);
        }
        
        .form-container {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .radio-container input[type="radio"] {
            display: none;
        }
        
        .radio-container label {
            display: inline-block;
            background-color: #f0f0f0;
            border: 2px solid #ddd;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-align: center;
        }
        
        .radio-container input[type="radio"]:checked + label {
            background-color: var(--olive-green);
            border-color: var(--olive-green);
            color: white;
        }
        
        .question-section {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }
        
        .question-section:last-of-type {
            border-bottom: none;
            padding-bottom: 0;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes highlight {
            0% { background-color: transparent; }
            50% { background-color: rgba(239, 68, 68, 0.1); }
            100% { background-color: transparent; }
        }
        
        .question-highlight {
            animation: highlight 1s ease;
        }
        
        .school-icon {
            color: var(--olive-green);
        }
        
        .survey-container {
            animation: fadeIn 0.5s;
        }
        
        .login-step {
            transition: all 0.3s ease;
        }
        
        .login-step.hidden {
            display: none;
        }
        
        .login-step.active {
            display: block;
            animation: fadeIn 0.5s;
        }
        
        .lock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(255, 255, 255, 0.9);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border-radius: 0.5rem;
        }
        
        .validation-alert {
            position: sticky;
            top: 0;
            z-index: 20;
            margin-bottom: 1rem;
            animation: fadeIn 0.3s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .unanswered {
            border-left: 3px solid #ef4444;
            padding-left: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="header-bg text-white py-3 shadow-md">
            <div class="container mx-auto px-4 flex justify-between items-center">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7" />
                    </svg>
                    <h1 class="text-xl font-bold">Instituto Tecnológico Superior</h1>
                </div>
                <div class="hidden md:block">
                    <div class="text-sm">Sistema de Encuestas</div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 py-6">
            <!-- Login Form -->
            <div id="login-container" class="max-w-md mx-auto bg-white rounded-lg form-container p-6 relative">
                <div class="text-center mb-6">
                    <div class="inline-block p-3 rounded-full bg-blue-50 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 school-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Acceso a Encuestas</h2>
                    <p class="text-gray-600 text-sm mt-1">Ingresa tus credenciales para continuar</p>
                </div>
                
                <form id="login-form" class="space-y-4">
                    <!-- Step 1: Matricula Verification -->
                    <div id="step-matricula" class="login-step active">
                        <div>
                            <label for="matricula" class="block text-sm font-medium text-gray-700 mb-1">Matrícula</label>
                            <input type="text" id="matricula" name="matricula" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ej: E-IT10023" required>
                            <p id="matricula-error" class="mt-1 text-sm text-red-600 hidden">Matrícula no válida</p>
                        </div>
                        
                        <div class="mt-4">
                            <button type="button" id="verify-matricula" class="w-full btn-primary py-2 px-4 rounded-md font-medium text-sm">
                                Continuar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Password Entry -->
                    <div id="step-password" class="login-step hidden">
                        <div class="mb-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Matrícula:</span>
                                <span id="verified-matricula" class="text-sm font-semibold text-gray-800"></span>
                            </div>
                        </div>
                        
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ingresa tu contraseña" required>
                                <button type="button" id="toggle-password" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <p id="password-error" class="mt-1 text-sm text-red-600 hidden">Contraseña incorrecta</p>
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" id="login-button" class="w-full btn-primary py-2 px-4 rounded-md font-medium text-sm">
                                Iniciar Sesión
                            </button>
                        </div>
                        
                        <div class="mt-3 text-center">
                            <button type="button" id="back-to-matricula" class="text-xs text-blue-600 hover:underline">
                                Regresar
                            </button>
                        </div>
                    </div>
                    
                    <!-- Login Attempts Lockout -->
                    <div id="login-lockout" class="lock-overlay hidden">
                        <div class="text-center p-4">
                            <div class="inline-block p-3 rounded-full bg-red-100 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Cuenta bloqueada temporalmente</h3>
                            <p class="text-gray-600 mb-2 text-sm">Demasiados intentos fallidos. Por favor espera:</p>
                            <div class="text-xl font-bold text-red-600 mb-3" id="lockout-timer">02:00:00</div>
                            <p class="text-xs text-gray-500">Por razones de seguridad, tu cuenta ha sido bloqueada temporalmente.</p>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Survey Form - Compact version -->
            <div id="survey-container" class="max-w-2xl mx-auto bg-white rounded-lg form-container p-6 hidden survey-container">
                <div id="validation-alert" class="validation-alert bg-red-100 border-l-4 border-red-500 p-4 rounded-md hidden">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700" id="validation-message">
                                Por favor responde todas las preguntas antes de enviar.
                            </p>
                        </div>
                        <div class="ml-auto pl-3">
                            <div class="-mx-1.5 -my-1.5">
                                <button id="close-alert" type="button" class="inline-flex rounded-md p-1.5 text-red-500 hover:bg-red-200 focus:outline-none">
                                    <span class="sr-only">Cerrar</span>
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-lg font-bold text-gray-800">Encuesta de Satisfacción</h2>
                        <div class="text-xs text-gray-500" id="student-id-display"></div>
                    </div>
                    <p class="text-gray-600 text-sm">Por favor responde todas las preguntas para ayudarnos a mejorar.</p>
                </div>
                
                <form id="survey-form" class="space-y-4">
                    <!-- Question 1 -->
                    <div id="q1-section" class="question-section">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">1. Calidad de la enseñanza en tu carrera</h3>
                        <div class="grid grid-cols-5 gap-1">
                            <div class="radio-container">
                                <input type="radio" name="q1" id="q1-1" value="1" required>
                                <label for="q1-1" class="w-full text-xs">Muy mala</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q1" id="q1-2" value="2">
                                <label for="q1-2" class="w-full text-xs">Mala</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q1" id="q1-3" value="3">
                                <label for="q1-3" class="w-full text-xs">Regular</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q1" id="q1-4" value="4">
                                <label for="q1-4" class="w-full text-xs">Buena</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q1" id="q1-5" value="5">
                                <label for="q1-5" class="w-full text-xs">Excelente</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 2 -->
                    <div id="q2-section" class="question-section">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">2. Satisfacción con las instalaciones del campus</h3>
                        <div class="grid grid-cols-5 gap-1">
                            <div class="radio-container">
                                <input type="radio" name="q2" id="q2-1" value="1" required>
                                <label for="q2-1" class="w-full text-xs">Muy baja</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q2" id="q2-2" value="2">
                                <label for="q2-2" class="w-full text-xs">Baja</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q2" id="q2-3" value="3">
                                <label for="q2-3" class="w-full text-xs">Neutral</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q2" id="q2-4" value="4">
                                <label for="q2-4" class="w-full text-xs">Alta</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q2" id="q2-5" value="5">
                                <label for="q2-5" class="w-full text-xs">Muy alta</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 3 -->
                    <div id="q3-section" class="question-section">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">3. Frecuencia de uso de recursos de biblioteca</h3>
                        <div class="grid grid-cols-5 gap-1">
                            <div class="radio-container">
                                <input type="radio" name="q3" id="q3-1" value="1" required>
                                <label for="q3-1" class="w-full text-xs">Nunca</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q3" id="q3-2" value="2">
                                <label for="q3-2" class="w-full text-xs">Raramente</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q3" id="q3-3" value="3">
                                <label for="q3-3" class="w-full text-xs">A veces</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q3" id="q3-4" value="4">
                                <label for="q3-4" class="w-full text-xs">Frecuente</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q3" id="q3-5" value="5">
                                <label for="q3-5" class="w-full text-xs">Muy frec.</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 4 -->
                    <div id="q4-section" class="question-section">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">4. Evaluación del apoyo académico recibido</h3>
                        <div class="grid grid-cols-5 gap-1">
                            <div class="radio-container">
                                <input type="radio" name="q4" id="q4-1" value="1" required>
                                <label for="q4-1" class="w-full text-xs">Muy malo</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q4" id="q4-2" value="2">
                                <label for="q4-2" class="w-full text-xs">Malo</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q4" id="q4-3" value="3">
                                <label for="q4-3" class="w-full text-xs">Regular</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q4" id="q4-4" value="4">
                                <label for="q4-4" class="w-full text-xs">Bueno</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q4" id="q4-5" value="5">
                                <label for="q4-5" class="w-full text-xs">Excelente</label>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Question 5 -->
                    <div id="q5-section" class="question-section">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">5. ¿Recomendarías esta institución a otros estudiantes?</h3>
                        <div class="grid grid-cols-5 gap-1">
                            <div class="radio-container">
                                <input type="radio" name="q5" id="q5-1" value="1" required>
                                <label for="q5-1" class="w-full text-xs">Def. no</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q5" id="q5-2" value="2">
                                <label for="q5-2" class="w-full text-xs">Prob. no</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q5" id="q5-3" value="3">
                                <label for="q5-3" class="w-full text-xs">Tal vez</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q5" id="q5-4" value="4">
                                <label for="q5-4" class="w-full text-xs">Prob. sí</label>
                            </div>
                            <div class="radio-container">
                                <input type="radio" name="q5" id="q5-5" value="5">
                                <label for="q5-5" class="w-full text-xs">Def. sí</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full btn-primary py-2 px-4 rounded-md font-medium text-sm">
                            Enviar encuesta
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Thank You Message -->
            <div id="thank-you-container" class="max-w-md mx-auto bg-white rounded-lg form-container p-6 text-center hidden">
                <div class="inline-block p-3 rounded-full bg-green-100 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800 mb-1">¡Gracias por tu participación!</h2>
                <p class="text-gray-600 mb-4 text-sm">Tus respuestas han sido registradas correctamente.</p>
                <div class="flex justify-center">
                    <div class="inline-block">
                        <div class="loader flex items-center justify-center space-x-2 mb-2">
                            <div class="w-3 h-3 bg-blue-600 rounded-full animate-pulse"></div>
                            <div class="w-3 h-3 bg-blue-600 rounded-full animate-pulse delay-75"></div>
                            <div class="w-3 h-3 bg-blue-600 rounded-full animate-pulse delay-150"></div>
                        </div>
                        <p class="text-xs text-gray-500">Cerrando sesión automáticamente...</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-3 mt-auto">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-2 md:mb-0">
                        <p class="text-sm">&copy; 2023 Instituto Tecnológico Superior</p>
                    </div>
                    <div class="flex space-x-4">
                        <a href="#" class="text-xs hover:text-gray-300 transition">Privacidad</a>
                        <a href="#" class="text-xs hover:text-gray-300 transition">Términos</a>
                        <a href="#" class="text-xs hover:text-gray-300 transition">Contacto</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Login form elements
            const loginForm = document.getElementById('login-form');
            const matriculaInput = document.getElementById('matricula');
            const matriculaError = document.getElementById('matricula-error');
            const verifyMatriculaBtn = document.getElementById('verify-matricula');
            const stepMatricula = document.getElementById('step-matricula');
            const stepPassword = document.getElementById('step-password');
            const verifiedMatricula = document.getElementById('verified-matricula');
            const passwordInput = document.getElementById('password');
            const passwordError = document.getElementById('password-error');
            const togglePasswordBtn = document.getElementById('toggle-password');
            const backToMatriculaBtn = document.getElementById('back-to-matricula');
            const loginLockout = document.getElementById('login-lockout');
            const lockoutTimer = document.getElementById('lockout-timer');
            
            // Survey elements
            const loginContainer = document.getElementById('login-container');
            const surveyContainer = document.getElementById('survey-container');
            const studentIdDisplay = document.getElementById('student-id-display');
            const surveyForm = document.getElementById('survey-form');
            const thankYouContainer = document.getElementById('thank-you-container');
            const validationAlert = document.getElementById('validation-alert');
            const validationMessage = document.getElementById('validation-message');
            const closeAlertBtn = document.getElementById('close-alert');
            
            // Login attempts tracking
            let loginAttempts = 0;
            const maxLoginAttempts = 3;
            let lockoutTime = 7200; // 2 hours in seconds (2 * 60 * 60)
            let lockoutInterval;
            
            // Valid credentials (in a real app, this would be checked against a database)
            // This is just for demonstration purposes
            const validCredentials = {
                'E-IT10023': 'Aprobad0!',
                'E-IT20045': 'Segur0!',
                'E-IT30067': 'Acces0!'
            };
            
            // Step 1: Matricula verification
            verifyMatriculaBtn.addEventListener('click', function() {
                const matricula = matriculaInput.value.trim();
                const matriculaRegex = /^E-IT\d{5}$/;
                
                // Reset error message
                matriculaError.classList.add('hidden');
                
                if (!matriculaRegex.test(matricula)) {
                    matriculaError.textContent = "Formato incorrecto. Debe ser como E-IT10023";
                    matriculaError.classList.remove('hidden');
                    matriculaInput.classList.add('border-red-500');
                    return;
                }
                
                // Check if matricula exists in our valid credentials
                if (!(matricula in validCredentials)) {
                    matriculaError.textContent = "Matrícula no encontrada en el sistema";
                    matriculaError.classList.remove('hidden');
                    matriculaInput.classList.add('border-red-500');
                    return;
                }
                
                // Move to password step
                matriculaInput.classList.remove('border-red-500');
                stepMatricula.classList.remove('active');
                stepMatricula.classList.add('hidden');
                stepPassword.classList.remove('hidden');
                stepPassword.classList.add('active');
                
                // Display verified matricula
                verifiedMatricula.textContent = matricula;
                
                // Focus on password field
                passwordInput.focus();
            });
            
            // Back to matricula step
            backToMatriculaBtn.addEventListener('click', function() {
                stepPassword.classList.remove('active');
                stepPassword.classList.add('hidden');
                stepMatricula.classList.remove('hidden');
                stepMatricula.classList.add('active');
                
                // Reset password field
                passwordInput.value = '';
                passwordError.classList.add('hidden');
            });
            
            // Toggle password visibility
            togglePasswordBtn.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Change icon based on password visibility
                if (type === 'text') {
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    `;
                } else {
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    `;
                }
            });
            
            // Reset error on password input
            passwordInput.addEventListener('input', function() {
                passwordError.classList.add('hidden');
            });
            
            // Login form submission
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get matricula and password
                const matricula = verifiedMatricula.textContent;
                const password = passwordInput.value;
                
                // Check if account is locked
                if (loginAttempts >= maxLoginAttempts) {
                    showLockout();
                    return;
                }
                
                // Check if credentials are valid
                if (validCredentials[matricula] !== password) {
                    passwordError.textContent = "Credenciales incorrectas";
                    passwordError.classList.remove('hidden');
                    loginAttempts++;
                    
                    if (loginAttempts >= maxLoginAttempts) {
                        showLockout();
                    }
                    
                    return;
                }
                
                // Reset login attempts on successful login
                loginAttempts = 0;
                
                // Display student ID in the survey
                studentIdDisplay.textContent = `Matrícula: ${matricula}`;
                
                // Hide login, show survey
                loginContainer.classList.add('hidden');
                surveyContainer.classList.remove('hidden');
                
                // Reset form fields
                loginForm.reset();
                passwordError.classList.add('hidden');
                
                // Reset to matricula step for next login
                stepPassword.classList.remove('active');
                stepPassword.classList.add('hidden');
                stepMatricula.classList.remove('hidden');
                stepMatricula.classList.add('active');
            });
            
            // Show lockout overlay
            function showLockout() {
                loginLockout.classList.remove('hidden');
                
                // Start countdown
                updateLockoutTimer();
                lockoutInterval = setInterval(updateLockoutTimer, 1000);
            }
            
            // Update lockout timer
            function updateLockoutTimer() {
                const hours = Math.floor(lockoutTime / 3600);
                const minutes = Math.floor((lockoutTime % 3600) / 60);
                const seconds = lockoutTime % 60;
                
                // Format time as HH:MM:SS
                lockoutTimer.textContent = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                if (lockoutTime <= 0) {
                    clearInterval(lockoutInterval);
                    loginLockout.classList.add('hidden');
                    loginAttempts = 0;
                    lockoutTime = 7200; // Reset to 2 hours
                } else {
                    lockoutTime--;
                }
            }
            
            // Reset matricula validation on input
            matriculaInput.addEventListener('input', function() {
                matriculaError.classList.add('hidden');
                matriculaInput.classList.remove('border-red-500');
            });
            
            // Close validation alert
            closeAlertBtn.addEventListener('click', function() {
                validationAlert.classList.add('hidden');
            });
            
            // Survey submission with enhanced validation
            surveyForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Check if all questions are answered
                const questions = [1, 2, 3, 4, 5];
                let unansweredQuestions = [];
                
                // Reset all question sections
                questions.forEach(q => {
                    const section = document.getElementById(`q${q}-section`);
                    section.classList.remove('unanswered', 'question-highlight');
                });
                
                // Check each question
                questions.forEach(q => {
                    const answered = document.querySelector(`input[name="q${q}"]:checked`);
                    if (!answered) {
                        unansweredQuestions.push(q);
                    }
                });
                
                // If there are unanswered questions
                if (unansweredQuestions.length > 0) {
                    // Highlight unanswered questions
                    unansweredQuestions.forEach(q => {
                        const section = document.getElementById(`q${q}-section`);
                        section.classList.add('unanswered', 'question-highlight');
                    });
                    
                    // Show validation alert
                    validationMessage.textContent = `Por favor responde ${unansweredQuestions.length} ${unansweredQuestions.length === 1 ? 'pregunta' : 'preguntas'} sin contestar.`;
                    validationAlert.classList.remove('hidden');
                    
                    // Scroll to first unanswered question
                    const firstUnanswered = document.getElementById(`q${unansweredQuestions[0]}-section`);
                    firstUnanswered.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    
                    return;
                }
                
                // Hide validation alert if it was shown
                validationAlert.classList.add('hidden');
                
                // Hide survey, show thank you message
                surveyContainer.classList.add('hidden');
                thankYouContainer.classList.remove('hidden');
                
                // Collect form data (in a real app, this would be sent to a server)
                const formData = new FormData(surveyForm);
                const surveyData = {};
                
                for (const [key, value] of formData.entries()) {
                    surveyData[key] = value;
                }
                
                console.log('Survey submitted:', surveyData);
                
                // Reset the survey form and remove any highlighting
                surveyForm.reset();
                questions.forEach(q => {
                    const section = document.getElementById(`q${q}-section`);
                    section.classList.remove('unanswered', 'question-highlight');
                });
                
                // Automatically redirect to login after 3 seconds
                setTimeout(function() {
                    thankYouContainer.classList.add('hidden');
                    loginContainer.classList.remove('hidden');
                }, 3000);
            });
            
            // Add event listeners to remove highlighting when a question is answered
            questions = [1, 2, 3, 4, 5];
            questions.forEach(q => {
                const radioButtons = document.querySelectorAll(`input[name="q${q}"]`);
                radioButtons.forEach(radio => {
                    radio.addEventListener('change', function() {
                        const section = document.getElementById(`q${q}-section`);
                        section.classList.remove('unanswered');
                        
                        // Check if all questions are now answered
                        const stillUnanswered = questions.filter(qNum => {
                            return !document.querySelector(`input[name="q${qNum}"]:checked`);
                        });
                        
                        // If all questions are answered, hide the alert
                        if (stillUnanswered.length === 0) {
                            validationAlert.classList.add('hidden');
                        } else {
                            // Update the message
                            validationMessage.textContent = `Por favor responde ${stillUnanswered.length} ${stillUnanswered.length === 1 ? 'pregunta' : 'preguntas'} sin contestar.`;
                        }
                    });
                });
            });
        });
    </script>
<script>(function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'959797cae46bda28',t:'MTc1MTU1ODM5Ni4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();</script></body>
</html>

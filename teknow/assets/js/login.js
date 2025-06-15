document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    
    loginForm?.addEventListener('submit', async function (e) {
        e.preventDefault();

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        try {
            const response = await fetch('includes/auth/process_login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password }),
            });

            const result = await response.json();

            if (result.success) {
                showAlert(result.message, false);
                setTimeout(() => window.location.href = 'index.php?page=home', 1500);
            } else {
                showAlert(result.message);
            }

        } catch (err) {
            showAlert("Error al procesar la solicitud.");
        }
    });
});

function showAlert(message, isError = true) {
    const alertBox = document.getElementById('loginAlert');
    const alertMessage = document.getElementById('loginAlertMessage');

    if (alertBox && alertMessage) {
        alertBox.classList.remove('hidden');
        alertMessage.textContent = message;

        if (isError) {
            alertBox.classList.add('alert-error');
        } else {
            alertBox.classList.remove('alert-error');
        }
    }
}

function togglePasswordVisibility(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (input && icon) {
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("resetPasswordForm");

    const requirements = {
        length: document.getElementById("length"),
        uppercase: document.getElementById("uppercase"),
        lowercase: document.getElementById("lowercase"),
        number: document.getElementById("number"),
        special: document.getElementById("special")
    };

    const newPasswordInput = document.getElementById("new_password");

    function validatePasswordRequirements(password) {
        const validations = {
            length: password.length >= 8,
            uppercase: /[A-Z]/.test(password),
            lowercase: /[a-z]/.test(password),
            number: /[0-9]/.test(password),
            special: /[!@#$%^&*]/.test(password)
        };

        for (const key in validations) {
            if (validations[key]) {
                requirements[key].classList.add("text-green-400");
                requirements[key].classList.remove("text-gray-300");
            } else {
                requirements[key].classList.remove("text-green-400");
                requirements[key].classList.add("text-gray-300");
            }
        }
    }

    newPasswordInput.addEventListener("input", () => {
        const password = newPasswordInput.value;
        validatePasswordRequirements(password);
    });

    window.togglePasswordVisibility = function (inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    };

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const token = form.querySelector('input[name="token"]').value;
        const password = form.querySelector('input[name="new_password"]').value;
        const confirmPassword = form.querySelector('input[name="confirm_password"]').value;

        try {
            const response = await fetch("includes/auth/process_reset.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ token, password, confirmPassword })
            });

            const result = await response.json();

            if (result.success) {
                window.location.href = result.redirect;
            } else {
                alert(result.message);
            }
        } catch (error) {
            console.error("Error en fetch:", error);
            alert("Ocurrió un error al procesar la solicitud.");
        }
    });
});

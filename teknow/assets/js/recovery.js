document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('recoveryForm');
  const messageEl = document.getElementById('recoveryMessage');
  const recoveryButton = document.getElementById('recoveryButton');
  const emailInput = document.getElementById('recoveryEmail');

  function enableRecoveryButton() {
    recoveryButton.disabled = false;
    recoveryButton.innerHTML = `<i class="fas fa-paper-plane mr-2"></i> Enviar Enlace`;
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    messageEl.textContent = '';
    messageEl.style.color = '';
    recoveryButton.disabled = true;
    recoveryButton.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> Enviando...`;

    const email = emailInput.value.trim();

    // Validación de formato de correo básico
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email)) {
      messageEl.textContent = 'Por favor, ingresa un correo válido.';
      messageEl.style.color = '#f87171';
      enableRecoveryButton();
      return;
    }

    try {
      const response = await fetch('includes/auth/process_recovery.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ recoveryEmail: email })
      });

      // Verificar si la respuesta es JSON válida
      const contentType = response.headers.get('content-type');
      if (!contentType || !contentType.includes('application/json')) {
        throw new Error('La respuesta no es JSON');
      }

      const text = await response.text();
      console.log('Respuesta cruda del servidor:', text);

      let result;
      try {
        result = JSON.parse(text);
      } catch (error) {
        throw new Error('JSON inválido: ' + text);
      }

      messageEl.textContent = localizeMessage(result.message);
      messageEl.style.color = result.success ? '#4ade80' : '#f87171';
    } catch (error) {
      console.error(localizeMessage('Error en fetch:'), error);
      messageEl.textContent = localizeMessage('Ocurrió un error al enviar el enlace. Inténtalo de nuevo.');
      messageEl.style.color = '#f87171';
    } finally {
      enableRecoveryButton();
    }
  });

  // Ejemplo de función de localización (puedes personalizarla)
  function localizeMessage(message) {
    const messages = {
      'Por favor, ingresa un correo válido.': 'Por favor, ingresa un correo válido.',
      'La respuesta no es JSON': 'La respuesta no es JSON',
      'Error en fetch:': 'Error en fetch:',
      'Ocurrió un error al enviar el enlace. Inténtalo de nuevo.': 'Ocurrió un error al enviar el enlace. Inténtalo de nuevo.'
    };
    return messages[message] || message;
  }
});

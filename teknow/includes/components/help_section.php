<?php
// Preguntas frecuentes reales y profesionales
$faqs = [
    1 => [
        'question' => '¿Cómo puedo recuperar mi contraseña?',
        'answer' => 'Para recuperar tu contraseña, haz clic en "¿Olvidaste tu contraseña?" en la página de login y sigue las instrucciones para restablecerla mediante tu correo electrónico.'
    ],
    2 => [
        'question' => '¿Dónde puedo contactarme con soporte técnico?',
        'answer' => 'Hay una pestaña llamada Contacto, ahi podras enviar un "Ticket" o bien en la burbuja en la ezquina inferior derecha estara el chat para preguntar cualquier cosa.'
    ],
    3 => [
        'question' => '¿Puedo cambiar mi nombre de usuario?',
        'answer' => 'Por razones de seguridad y consistencia, no está permitido cambiar el nombre de usuario una vez creado. Sin embargo, puedes crear un nuevo perfil si deseas otro nombre.'
    ],
    4 => [
        'question' => '¿Cómo puedo actualizar mis datos personales?',
        'answer' => 'Actualmente, la opción para modificar tus datos personales no está disponible. Estamos trabajando para habilitar esta funcionalidad en futuras actualizaciones. Agradecemos tu comprensión.'
    ],
    5 => [
        'question' => '¿Cómo puedo eliminar mi cuenta?',
        'answer' => 'Actualmente no es posible eliminar tu cuenta desde la plataforma. Estamos trabajando para ofrecer esta opción en futuras actualizaciones. Si tienes alguna inquietud, por favor contacta al soporte técnico.'
    ],
];

// Detectar FAQ seleccionada por GET
$selected_id = isset($_GET['topic']) ? (int)$_GET['topic'] : null;
$selected_faq = $selected_id && isset($faqs[$selected_id]) ? $faqs[$selected_id] : null;
?>

<div class="faq-container flex gap-6">
    <!-- Sidebar con preguntas -->
    <aside class="w-1/3 bg-[#121212] rounded-lg p-4">
        <h3 class="text-xl font-bold neon-text-red mb-4">Preguntas Frecuentes</h3>
        <ul>
            <?php foreach ($faqs as $id => $faq): ?>
                <li class="mb-3">
                    <a href="index.php?page=help&topic=<?= $id ?>"
                       class="block px-3 py-2 rounded hover:bg-[#ff0033] hover:text-white transition-colors <?= $selected_id === $id ? 'bg-[#ff0033] text-white' : 'text-[#ff0033]' ?>">
                        <?= htmlspecialchars($faq['question']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Contenido de la respuesta -->
    <section class="w-2/3 bg-[#1a1a1a] rounded-lg p-6 flex flex-col">
        <?php if ($selected_faq): ?>
            <h2 class="text-2xl font-bold neon-text-red mb-4"><?= htmlspecialchars($selected_faq['question']) ?></h2>
            <p class="text-gray-300"><?= nl2br(htmlspecialchars($selected_faq['answer'])) ?></p>
        <?php else: ?>
            <p class="text-gray-400">Selecciona una pregunta del lado izquierdo para ver la respuesta.</p>
        <?php endif; ?>
    </section>
</div>

<style>
.faq-container {
    min-height: 600px;
}
</style>

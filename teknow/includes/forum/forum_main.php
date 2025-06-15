<?php
// Simulación de datos de conversaciones (en un proyecto real esto vendría de BD)
$topics = [
    1 => ['title' => '¿Cuál es tu juego favorito de 2024?', 'messages' => [
        ['user' => 'Ana', 'text' => 'Yo amo Cyberpunk 2078, es una maravilla visual.'],
        ['user' => 'Luis', 'text' => 'Prefiero Eternal Warfare, su modo táctico es brutal.']
    ]],
    2 => ['title' => 'Mejores setups para streaming', 'messages' => [
        ['user' => 'Carlos', 'text' => 'Uso RTX 5090 Ti y CPU i13-13900KS, ¡va de lujo!'],
        ['user' => 'Marta', 'text' => 'Yo recomiendo usar una buena cámara y micrófono.']
    ]],
    3 => ['title' => 'Nuevas tecnologías en hardware gaming', 'messages' => [
        ['user' => 'Elena', 'text' => 'La memoria GDDR7 está cambiando las reglas del juego.'],
        ['user' => 'Pedro', 'text' => 'Sí, y el ray tracing cada vez mejor.']
    ]],
];

// Detectar topic seleccionado via GET
$selected_topic_id = isset($_GET['topic']) ? (int)$_GET['topic'] : null;
$selected_topic = $selected_topic_id && isset($topics[$selected_topic_id]) ? $topics[$selected_topic_id] : null;

// Simulación añadir mensaje (sin persistencia real)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $selected_topic) {
    $new_user = trim($_POST['user'] ?? '');
    $new_text = trim($_POST['message'] ?? '');

    if ($new_user !== '' && $new_text !== '') {
        // Aquí normalmente insertarías a BD, pero vamos a añadir al array para mostrar
        $topics[$selected_topic_id]['messages'][] = ['user' => $new_user, 'text' => $new_text];
        // Actualizamos el tema seleccionado con el nuevo mensaje para mostrarlo
        $selected_topic = $topics[$selected_topic_id];
        // Evitar reenvío al actualizar la página
        header("Location: ?topic=$selected_topic_id");
        exit;
    }
}
?>

<div class="forum-container flex gap-6">
    <!-- Sidebar con temas -->
    <aside class="w-1/3 bg-[#121212] rounded-lg p-4">
        <h3 class="text-xl font-bold neon-text-red mb-4">Conversaciones</h3>
        <ul>
            <?php foreach ($topics as $id => $topic): ?>
                <li class="mb-3">
                    <a href="index.php?page=forum&topic=<?= $id ?>" class="block px-3 py-2 rounded hover:bg-[#ff0033] hover:text-white transition-colors <?= $selected_topic_id === $id ? 'bg-[#ff0033] text-white' : 'text-[#ff0033]' ?>">
                        <?= htmlspecialchars($topic['title']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Contenido del tema -->
    <section class="w-2/3 bg-[#1a1a1a] rounded-lg p-6 flex flex-col">
        <?php if ($selected_topic): ?>
            <h2 class="text-2xl font-bold neon-text-red mb-4"><?= htmlspecialchars($selected_topic['title']) ?></h2>
            <div class="messages space-y-4 text-gray-300 mb-6 overflow-y-auto max-h-[400px]">
                <?php foreach ($selected_topic['messages'] as $msg): ?>
                    <div class="message p-3 bg-[#222] rounded">
                        <strong class="text-[#ff0033]"><?= htmlspecialchars($msg['user']) ?>:</strong>
                        <p><?= htmlspecialchars($msg['text']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Formulario para añadir nuevo mensaje -->
            <form method="POST" class="flex flex-col gap-3">
                <input type="text" name="user" placeholder="Tu nombre" required
                    class="p-2 rounded bg-[#121212] text-white border border-[#ff0033] focus:outline-none focus:ring-2 focus:ring-[#ff0033]" />
                <textarea name="message" rows="3" placeholder="Escribe tu mensaje" required
                    class="p-2 rounded bg-[#121212] text-white border border-[#ff0033] focus:outline-none focus:ring-2 focus:ring-[#ff0033] resize-none"></textarea>
                <button type="submit"
                    class="bg-[#ff0033] hover:bg-[#cc0022] text-white font-bold py-2 rounded transition-colors">Enviar</button>
            </form>
        <?php else: ?>
            <p class="text-gray-400">Selecciona una conversación del sidebar para ver los mensajes.</p>
        <?php endif; ?>
    </section>
</div>

<style>
.forum-container {
    min-height: 600px;
}
</style>

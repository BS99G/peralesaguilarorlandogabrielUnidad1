<?php if (!empty($errorMessage)): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6 max-w-xl mx-auto text-center">
        <?= htmlspecialchars($errorMessage) ?>
    </div>
<?php elseif (!empty($successMessage)): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 max-w-xl mx-auto text-center">
        <?= htmlspecialchars($successMessage) ?>
    </div>
<?php endif; ?>
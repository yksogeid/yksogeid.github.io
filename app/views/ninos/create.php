<?php
$mensaje = isset($mensaje) ? $mensaje : "";
$tipo_mensaje = isset($tipo_mensaje) ? $tipo_mensaje : "";
$old = isset($old) ? $old : [];
$ninos = isset($ninos) ? $ninos : [];
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Registrar Niño - Sistema Navideño">
    <title>Registrar Niño - Navidad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        /* ... (Same styles as original) ... */
        .input-field {
            transition: all 0.3s ease;
            border: 2px solid #e5e7eb;
        }

        .dark .input-field {
            background-color: rgba(75, 85, 99, 0.3);
            border-color: rgba(255, 255, 255, 0.2);
            color: #e5e7eb;
        }

        .input-field:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .dark .input-field:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
        }

        .input-field:hover {
            border-color: #d1d5db;
        }

        .dark .input-field:hover {
            border-color: rgba(255, 255, 255, 0.3);
        }

        .submit-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .submit-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .submit-button:active {
            transform: translateY(0);
        }

        .success-message {
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-wrapper {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .label-text {
            color: #374151;
            font-weight: 600;
        }

        .dark .label-text {
            color: #d1d5db;
        }

        .form-container {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .dark .bg-gradient-to-r {
            opacity: 0.9;
        }
    </style>
</head>

<!-- Back Button -->
<a href="<?= BASE_URL ?>" class="back-button">
    <span>←</span>
    <span>Volver</span>
</a>

<div class="max-w-7xl mx-auto px-4">

    <!-- Header -->
    <div class="text-center mb-10">
        <div class="icon-wrapper w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4 shadow-2xl"
            style="background: linear-gradient(135deg, #c41e3a 0%, #165b33 100%);">
            <span class="text-4xl">🎁</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 drop-shadow-lg"
            style="font-family: 'Mountains of Christmas', cursive; text-shadow: 0 0 20px rgba(196, 30, 58, 0.5);">
            Registrar Niño
        </h1>
        <p class="text-white/90 text-lg font-medium">
            🎄 Añade un nuevo niño al evento navideño 🎅
        </p>
    </div>

    <!-- Success/Error Message (Full Width) -->
    <?php if ($mensaje): ?>
        <div class="max-w-4xl mx-auto glass-card rounded-2xl p-4 mb-8 shadow-xl success-message border-l-4 
                <?php
                if ($tipo_mensaje === 'success')
                    echo 'border-green-500';
                elseif ($tipo_mensaje === 'warning')
                    echo 'border-yellow-500';
                else
                    echo 'border-red-500';
                ?>">
            <p class="font-semibold text-lg text-center
                    <?php
                    if ($tipo_mensaje === 'success')
                        echo 'text-green-700';
                    elseif ($tipo_mensaje === 'warning')
                        echo 'text-yellow-700';
                    else
                        echo 'text-red-700';
                    ?>">
                <?php echo $mensaje; ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
        
        <!-- Left Column: Form -->
        <div class="space-y-6">
            <!-- Quick Stats & Actions -->
            <div class="flex gap-4">
                <div class="glass-card rounded-2xl p-6 shadow-xl flex-1 flex items-center justify-between">
                    <div class="text-white/90 font-medium">Total Registrados</div>
                    <div class="text-white text-4xl font-bold">
                        <?php echo isset($total_ninos) ? $total_ninos : '0'; ?>
                    </div>
                </div>
                
                <a href="<?= BASE_URL ?>ninos/carnets" class="glass-card rounded-2xl p-6 shadow-xl flex-1 flex flex-col items-center justify-center hover:bg-white/10 transition-colors group text-center cursor-pointer border-2 border-transparent hover:border-white/30">
                    <span class="text-2xl mb-1 group-hover:scale-110 transition-transform">🪪</span>
                    <span class="text-white font-bold text-sm">Carnets QR</span>
                </a>
            </div>
            <div class="glass-card rounded-2xl p-8 shadow-2xl form-container relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
                
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                    <span class="text-3xl">📝</span>
                    <span>Nuevo Registro</span>
                </h2>

                <form method="POST" action="<?= BASE_URL ?>ninos/store" class="space-y-6" id="registrationForm">

                    <!-- Nombre completo -->
                    <div>
                        <label class="label-text block text-sm mb-2 flex items-center gap-2">
                            <span class="text-xl">👤</span>
                            <span>Nombre Completo</span>
                        </label>
                        <input type="text" name="nombre" class="input-field w-full rounded-xl px-4 py-3 text-gray-800"
                            placeholder="Ej: Juan Pérez"
                            value="<?php echo isset($old['nombre']) ? htmlspecialchars($old['nombre']) : ''; ?>" required
                            autocomplete="off">
                    </div>

                    <!-- Género -->
                    <div>
                        <label class="label-text block text-sm mb-2 flex items-center gap-2">
                            <span class="text-xl">⚥</span>
                            <span>Género</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="genero" value="M" class="peer sr-only" 
                                    <?php echo (isset($old['genero']) && $old['genero'] === 'M') ? 'checked' : ''; ?> required>
                                <div class="rounded-xl border-2 border-gray-200 dark:border-gray-700 p-3 flex items-center justify-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 text-gray-600 dark:text-gray-300 transition-all">
                                    <span class="text-xl">👦</span>
                                    <span class="font-medium">Niño</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="genero" value="F" class="peer sr-only"
                                    <?php echo (isset($old['genero']) && $old['genero'] === 'F') ? 'checked' : ''; ?>>
                                <div class="rounded-xl border-2 border-gray-200 dark:border-gray-700 p-3 flex items-center justify-center gap-2 hover:bg-gray-50 dark:hover:bg-gray-700/50 peer-checked:border-pink-500 peer-checked:bg-pink-50 dark:peer-checked:bg-pink-900/20 text-gray-600 dark:text-gray-300 transition-all">
                                    <span class="text-xl">👧</span>
                                    <span class="font-medium">Niña</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Edad -->
                    <div>
                        <label class="label-text block text-sm mb-2 flex items-center gap-2">
                            <span class="text-xl">🎂</span>
                            <span>Edad</span>
                        </label>
                        <input type="number" name="edad" class="input-field w-full rounded-xl px-4 py-3 text-gray-800"
                            placeholder="Ej: 8" min="1" max="10"
                            value="<?php echo isset($old['edad']) ? htmlspecialchars($old['edad']) : ''; ?>" required>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-1">Edad entre 1 y 10 años</p>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit"
                            class="submit-button w-full text-white px-6 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl flex items-center justify-center gap-3">
                            <span class="text-xl">✨</span>
                            <span>Registrar</span>
                            <span class="text-xl">✨</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

        <!-- Right Column: List -->
        <div class="glass-card rounded-2xl p-8 shadow-2xl h-full min-h-[500px] flex flex-col">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                <span class="text-3xl">📋</span>
                <span>Listado de Niños</span>
            </h2>
            
            <?php if (empty($ninos)): ?>
                <div class="flex-1 flex flex-col items-center justify-center text-center py-12 text-gray-500 dark:text-gray-400 border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl">
                    <span class="text-4xl mb-3 opacity-50">📭</span>
                    <p>No hay niños registrados aún.</p>
                </div>
            <?php else: ?>
                <div class="overflow-y-auto max-h-[600px] pr-2 custom-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm z-10">
                            <tr class="text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-gray-700">
                                <th class="pb-3 px-4 font-semibold">Nombre</th>
                                <th class="pb-3 px-4 font-semibold text-center">Género</th>
                                <th class="pb-3 px-4 font-semibold text-center">Edad</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <?php foreach ($ninos as $index => $n): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                                    <td class="py-3 px-4 font-medium text-gray-800 dark:text-gray-200">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-purple-200 to-indigo-200 flex items-center justify-center text-purple-700 text-xs font-bold transition-transform group-hover:scale-110">
                                                <?php echo strtoupper(substr($n['nombre_completo'], 0, 1)); ?>
                                            </div>
                                            <div class="flex flex-col">
                                                <span><?php echo htmlspecialchars($n['nombre_completo']); ?></span>
                                                <span class="text-xs text-gray-400 hidden group-hover:inline-block">
                                                    Registro: <?php echo isset($n['created_at']) ? date('d/m/Y', strtotime($n['created_at'])) : date('d/m/Y'); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <?php if (isset($n['genero']) && $n['genero'] === 'M'): ?>
                                            <span class="text-xl" title="Niño">👦</span>
                                        <?php elseif (isset($n['genero']) && $n['genero'] === 'F'): ?>
                                            <span class="text-xl" title="Niña">👧</span>
                                        <?php else: ?>
                                            <span class="text-gray-300">?</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="inline-block px-2 py-1 bg-blue-50 text-blue-600 rounded-md text-sm font-semibold">
                                            <?php echo $n['edad']; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-8 text-white/80">
        <p class="text-sm">Sistema de Registro Navideño 🎄</p>
    </div>

</div>

<!-- Modal de Confirmación -->
<div id="confirmationModal"
    class="fixed inset-0 z-50 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" id="modalOverlay"></div>
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-2xl transform scale-95 transition-transform duration-300 w-full max-w-sm relative z-10 mx-4">
        <div class="text-center">
            <div
                class="w-16 h-16 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">
                ⚠️
            </div>
            <h3 id="modalTitle" class="text-xl font-bold text-gray-900 dark:text-white mb-2">¿Confirmar registro?</h3>
            <p id="modalMessage" class="text-gray-500 dark:text-gray-300 text-sm mb-6">
                Estás a punto de registrar a un nuevo niño. ¿Los datos son correctos?
            </p>
            <div class="flex gap-3 justify-center">
                <button type="button" id="cancelBtn"
                    class="px-5 py-2.5 rounded-xl text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                    Cancelar
                </button>
                <button type="button" id="confirmBtn"
                    class="px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    Sí, Registrar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Include shared controls (theme toggle & music player) -->
<?php include 'app/views/includes/controls.php'; ?>

<!-- Shared JavaScript -->
<script src="<?= BASE_URL ?>assets/js/app.js"></script>

<script>
    // Auto-hide success message after 5 seconds
    <?php if ($tipo_mensaje === 'success'): ?>
        setTimeout(function () {
            const message = document.querySelector('.success-message');
            if (message) {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(() => message.remove(), 500);
            }
        }, 5000);
    <?php endif; ?>

    // Form validation feedback
    const form = document.getElementById('registrationForm');
    const inputs = form.querySelectorAll('input');

    inputs.forEach(input => {
        input.addEventListener('invalid', function (e) {
            e.preventDefault();
            this.classList.add('border-red-500');
        });

        input.addEventListener('input', function () {
            this.classList.remove('border-red-500');
        });
    });

    // Modal Logic
    const modal = document.getElementById('confirmationModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const confirmBtn = document.getElementById('confirmBtn');
    const modalOverlay = document.getElementById('modalOverlay');
    const submitBtn = document.querySelector('button[type="submit"]');

    function toggleModal(show) {
        if (show) {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.querySelector('div.transform').classList.remove('scale-95');
            modal.querySelector('div.transform').classList.add('scale-100');
        } else {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('div.transform').classList.add('scale-95');
            modal.querySelector('div.transform').classList.remove('scale-100');
        }
    }

    // Usamos click en el botón en lugar de submit en el formulario
    submitBtn.addEventListener('click', function (e) {
        e.preventDefault(); // Evitar envío automático

        const invalidInput = form.querySelector('input:invalid');

        if (invalidInput) {
            // Caso Error: Campo inválido
            console.log('❌ Formulario inválido: ' + invalidInput.name);

            let title = '⚠️ Faltan Datos';
            let message = '';

            // Validar restricción de edad específicamente
            if (invalidInput.name === 'edad' && (invalidInput.validity.rangeOverflow || invalidInput.value > 10)) {
                title = '⛔ Edad no permitida';
                message = 'Lo sentimos, esta novena es solo para niños de hasta 10 años. 🎅';
            } else {
                // Mensaje genérico para campos vacíos u otros errores
                const fieldNames = {
                    'nombre': 'Nombre Completo',
                    'edad': 'Edad'
                };
                const fieldLabel = fieldNames[invalidInput.name] || 'información';
                message = `Por favor, asegúrate de llenar el campo: ${fieldLabel}. Es obligatorio o contiene datos inválidos.`;
            }

            // Personalizar Modal para Error
            document.getElementById('modalTitle').textContent = title;
            document.getElementById('modalMessage').textContent = message;

            confirmBtn.style.display = 'none'; // Ocultar botón de confirmar
            cancelBtn.classList.remove('bg-white', 'text-gray-700'); // Estilos base
            cancelBtn.classList.add('bg-blue-500', 'text-white', 'hover:bg-blue-600'); // Resaltar botón de entendido
            cancelBtn.textContent = 'Entendido';

            toggleModal(true);
        } else {
            // Caso Éxito: Todo válido
            console.log('✅ Formulario válido, mostrando modal...');

            // Restablecer Modal para Confirmación
            document.getElementById('modalTitle').textContent = '¿Confirmar registro?';
            document.getElementById('modalMessage').textContent = 'Estás a punto de registrar a un nuevo niño. ¿Los datos son correctos?';

            confirmBtn.style.display = 'block'; // Mostrar botón confirmar

            // Restaurar estilo botón cancelar
            cancelBtn.classList.remove('bg-blue-500', 'text-white', 'hover:bg-blue-600');
            cancelBtn.classList.add('text-gray-700', 'hover:bg-gray-100');
            cancelBtn.textContent = 'Cancelar';

            toggleModal(true);
        }
    });

    cancelBtn.addEventListener('click', () => toggleModal(false));
    modalOverlay.addEventListener('click', () => toggleModal(false));

    confirmBtn.addEventListener('click', function () {
        // Update UI
        this.innerHTML = '<span class="animate-spin inline-block">⚡</span> Guardando...';
        this.classList.add('opacity-75', 'cursor-not-allowed');
        this.disabled = true;

        // Submit form programmatically
        console.log('🚀 Confirmado, enviando formulario...');
        form.submit();
    });
</script>

</body>

</html>
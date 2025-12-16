<?php
$mensaje = isset($mensaje) ? $mensaje : "";
$ninos = isset($ninos) ? $ninos : [];
$asistencia_hoy = isset($asistencia_hoy) ? $asistencia_hoy : [];
$fecha_formateada = isset($fecha_formateada) ? $fecha_formateada : "";
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Tomar Asistencia - Sistema Navideño">
    <title>Tomar Asistencia - Navidad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- HTML5-QRCode Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        .checkbox-wrapper {
            position: relative;
            display: inline-block;
        }

        .custom-checkbox {
            appearance: none;
            width: 28px;
            height: 28px;
            border: 2.5px solid #d1d5db;
            border-radius: 6px;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            background: white;
        }

        .dark .custom-checkbox {
            background: rgba(75, 85, 99, 0.3);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .custom-checkbox:hover {
            border-color: #10b981;
            transform: scale(1.05);
        }

        .custom-checkbox:checked {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #10b981;
            animation: checkBounce 0.3s ease;
        }

        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 18px;
            font-weight: bold;
        }

        @keyframes checkBounce {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.15);
            }
        }

        .child-card {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .child-card:hover {
            background: linear-gradient(to right, #f0fdf4, white);
            border-left-color: #10b981;
            transform: translateX(4px);
        }

        .dark .child-card:hover {
            background: linear-gradient(to right, rgba(16, 185, 129, 0.1), rgba(30, 27, 75, 0.5));
        }

        .child-card.selected {
            background: linear-gradient(to right, #ecfdf5, #f0fdf4);
            border-left-color: #10b981;
        }

        .dark .child-card.selected {
            background: linear-gradient(to right, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.05));
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

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        /* Scanner Modal Styles */
        #reader {
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
</head>

<!-- Back Button -->
<a href="<?= BASE_URL ?>" class="back-button">
    <span>←</span>
    <span>Volver</span>
</a>

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 drop-shadow-lg"
            style="font-family: 'Mountains of Christmas', cursive; text-shadow: 0 0 20px rgba(196, 30, 58, 0.5);">
            🎄 Tomar Asistencia 🎅
        </h1>
        <p class="text-white/90 text-lg font-medium">
            📅 <?php echo $fecha_formateada; ?>
        </p>
    </div>

    <!-- Success Message -->
    <?php if ($mensaje): ?>
        <div
            class="glass-card rounded-2xl p-4 mb-6 shadow-xl success-message <?php echo strpos($mensaje, '✅') !== false ? 'border-l-4 border-green-500' : 'border-l-4 border-yellow-500'; ?>">
            <p
                class="<?php echo strpos($mensaje, '✅') !== false ? 'text-green-700' : 'text-yellow-700'; ?> font-semibold text-lg">
                <?php echo $mensaje; ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Stats Card -->
    <div class="glass-card rounded-2xl p-6 mb-6 shadow-xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="stat-card rounded-xl p-4 text-center shadow-lg">
                <div class="text-3xl font-bold"><?php echo count($ninos); ?></div>
                <div class="text-sm opacity-90">Total Niños</div>
            </div>
            <div class="stat-card rounded-xl p-4 text-center shadow-lg">
                <div class="text-3xl font-bold" id="selectedCount">0</div>
                <div class="text-sm opacity-90">Presentes Hoy</div>
            </div>
            <div class="stat-card rounded-xl p-4 text-center shadow-lg">
                <div class="text-3xl font-bold" id="absentCount"><?php echo count($ninos); ?></div>
                <div class="text-sm opacity-90">Ausentes</div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <form method="POST" action="<?= BASE_URL ?>asistencia/store" id="attendanceForm"
        class="glass-card rounded-2xl p-6 md:p-8 shadow-2xl">

        <!-- Quick Actions -->
        <div class="flex flex-wrap items-center gap-3 mb-6 sticky top-2 z-10 bg-white/50 dark:bg-gray-800/50 backdrop-blur p-2 rounded-xl">
            <button type="button" onclick="selectAll()"
                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-all shadow-md hover:shadow-lg text-sm">
                ✓ Todos
            </button>
            <button type="button" onclick="deselectAll()"
                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-all shadow-md hover:shadow-lg text-sm">
                ✗ Ninguno
            </button>
            <button type="button" onclick="toggleScanner()"
                class="ml-auto px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-bold transition-all shadow-md hover:shadow-lg flex items-center gap-2 animate-pulse hover:animate-none">
                <span>📷</span> Escanear QR
            </button>
        </div>

        <!-- QR Scanner Container (Hidden) -->
        <div id="scanner-container" class="hidden mb-6 p-4 bg-black/90 rounded-2xl relative">
             <button type="button" onclick="stopScanner()" class="absolute top-2 right-2 text-white bg-red-600 rounded-full p-2 hover:bg-red-700 z-50">
                ✕
            </button>
            <h3 class="text-white text-center mb-2 font-bold">Escaneando QR...</h3>
            <div id="reader" class="bg-white"></div>
            <p class="text-gray-400 text-center text-xs mt-2">Muestra el código QR del niño frente a la cámara</p>
        </div>

        <!-- Toast Notification -->
        <div id="scan-toast" class="fixed bottom-10 left-1/2 transform -translate-x-1/2 bg-green-600 text-white px-6 py-3 rounded-full shadow-2xl z-50 transition-all duration-300 translate-y-20 opacity-0 flex items-center gap-2">
            <span class="text-2xl">✨</span>
            <div>
                <p class="font-bold">¡Asistencia Registrada!</p>
                <p class="text-xs text-green-100" id="toast-name">Niño identificado</p>
            </div>
        </div>

        <!-- Children List -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
            <?php if (count($ninos) === 0): ?>
                <div class="col-span-full text-center py-12 text-gray-500 dark:text-gray-400">
                    <p class="text-xl mb-2">📝 No hay niños registrados</p>
                    <p class="text-sm">Registra niños primero para poder tomar asistencia</p>
                </div>
            <?php else: ?>
                <?php foreach ($ninos as $index => $n): ?>
                    <?php 
                        $isPresente = isset($asistencia_hoy[$n['id']]);
                    ?>
                    <!-- Tarjeta Niño (Vertical 3x4) -->
                    <div id="card-<?php echo $n['id']; ?>" class="child-card group relative bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-md border hover:border-green-400 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-xl flex flex-col items-center justify-between gap-4 <?php echo $isPresente ? 'selected ring-2 ring-green-500' : 'border-gray-200 dark:border-gray-700'; ?>">
                        
                        <!-- Avatar -->
                        <div class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center text-white font-bold text-3xl shadow-lg mb-2 group-hover:scale-110 transition-transform">
                            <?php echo strtoupper(substr($n["nombre_completo"], 0, 1)); ?>
                        </div>
                        
                        <!-- Info -->
                        <div class="text-center w-full">
                            <h3 class="font-bold text-gray-800 dark:text-gray-100 text-lg truncate w-full px-2" title="<?php echo htmlspecialchars($n["nombre_completo"]); ?>">
                                <span class="child-name"><?php echo htmlspecialchars($n["nombre_completo"]); ?></span>
                            </h3>
                            <div class="flex items-center justify-center gap-2 mt-1 text-sm text-gray-500 dark:text-gray-400">
                                <span>🎂 <?php echo $n["edad"]; ?> años</span>
                            </div>
                        </div>

                        <!-- Checkbox Wrapper -->
                        <div class="w-full pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-center">
                            <label class="cursor-pointer flex flex-col items-center gap-2 select-none w-full group/check">
                                <span class="text-xs font-semibold uppercase tracking-wider text-gray-400 group-hover/check:text-green-500 transition-colors">Asistencia</span>
                                <div class="checkbox-wrapper">
                                    <input type="checkbox" name="asistencia[<?php echo $n['id']; ?>]" value="1" class="custom-checkbox attendance-check"
                                        data-id="<?php echo $n['id']; ?>"
                                        onchange="updateStats(); updateCardStyle(this);" id="check_<?php echo $index; ?>" 
                                        <?php echo $isPresente ? 'checked' : ''; ?>>
                                </div>
                            </label>
                        </div>

                        <!-- Status Badge (Absolute) -->
                        <div class="absolute top-3 right-3 opacity-0 transform scale-0 transition-all duration-300 <?php echo $isPresente ? 'opacity-100 scale-100' : 'opacity-0 scale-0'; ?> status-badge">
                            <span class="bg-green-100 text-green-600 text-xs font-bold px-2 py-1 rounded-full border border-green-200 shadow-sm">
                                ✅
                            </span>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <?php if (count($ninos) > 0): ?>
            <div class="flex justify-center">
                <button type="submit"
                    class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                    💾 Guardar Asistencia
                </button>
            </div>
        <?php endif; ?>
    </form>

    <!-- Footer -->
    <div class="text-center mt-8 text-white/80">
        <p class="text-sm">Sistema de Asistencia Navideña 🎁</p>
    </div>

</div>

<!-- Include shared controls (theme toggle & music player) -->
<?php include 'app/views/includes/controls.php'; ?>

<!-- Shared JavaScript -->
<script src="<?= BASE_URL ?>assets/js/app.js"></script>

<script>
    function updateStats() {
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        const checked = document.querySelectorAll('.custom-checkbox:checked').length;
        const total = checkboxes.length;

        const selCount = document.getElementById('selectedCount');
        if (selCount) selCount.textContent = checked;

        const abCount = document.getElementById('absentCount');
        if (abCount) abCount.textContent = total - checked;
    }

    function updateCardStyle(checkbox) {
        const card = checkbox.closest('.child-card');
        const badge = card.querySelector('.status-badge');
        
        if (checkbox.checked) {
            card.classList.add('selected', 'ring-2', 'ring-green-500');
            card.classList.remove('border-gray-200', 'dark:border-gray-700');
            // Show badge
            if(badge) {
                badge.classList.remove('opacity-0', 'scale-0');
                badge.classList.add('opacity-100', 'scale-100');
            }
        } else {
            card.classList.remove('selected', 'ring-2', 'ring-green-500');
            card.classList.add('border-gray-200', 'dark:border-gray-700');
            // Hide badge
            if(badge) {
                badge.classList.remove('opacity-100', 'scale-100');
                badge.classList.add('opacity-0', 'scale-0');
            }
        }
    }

    function selectAll() {
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = true;
            updateCardStyle(cb);
        });
        updateStats();
    }

    function deselectAll() {
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = false;
            updateCardStyle(cb);
        });
        updateStats();
    }

    // --- QR Scanner Logic ---
    let html5QrcodeScanner = null;

    function toggleScanner() {
        const container = document.getElementById('scanner-container');
        if (container.classList.contains('hidden')) {
            startScanner();
        } else {
            stopScanner();
        }
    }

    function startScanner() {
        document.getElementById('scanner-container').classList.remove('hidden');
        
        // Initialize if not already done
        if (!html5QrcodeScanner) {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "reader",
                { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                },
                false
            );
            
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);
        }
    }

    function stopScanner() {
        document.getElementById('scanner-container').classList.add('hidden');
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().then(() => {
                html5QrcodeScanner = null;
            }).catch(err => {
                console.error("Failed to clear scanner", err);
            });
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Assuming user ID is passed directly in QR or as plain text
        // Look for checkbox with this ID
        const targetId = decodedText.trim();
        const checkbox = document.querySelector(`.attendance-check[data-id="${targetId}"]`);

        if (checkbox) {
            if (!checkbox.checked) {
                // Check it
                checkbox.checked = true;
                updateCardStyle(checkbox);
                updateStats();
                
                // Visual feedback
                scrollToCard(targetId);
                showToast(checkbox);
                playSuccessSound();
            } else {
                // Already checked but still show feedback
                showToast(checkbox, "¡Ya estaba registrado!");
            }
        } else {
            console.warn(`No match found for QR: ${decodedText}`);
        }
    }

    function onScanFailure(error) {
        // handle scan failure
    }

    function scrollToCard(id) {
        const card = document.getElementById(`card-${id}`);
        if(card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            // Highlight effect
            card.classList.add('ring-4', 'ring-yellow-400');
            setTimeout(() => card.classList.remove('ring-4', 'ring-yellow-400'), 1000);
        }
    }

    function showToast(checkbox, message = "¡Asistencia Registrada!") {
        const toast = document.getElementById('scan-toast');
        const nameEl = document.getElementById('toast-name');
        
        // Get name
        const card = checkbox.closest('.child-card');
        const name = card.querySelector('.child-name').innerText;
        
        nameEl.innerText = name;
        toast.querySelector('p.font-bold').innerText = message;
        
        // Show
        toast.classList.remove('translate-y-20', 'opacity-0');
        
        // Hide after 3s
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    function playSuccessSound() {
        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioCtx.createOscillator();
        const gainNode = audioCtx.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioCtx.destination);

        oscillator.type = 'sine';
        oscillator.frequency.setValueAtTime(500, audioCtx.currentTime); 
        oscillator.frequency.exponentialRampToValueAtTime(1000, audioCtx.currentTime + 0.1);
        
        gainNode.gain.setValueAtTime(0.1, audioCtx.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioCtx.currentTime + 0.3);

        oscillator.start();
        oscillator.stop(audioCtx.currentTime + 0.3);
    }

    // Initialize stats on page load
    document.addEventListener('DOMContentLoaded', function () {
        updateStats();
    });
</script>

</body>

</html>
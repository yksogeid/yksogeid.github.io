<?php
require_once "config.php";

$fecha = date("Y-m-d");
$mensaje = "";
$total_asistentes = 0;

// Obtener niños
$niños = supabase_request("ninos");

// Guardar asistencia
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $total_asistentes = isset($_POST["asistencia"]) ? count($_POST["asistencia"]) : 0;

    if ($total_asistentes > 0) {
        foreach ($_POST["asistencia"] as $id => $valor) {
            $data = [
                "nino_id" => $id,
                "fecha" => $fecha,
                "asistio" => true
            ];

            // UPSERT (insertar o actualizar)
            supabase_request(
                "asistencia",
                "POST",
                $data,
                "?on_conflict=nino_id,fecha"
            );
        }
        $mensaje = "✅ Asistencia guardada exitosamente: $total_asistentes niño(s) presente(s)";
    } else {
        $mensaje = "⚠️ No se seleccionó ningún niño";
    }
}

// Formatear fecha en español
$meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
$fecha_formateada = date('d') . ' de ' . $meses[date('n') - 1] . ' de ' . date('Y');
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
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="assets/css/styles.css">
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
    </style>
</head>

<!-- Back Button -->
<a href="index.php" class="back-button">
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
                <div class="text-3xl font-bold"><?php echo count($niños); ?></div>
                <div class="text-sm opacity-90">Total Niños</div>
            </div>
            <div class="stat-card rounded-xl p-4 text-center shadow-lg">
                <div class="text-3xl font-bold" id="selectedCount">0</div>
                <div class="text-sm opacity-90">Presentes Hoy</div>
            </div>
            <div class="stat-card rounded-xl p-4 text-center shadow-lg">
                <div class="text-3xl font-bold" id="absentCount"><?php echo count($niños); ?></div>
                <div class="text-sm opacity-90">Ausentes</div>
            </div>
        </div>
    </div>

    <!-- Main Form -->
    <form method="POST" id="attendanceForm" class="glass-card rounded-2xl p-6 md:p-8 shadow-2xl">

        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-3 mb-6">
            <button type="button" onclick="selectAll()"
                class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                ✓ Seleccionar Todos
            </button>
            <button type="button" onclick="deselectAll()"
                class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg font-medium transition-all shadow-md hover:shadow-lg">
                ✗ Deseleccionar Todos
            </button>
        </div>

        <!-- Children List -->
        <div class="space-y-3 mb-6">
            <?php if (count($niños) === 0): ?>
                <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                    <p class="text-xl mb-2">📝 No hay niños registrados</p>
                    <p class="text-sm">Registra niños primero para poder tomar asistencia</p>
                </div>
            <?php else: ?>
                <?php foreach ($niños as $index => $n): ?>
                    <div
                        class="child-card bg-white dark:bg-gray-800 rounded-xl p-4 shadow-md border border-gray-200 dark:border-gray-700 flex items-center justify-between">
                        <div class="flex items-center gap-4 flex-1">
                            <div
                                class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                <?php echo strtoupper(substr($n["nombre_completo"], 0, 1)); ?>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 dark:text-gray-200 text-lg">
                                    <?php echo htmlspecialchars($n["nombre_completo"]); ?>
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    🎂 <?php echo $n["edad"]; ?> año<?php echo $n["edad"] != 1 ? 's' : ''; ?>
                                </p>
                            </div>
                        </div>
                        <div class="checkbox-wrapper">
                            <input type="checkbox" name="asistencia[<?php echo $n['id']; ?>]" value="1" class="custom-checkbox"
                                onchange="updateStats(); updateCardStyle(this);" id="check_<?php echo $index; ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Submit Button -->
        <?php if (count($niños) > 0): ?>
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
<?php include 'includes/controls.php'; ?>

<!-- Shared JavaScript -->
<script src="assets/js/app.js"></script>

<script>
    function updateStats() {
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        const checked = document.querySelectorAll('.custom-checkbox:checked').length;
        const total = checkboxes.length;

        document.getElementById('selectedCount').textContent = checked;
        document.getElementById('absentCount').textContent = total - checked;
    }

    function updateCardStyle(checkbox) {
        const card = checkbox.closest('.child-card');
        if (checkbox.checked) {
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
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

    // Initialize stats on page load
    document.addEventListener('DOMContentLoaded', function () {
        updateStats();
    });
</script>

</body>

</html>
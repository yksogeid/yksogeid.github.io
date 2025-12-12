<?php
require_once "config.php";

$mensaje = "";
$tipo_mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $nombre = trim($_POST["nombre"]);
        $edad = intval($_POST["edad"]);

        // Validaciones
        if (empty($nombre)) {
            $mensaje = "⚠️ El nombre no puede estar vacío";
            $tipo_mensaje = "warning";
        } elseif ($edad < 1 || $edad > 10) {
            $mensaje = "⚠️ La edad debe estar entre 1 y 10 años";
            $tipo_mensaje = "warning";
        } else {
            $data = [
                "nombre_completo" => $nombre,
                "edad" => $edad
            ];

            $resp = supabase_request("ninos", "POST", $data);

            $mensaje = "✅ ¡$nombre ha sido registrado exitosamente!";
            $tipo_mensaje = "success";

            // Limpiar el formulario después del registro exitoso
            $_POST = array();
        }
    } catch (Exception $e) {
        $mensaje = "❌ Error al registrar: " . $e->getMessage();
        $tipo_mensaje = "error";
    }
}
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
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
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
<a href="index.php" class="back-button">
    <span>←</span>
    <span>Volver</span>
</a>

<div class="max-w-2xl mx-auto">

    <!-- Header -->
    <div class="text-center mb-8">
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

    <!-- Success/Error Message -->
    <?php if ($mensaje): ?>
        <div class="glass-card rounded-2xl p-4 mb-6 shadow-xl success-message border-l-4 
                <?php
                if ($tipo_mensaje === 'success')
                    echo 'border-green-500';
                elseif ($tipo_mensaje === 'warning')
                    echo 'border-yellow-500';
                else
                    echo 'border-red-500';
                ?>">
            <p class="font-semibold text-lg
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

    <!-- Main Form -->
    <div class="glass-card rounded-2xl p-8 md:p-10 shadow-2xl form-container">

        <form method="POST" class="space-y-6" id="registrationForm">

            <!-- Nombre completo -->
            <div>
                <label class="label-text block text-sm mb-2 flex items-center gap-2">
                    <span class="text-xl">👤</span>
                    <span>Nombre Completo</span>
                </label>
                <input type="text" name="nombre" class="input-field w-full rounded-xl px-4 py-3 text-gray-800"
                    placeholder="Ej: Juan Pérez"
                    value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>" required
                    autocomplete="off">
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-1">Ingresa el nombre completo del niño</p>
            </div>

            <!-- Edad -->
            <div>
                <label class="label-text block text-sm mb-2 flex items-center gap-2">
                    <span class="text-xl">🎂</span>
                    <span>Edad</span>
                </label>
                <input type="number" name="edad" class="input-field w-full rounded-xl px-4 py-3 text-gray-800"
                    placeholder="Ej: 8" min="1" max="10"
                    value="<?php echo isset($_POST['edad']) ? htmlspecialchars($_POST['edad']) : ''; ?>" required>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 ml-1">Edad entre 1 y 10 años</p>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button type="submit"
                    class="submit-button w-full text-white px-6 py-4 rounded-xl font-bold text-lg shadow-xl hover:shadow-2xl flex items-center justify-center gap-3">
                    <span class="text-2xl">✨</span>
                    <span>Registrar Niño</span>
                    <span class="text-2xl">✨</span>
                </button>
            </div>

        </form>

        <!-- Info Card -->
        <div class="mt-8 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl border border-purple-200">
            <div class="flex items-start gap-3">
                <span class="text-2xl">💡</span>
                <div>
                    <h3 class="font-semibold text-gray-800 mb-1">Información</h3>
                    <p class="text-sm text-gray-600">
                        Una vez registrado, el niño aparecerá en la lista de asistencia y podrás marcar su presencia
                        en cada evento.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Quick Stats -->
    <div class="mt-6 glass-card rounded-2xl p-6 shadow-xl">
        <div class="text-center">
            <div class="text-white/90 text-sm font-medium mb-2">Total de niños registrados</div>
            <div class="text-white text-4xl font-bold">
                <?php
                try {
                    $ninos = supabase_request("ninos");
                    echo count($ninos);
                } catch (Exception $e) {
                    echo "0";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center mt-8 text-white/80">
        <p class="text-sm">Sistema de Registro Navideño 🎄</p>
    </div>

</div>

<!-- Include shared controls (theme toggle & music player) -->
<?php include 'includes/controls.php'; ?>

<!-- Shared JavaScript -->
<script src="assets/js/app.js"></script>

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
</script>

</body>

</html>
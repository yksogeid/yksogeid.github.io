<?php
$ninos = isset($ninos) ? $ninos : [];
$error = isset($error) ? $error : "";
$old = isset($old) ? $old : [];
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Registrar Compartir - Sistema Navideño">
    <title>Registrar Compartir - Navidad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
</head>

<body class="min-h-screen transition-colors duration-300">

    <!-- Back Button -->
    <a href="<?= BASE_URL ?>compartir"
        class="fixed top-4 left-4 z-50 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full hover:bg-white/20 transition-all shadow-lg flex items-center gap-2 group">
        <span class="group-hover:-translate-x-1 transition-transform">←</span>
        <span>Volver al Listado</span>
    </a>

    <div class="max-w-4xl mx-auto px-4 py-12">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4 shadow-2xl"
                style="background: linear-gradient(135deg, #FF9966 0%, #FF5E62 100%); animation: float 3s ease-in-out infinite;">
                <span class="text-4xl">🎁</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 drop-shadow-lg"
                style="font-family: 'Mountains of Christmas', cursive;">
                Asignar Compartir
            </h1>
            <p class="text-white/90 text-lg font-medium">
                Selecciona al niño y la fecha del refrigerio 📅
            </p>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="bg-red-500/10 border-l-4 border-red-500 text-red-200 p-4 rounded-xl mb-6 backdrop-blur-sm">
                <p class="font-bold">Error:</p>
                <p><?= htmlspecialchars($error) ?></p>
            </div>
        <?php endif; ?>

        <!-- Form Card -->
        <div
            class="glass-card rounded-2xl p-8 shadow-2xl relative overflow-hidden backdrop-blur-md bg-white/10 border border-white/20">

            <form method="POST" action="<?= BASE_URL ?>compartir/store" class="space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Niño Select -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-white/90 text-sm font-bold mb-2 flex items-center gap-2">
                            <span class="text-xl">👶</span> Seleccionar Niño
                        </label>
                        <select name="nino_id"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:bg-white/20 transition-all">
                            <option value="" class="text-black">-- Selecciona un niño --</option>
                            <?php foreach ($ninos as $n): ?>
                                <option value="<?= $n['id'] ?>" class="text-black" <?= (isset($old['nino_id']) && $old['nino_id'] == $n['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($n['nombre_completo']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Fecha -->
                    <div>
                        <label class="block text-white/90 text-sm font-bold mb-2 flex items-center gap-2">
                            <span class="text-xl">📅</span> Fecha
                        </label>
                        <input type="date" name="fecha"
                            value="<?= isset($old['fecha']) ? htmlspecialchars($old['fecha']) : '' ?>"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:bg-white/20 transition-all [color-scheme:dark]">
                    </div>

                    <!-- Relación -->
                    <div>
                        <label class="block text-white/90 text-sm font-bold mb-2 flex items-center gap-2">
                            <span class="text-xl">👪</span> Relación
                        </label>
                        <select name="relacion"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:bg-white/20 transition-all">
                            <option value="" class="text-black">-- Selecciona --</option>
                            <option value="PADRE" class="text-black" <?= (isset($old['relacion']) && $old['relacion'] == 'PADRE') ? 'selected' : '' ?>>PADRE</option>
                            <option value="MADRE" class="text-black" <?= (isset($old['relacion']) && $old['relacion'] == 'MADRE') ? 'selected' : '' ?>>MADRE</option>
                        </select>
                    </div>

                    <!-- Nombre Responsable -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-white/90 text-sm font-bold mb-2 flex items-center gap-2">
                            <span class="text-xl">👤</span> Nombre del Responsable
                        </label>
                        <input type="text" name="nombre_responsable" placeholder="Nombre del padre o madre"
                            value="<?= isset($old['nombre_responsable']) ? htmlspecialchars($old['nombre_responsable']) : '' ?>"
                            class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:bg-white/20 transition-all">
                    </div>

                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-4 bg-gradient-to-r from-yellow-400 to-yellow-600 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all flex items-center justify-center gap-2">
                        <span class="text-2xl">✨</span> Guardar Asignación
                    </button>
                </div>

            </form>
        </div>

    </div>

    <?php include 'app/views/includes/controls.php'; ?>
    <script src="<?= BASE_URL ?>assets/js/app.js"></script>

</body>

</html>
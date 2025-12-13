<?php
$compartires = isset($compartires) ? $compartires : [];
?>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Listado de Compartir - Sistema Navideño">
    <title>Compartir Novena - Navidad</title>
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
    <a href="<?= BASE_URL ?>"
        class="fixed top-4 left-4 z-50 px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white rounded-full hover:bg-white/20 transition-all shadow-lg flex items-center gap-2 group">
        <span class="group-hover:-translate-x-1 transition-transform">←</span>
        <span>Volver</span>
    </a>

    <div class="max-w-7xl mx-auto px-4 py-12">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center mb-4 shadow-2xl"
                style="background: linear-gradient(135deg, #FF9966 0%, #FF5E62 100%); animation: float 3s ease-in-out infinite;">
                <span class="text-4xl">🥘</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 drop-shadow-lg"
                style="font-family: 'Mountains of Christmas', cursive;">
                Compartir Novena
            </h1>
            <p class="text-white/90 text-lg font-medium">
                Gestión de los refrigerios y compartir diario 🍪
            </p>
        </div>

        <!-- Action Bar -->
        <div class="flex justify-end mb-8">
            <a href="<?= BASE_URL ?>compartir/create"
                class="px-6 py-3 bg-gradient-to-r from-green-400 to-green-600 text-white rounded-xl font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all flex items-center gap-2">
                <span class="text-xl">➕</span>
                Registrar Nuevo
            </a>
        </div>

        <!-- List -->
        <!-- List vs Empty State -->
        <?php if (empty($compartires)): ?>
            <div
                class="glass-card rounded-2xl p-8 shadow-2xl relative overflow-hidden backdrop-blur-md bg-white/10 border border-white/20">
                <div class="flex flex-col items-center justify-center py-16 text-white/70">
                    <span class="text-6xl mb-4 opacity-50">🍽️</span>
                    <p class="text-xl">No hay registros de compartir aún.</p>
                    <p class="text-sm mt-2">¡Registra el primero usando el botón de arriba!</p>
                </div>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($compartires as $item): ?>
                    <div
                        class="glass-card rounded-2xl p-6 hover:-translate-y-2 transition-all duration-300 border border-white/20 flex flex-col gap-4 relative group">

                        <!-- Decorative bg -->
                        <div
                            class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-bl-full -mr-4 -mt-4 transition-all group-hover:bg-white/10 pointer-events-none">
                        </div>

                        <!-- Header: Date & Relacion -->
                        <div class="flex justify-between items-start z-10">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-12 h-12 rounded-2xl flex flex-col items-center justify-center bg-gradient-to-br from-white/20 to-white/5 border border-white/20 text-white shadow-inner">
                                    <span
                                        class="text-lg font-bold leading-none mt-1"><?= date('d', strtotime($item['fecha'])) ?></span>
                                    <span
                                        class="text-[10px] uppercase font-bold leading-none mb-1 opacity-80"><?= date('M', strtotime($item['fecha'])) ?></span>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-gray-200 text-xs font-medium">Novena día</span>
                                    <span
                                        class="text-white font-bold tracking-wide"><?= date('l', strtotime($item['fecha'])) ?></span>
                                </div>
                            </div>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-bold border backdrop-blur-sm shadow-lg
                                <?= $item['relacion'] === 'PADRE' ? 'bg-blue-500/20 text-blue-200 border-blue-500/30' : 'bg-pink-500/20 text-pink-200 border-pink-500/30' ?>">
                                <?= $item['relacion'] ?>
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="space-y-3 z-10 mt-2">
                            <!-- Niño -->
                            <div
                                class="flex items-center gap-3 p-3 rounded-xl bg-black/20 border border-white/5 group-hover:border-white/10 transition-colors">
                                <span class="text-2xl">👶</span>
                                <div>
                                    <p class="text-[10px] text-white/50 uppercase tracking-widest font-bold">Niño/a</p>
                                    <p class="font-bold text-white text-lg leading-tight truncate">
                                        <?= isset($item['ninos']['nombre_completo']) ? htmlspecialchars($item['ninos']['nombre_completo']) : 'Desconocido' ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Responsable -->
                            <div
                                class="flex items-center gap-3 p-3 rounded-xl bg-black/20 border border-white/5 group-hover:border-white/10 transition-colors">
                                <span class="text-2xl">👤</span>
                                <div>
                                    <p class="text-[10px] text-white/50 uppercase tracking-widest font-bold">Responsable</p>
                                    <p class="font-medium text-white/90 truncate">
                                        <?= htmlspecialchars($item['nombre_responsable']) ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-3 mt-2 z-10 pt-4 border-t border-white/10">
                            <a href="<?= BASE_URL ?>compartir/edit/<?= $item['id'] ?>"
                                class="flex-1 py-2.5 rounded-xl bg-white/5 hover:bg-yellow-500/20 text-center text-yellow-200 hover:text-yellow-100 font-bold transition-all flex items-center justify-center gap-2 border border-white/10 group/btn">
                                <span class="group-hover/btn:scale-110 transition-transform">✏️</span> Editar
                            </a>
                            <a href="<?= BASE_URL ?>compartir/delete/<?= $item['id'] ?>"
                                onclick="return confirm('¿Estás seguro de eliminar este registro?');"
                                class="flex-1 py-2.5 rounded-xl bg-white/5 hover:bg-red-500/20 text-center text-red-300 hover:text-red-100 font-bold transition-all flex items-center justify-center gap-2 border border-white/10 group/btn">
                                <span class="group-hover/btn:scale-110 transition-transform">🗑️</span> Eliminar
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>

    <?php include 'app/views/includes/controls.php'; ?>
    <script src="<?= BASE_URL ?>assets/js/app.js"></script>

</body>

</html>
<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#0f2027">
    <meta name="description" content="Sistema de Gestión de Asistencia Navideña">
    <title>Dashboard - Sistema Navideño</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <style>
        .stat-card {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        /* ... (rest of styles) ... */
        .gradient-purple {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .gradient-green {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .gradient-orange {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .gradient-pink {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        }

        .fade-in {
            animation: fadeIn 0.6s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-button {
            transition: all 0.3s ease;
        }

        .nav-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .progress-bar {
            transition: width 1s ease;
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background: linear-gradient(to right, #f0fdf4, white);
            transform: translateX(4px);
        }

        .dark .table-row:hover {
            background: linear-gradient(to right, rgba(16, 185, 129, 0.1), rgba(30, 27, 75, 0.5));
        }

        @media (max-width: 768px) {
            .table-row {
                transform: none !important;
            }

            .table-row:hover {
                transform: none !important;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
            }
        }
    </style>
</head>

<body class="p-4 md:p-8">

    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-8 fade-in">
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-3 drop-shadow-lg"
                style="font-family: 'Mountains of Christmas', cursive; text-shadow: 0 0 30px rgba(196, 30, 58, 0.6);">
                🎄 Dashboard Navideño 🎅
            </h1>
            <p class="text-white/90 text-lg md:text-xl font-medium">
                Sistema de Gestión de Asistencia
            </p>
        </div>

        <!-- Navigation Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8 fade-in">
            <a href="<?= BASE_URL ?>ninos/create"
                class="nav-button glass-card rounded-2xl p-6 shadow-xl text-center block">
                <div class="text-5xl mb-3">🎁</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Registrar Niño</h3>
                <p class="text-gray-600 text-sm">Añadir un nuevo niño al sistema</p>
            </a>
            <a href="<?= BASE_URL ?>asistencia/create"
                class="nav-button glass-card rounded-2xl p-6 shadow-xl text-center block">
                <div class="text-5xl mb-3">✅</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Tomar Asistencia</h3>
                <p class="text-gray-600 text-sm">Registrar la asistencia del día</p>
            </a>
            <a href="<?= BASE_URL ?>compartir"
                class="nav-button glass-card rounded-2xl p-6 shadow-xl text-center block">
                <div class="text-5xl mb-3">🥘</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Gestionar Compartir</h3>
                <p class="text-gray-600 text-sm">Asignar refrigerios por día</p>
            </a>
            <a href="<?= BASE_URL ?>estadisticas/index"
                class="nav-button glass-card rounded-2xl p-6 shadow-xl text-center block">
                <div class="text-5xl mb-3">📈</div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Ver Estadísticas</h3>
                <p class="text-gray-600 text-sm">Reportes y análisis de datos</p>
            </a>
        </div>

        <!-- Main Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">

            <!-- Total Niños -->
            <div class="stat-card glass-card rounded-2xl p-4 md:p-6 shadow-xl fade-in" style="animation-delay: 0.1s;">
                <div class="gradient-purple text-white rounded-xl p-4 mb-4">
                    <div class="text-4xl mb-2">👶</div>
                    <div class="text-3xl font-bold"><?php echo $total_ninos; ?></div>
                </div>
                <h3 class="font-semibold text-gray-800 text-lg">Niños Registrados</h3>
                <p class="text-gray-500 text-sm">Total en el sistema</p>
            </div>

            <!-- Total Asistencias -->
            <div class="stat-card glass-card rounded-2xl p-4 md:p-6 shadow-xl fade-in" style="animation-delay: 0.2s;">
                <div class="gradient-green text-white rounded-xl p-4 mb-4">
                    <div class="text-4xl mb-2">📊</div>
                    <div class="text-3xl font-bold"><?php echo $total_asistencias; ?></div>
                </div>
                <h3 class="font-semibold text-gray-800 text-lg">Total Asistencias</h3>
                <p class="text-gray-500 text-sm">Registros acumulados</p>
            </div>

            <!-- Promedio de Asistencia -->
            <div class="stat-card glass-card rounded-2xl p-4 md:p-6 shadow-xl fade-in" style="animation-delay: 0.3s;">
                <div class="gradient-orange text-white rounded-xl p-4 mb-4">
                    <div class="text-4xl mb-2">📈</div>
                    <div class="text-3xl font-bold"><?php echo $promedio_asistencia; ?></div>
                </div>
                <h3 class="font-semibold text-gray-800 text-lg">Promedio por Día</h3>
                <p class="text-gray-500 text-sm">Asistencia promedio</p>
            </div>

            <!-- Días con Registro -->
            <div class="stat-card glass-card rounded-2xl p-4 md:p-6 shadow-xl fade-in" style="animation-delay: 0.4s;">
                <div class="gradient-pink text-white rounded-xl p-4 mb-4">
                    <div class="text-4xl mb-2">📅</div>
                    <div class="text-3xl font-bold"><?php echo count($asistencias_por_fecha); ?></div>
                </div>
                <h3 class="font-semibold text-gray-800 text-lg">Días Registrados</h3>
                <p class="text-gray-500 text-sm">Eventos realizados</p>
            </div>

        </div>

        <!-- Attendance Progress -->
        <?php if ($total_ninos > 0): ?>
            <div class="glass-card rounded-2xl p-6 md:p-8 shadow-xl mb-8 fade-in" style="animation-delay: 0.5s;">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span>📊</span>
                    <span>Porcentaje de Asistencia Promedio</span>
                </h2>
                <div class="bg-gray-200 rounded-full h-8 overflow-hidden">
                    <div class="progress-bar gradient-green h-full flex items-center justify-center text-white font-bold text-sm"
                        style="width: <?php echo $porcentaje_asistencia; ?>%;">
                        <?php echo $porcentaje_asistencia; ?>%
                    </div>
                </div>
                <p class="text-gray-600 text-sm mt-2">
                    En promedio, <?php echo $promedio_asistencia; ?> de <?php echo $total_ninos; ?> niños asisten por evento
                </p>
            </div>
        <?php endif; ?>

        <!-- Asistencia por Fecha -->
        <div class="glass-card rounded-2xl p-6 md:p-8 shadow-xl fade-in" style="animation-delay: 0.6s;">
            <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                <span>📅</span>
                <span>Asistencia por Fecha</span>
            </h2>

            <?php if (count($asistencias_por_fecha) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-300">
                                <th class="text-left py-3 px-2 md:px-4 font-semibold text-gray-700 text-sm md:text-base">
                                    Fecha</th>
                                <th class="text-center py-3 px-2 md:px-4 font-semibold text-gray-700 text-sm md:text-base">
                                    Asistentes</th>
                                <th class="text-center py-3 px-2 md:px-4 font-semibold text-gray-700 text-sm md:text-base">%
                                </th>
                                <th class="text-left py-3 px-2 md:px-4 font-semibold text-gray-700 text-sm md:text-base">
                                    Gráfico</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Helper function needs to be available. I'll include it here or make it a global helper.
                            if (!function_exists('formatearFecha')) {
                                function formatearFecha($fecha)
                                {
                                    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                    $partes = explode('-', $fecha);
                                    if (count($partes) === 3) {
                                        return $partes[2] . ' de ' . $meses[(int) $partes[1] - 1] . ' de ' . $partes[0];
                                    }
                                    return $fecha;
                                }
                            }
                            ?>
                            <?php foreach ($asistencias_por_fecha as $fecha => $cantidad): ?>
                                <?php
                                $porcentaje = $total_ninos > 0 ? round(($cantidad / $total_ninos) * 100) : 0;
                                $es_max = ($fecha === $fecha_max_asistencia);
                                ?>
                                <tr class="table-row border-b border-gray-200 <?php echo $es_max ? 'bg-green-50' : ''; ?>">
                                    <td class="py-3 md:py-4 px-2 md:px-4">
                                        <div class="flex items-center gap-2">
                                            <?php if ($es_max): ?>
                                                <span class="text-lg md:text-xl">🏆</span>
                                            <?php endif; ?>
                                            <span class="font-medium text-gray-800 text-sm md:text-base">
                                                <?php echo formatearFecha($fecha); ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-3 md:py-4 px-2 md:px-4 text-center">
                                        <span
                                            class="inline-block bg-gradient-to-r from-purple-500 to-pink-500 text-white px-2 md:px-4 py-1 rounded-full font-bold text-xs md:text-sm">
                                            <?php echo $cantidad; ?> / <?php echo $total_ninos; ?>
                                        </span>
                                    </td>
                                    <td class="py-3 md:py-4 px-2 md:px-4 text-center">
                                        <span
                                            class="font-semibold text-gray-700 text-sm md:text-base"><?php echo $porcentaje; ?>%</span>
                                    </td>
                                    <td class="py-3 md:py-4 px-2 md:px-4">
                                        <div class="bg-gray-200 rounded-full h-6 overflow-hidden w-full max-w-xs">
                                            <div class="gradient-green h-full flex items-center justify-end pr-2"
                                                style="width: <?php echo $porcentaje; ?>%;">
                                                <span class="text-white text-xs font-bold">
                                                    <?php if ($porcentaje > 20): ?>
                                                        <?php echo $porcentaje; ?>%
                                                    <?php endif; ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if ($fecha_max_asistencia): ?>
                    <div class="mt-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl border border-green-200">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl md:text-3xl">🏆</span>
                            <div>
                                <h3 class="font-bold text-gray-800 mb-1 text-sm md:text-base">Mejor Asistencia</h3>
                                <p class="text-xs md:text-sm text-gray-700">
                                    El <strong><?php echo formatearFecha($fecha_max_asistencia); ?></strong>
                                    tuvo la mayor asistencia con <strong><?php echo $max_asistencia; ?> niños</strong>
                                    (<?php echo round(($max_asistencia / $total_ninos) * 100); ?>%)
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="text-center py-12 text-gray-500">
                    <div class="text-4xl md:text-6xl mb-4">📋</div>
                    <p class="text-lg md:text-xl mb-2">No hay registros de asistencia</p>
                    <p class="text-sm mb-6">Comienza a tomar asistencia para ver las estadísticas</p>
                    <a href="<?= BASE_URL ?>asistencia/create"
                        class="inline-block px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transition-all">
                        Tomar Asistencia Ahora
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-white/80">
            <p class="text-xs md:text-sm">Sistema de Gestión Navideña 🎄 | Desarrollado con ❤️</p>
        </div>

    </div>

    <!-- We need to update this include path later, but for now kept relative to where index.php is? 
         No, in MVC view structure, include paths need to be careful.
         Since this file is included by Controller in index.php (root), relative paths are relative to root.
         So 'includes/controls.php' should work if the 'includes' folder is in root.
    -->
    <?php include 'app/views/includes/controls.php'; ?>

    <!-- Shared JavaScript -->
    <script src="<?= BASE_URL ?>assets/js/app.js"></script>

    <script>
        // Animate progress bars on load
        window.addEventListener('load', function () {
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>

</body>

</html>
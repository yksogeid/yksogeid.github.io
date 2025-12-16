<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#4f46e5">
    <meta name="description" content="Estadísticas de Niños - Sistema Navideño">
    <title>Estadísticas - Navidad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/styles.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- html2pdf.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-card {
            background: rgba(17, 24, 39, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .stat-icon {
            background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        }

        .stat-icon-boys {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .stat-icon-girls {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
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

        .fade-in {
            animation: fadeIn 0.6s ease forwards;
        }

        /* PDF Generation Overrides */
        .pdf-mode {
            background-color: #ffffff !important;
            color: #000000 !important;
        }

        .pdf-mode .glass-card {
            background: #ffffff !important;
            border: 1px solid #ccc !important;
            box-shadow: none !important;
            backdrop-filter: none !important;
            color: #000000 !important;
            break-inside: avoid;
        }

        .pdf-mode h1,
        .pdf-mode h2,
        .pdf-mode h3,
        .pdf-mode p,
        .pdf-mode span,
        .pdf-mode div {
            color: #000000 !important;
            text-shadow: none !important;
        }

        /* Keep colored badges readable */
        .pdf-mode .stat-icon,
        .pdf-mode .stat-icon-boys,
        .pdf-mode .stat-icon-girls {
            color: white !important;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .pdf-mode th {
            background-color: #f3f4f6 !important;
            color: #000000 !important;
        }

        .pdf-mode table {
            width: 100% !important;
            border-collapse: collapse;
        }

        .pdf-mode tr {
            page-break-inside: avoid;
        }

        .pdf-mode .dark\:text-white {
            color: #000000 !important;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300 min-h-screen p-4 md:p-8">

    <!-- Back Button -->
    <a href="<?= BASE_URL ?>"
        class="fixed top-4 left-4 z-50 bg-white/80 dark:bg-gray-800/80 backdrop-blur p-3 rounded-full shadow-lg hover:shadow-xl transition-all hover:-translate-x-1 group print:hidden">
        <span class="text-xl">←</span>
    </a>

    <div class="max-w-7xl mx-auto" id="reportContent">

        <!-- Header -->
        <div class="text-center mb-10 fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 dark:text-white mb-2"
                style="font-family: 'Mountains of Christmas', cursive;">
                📊 Estadísticas Navideñas
            </h1>
            <p class="text-gray-600 dark:text-gray-300 text-lg">
                Reporte detallado de niños registrados
            </p>

            <button onclick="downloadPDF()" id="downloadBtn"
                class="mt-6 bg-gradient-to-r from-red-500 to-rose-600 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-red-500/30 hover:-translate-y-1 transition-all flex items-center justify-center gap-2 mx-auto">
                <span>📄</span> Descargar Reporte PDF
            </button>
        </div>

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total -->
            <div class="glass-card rounded-2xl p-6 shadow-xl fade-in" style="animation-delay: 0.1s;">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Niños</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?= $stats['total'] ?></h3>
                    </div>
                    <div class="stat-icon p-3 rounded-xl text-white text-2xl shadow-lg shadow-indigo-500/30">
                        👶
                    </div>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-indigo-500 h-2 rounded-full" style="width: 100%"></div>
                </div>
            </div>

            <!-- Boys -->
            <div class="glass-card rounded-2xl p-6 shadow-xl fade-in" style="animation-delay: 0.2s;">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Niños (Hombre)</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?= $stats['ninos'] ?></h3>
                        <p class="text-xs text-blue-500 font-bold mt-1"><?= $stats['porcentaje_ninos'] ?>% del total</p>
                    </div>
                    <div class="stat-icon-boys p-3 rounded-xl text-white text-2xl shadow-lg shadow-blue-500/30">
                        👦
                    </div>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: <?= $stats['porcentaje_ninos'] ?>%"></div>
                </div>
            </div>

            <!-- Girls -->
            <div class="glass-card rounded-2xl p-6 shadow-xl fade-in" style="animation-delay: 0.3s;">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400 text-sm font-medium">Niñas (Mujer)</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?= $stats['ninas'] ?></h3>
                        <p class="text-xs text-pink-500 font-bold mt-1"><?= $stats['porcentaje_ninas'] ?>% del total</p>
                    </div>
                    <div class="stat-icon-girls p-3 rounded-xl text-white text-2xl shadow-lg shadow-pink-500/30">
                        👧
                    </div>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-pink-500 h-2 rounded-full" style="width: <?= $stats['porcentaje_ninas'] ?>%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Age Chart -->
            <div class="glass-card rounded-2xl p-6 shadow-xl fade-in" style="animation-delay: 0.4s;">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Distribución por Edad</h3>
                <div class="relative h-64 md:h-80 w-full chart-container">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>

            <!-- Age Table -->
            <div class="glass-card rounded-2xl p-6 shadow-xl fade-in h-400 overflow-hidden"
                style="animation-delay: 0.5s;">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Detalle por Edades</h3>
                <div class="overflow-y-auto max-h-80">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50 sticky top-0">
                            <tr>
                                <th class="py-3 px-4 text-left rounded-l-lg text-gray-600 dark:text-gray-300">Edad</th>
                                <th class="py-3 px-4 text-right text-gray-600 dark:text-gray-300">Cantidad</th>
                                <th class="py-3 px-4 text-right rounded-r-lg text-gray-600 dark:text-gray-300">%</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            <?php foreach ($stats['edades'] as $edadGroup): ?>
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                    <td class="py-3 px-4 font-medium"><?= $edadGroup['edad'] ?> años</td>
                                    <td class="py-3 px-4 text-right font-bold text-indigo-600 dark:text-indigo-400">
                                        <?= $edadGroup['count'] ?>
                                    </td>
                                    <td class="py-3 px-4 text-right text-gray-500 text-sm">
                                        <?= $stats['total'] > 0 ? round(($edadGroup['count'] / $stats['total']) * 100, 1) : 0 ?>%
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Full List (Hidden initially, shown in PDF if desired, or we can make a separate PDF-only view) -->
        <!-- For this request, let's show a summary table of all kids here too -->
        <div class="glass-card rounded-2xl p-8 shadow-xl fade-in mb-8" style="animation-delay: 0.6s;">
            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Listado Completo (<?= count($ninos) ?>)
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr
                            class="border-b border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 text-sm uppercase tracking-wider">
                            <th class="py-3 px-4">Nombre</th>
                            <th class="py-3 px-4">Género</th>
                            <th class="py-3 px-4">Edad</th>
                            <th class="py-3 px-4">Registro</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm md:text-base">
                        <?php foreach ($ninos as $nino): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">
                                    <?= htmlspecialchars($nino['nombre_completo']) ?>
                                </td>
                                <td class="py-3 px-4">
                                    <?php if ($nino['genero'] == 'M'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                            👦 Niño
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200">
                                            👧 Niña
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4"><?= $nino['edad'] ?> años</td>
                                <td class="py-3 px-4 text-gray-500">
                                    <?= isset($nino['created_at']) ? date('d/m/Y', strtotime($nino['created_at'])) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Hidden PDF Template -->
    <div id="printableTemplate" class="hidden" style="display: none;">
        <div class="p-8 bg-white text-black font-sans w-[280mm] mx-auto relative overflow-hidden">

            <!-- Watermark decoration -->
            <div class="absolute top-0 right-0 p-4 opacity-10 pointer-events-none">
                <span class="text-9xl">🎄</span>
            </div>

            <!-- Header -->
            <div class="flex justify-between items-start mb-8 border-b-4 border-red-700 pb-4">
                <div class="flex items-center gap-4">
                    <div class="bg-red-700 text-white p-3 rounded-lg shadow-sm">
                        <span class="text-4xl">🎅</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 uppercase tracking-tight">Reporte Navideño</h1>
                        <p class="text-green-700 font-medium text-lg">Control de Asistencia y Entrega de Regalos</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="bg-green-50 px-4 py-2 rounded-lg border border-green-200">
                        <p class="text-xs text-green-800 font-bold uppercase tracking-wider mb-1">Fecha de Emisión</p>
                        <p id="pdfDate" class="text-xl font-bold text-red-700">
                            <?= date('d') ?>/<?= date('m') ?>/<?= date('Y') ?>
                        </p>
                        <p id="pdfTime" class="text-xs text-gray-500"><?= date('h:i A') ?></p>
                    </div>
                </div>
            </div>

            <!-- Resumen (KPIs) -->
            <div class="grid grid-cols-4 gap-6 mb-8">
                <!-- Total -->
                <div
                    class="col-span-2 bg-gradient-to-r from-gray-800 to-gray-900 text-white p-5 rounded-xl shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-xs font-bold uppercase tracking-wider mb-1">Población Total</p>
                        <p class="text-4xl font-bold"><?= $stats['total'] ?></p>
                        <p class="text-gray-400 text-xs mt-1">Niños y Niñas registrados</p>
                    </div>
                    <div class="text-4xl opacity-50">👥</div>
                </div>

                <!-- Niños (Verde) -->
                <div class="bg-green-50 border-l-4 border-green-600 p-4 rounded-r-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-green-800 text-xs font-bold uppercase tracking-wider">Niños</p>
                            <p class="text-3xl font-bold text-green-700 mt-1"><?= $stats['ninos'] ?></p>
                        </div>
                        <span class="text-2xl">👦</span>
                    </div>
                    <div class="mt-2 w-full bg-green-200 h-1 rounded-full">
                        <div class="bg-green-600 h-1 rounded-full" style="width: <?= $stats['porcentaje_ninos'] ?>%">
                        </div>
                    </div>
                    <p class="text-right text-xs text-green-600 font-bold mt-1"><?= $stats['porcentaje_ninos'] ?>%</p>
                </div>

                <!-- Niñas (Rojo) -->
                <div class="bg-red-50 border-l-4 border-red-600 p-4 rounded-r-xl shadow-sm">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-red-800 text-xs font-bold uppercase tracking-wider">Niñas</p>
                            <p class="text-3xl font-bold text-red-700 mt-1"><?= $stats['ninas'] ?></p>
                        </div>
                        <span class="text-2xl">👧</span>
                    </div>
                    <div class="mt-2 w-full bg-red-200 h-1 rounded-full">
                        <div class="bg-red-600 h-1 rounded-full" style="width: <?= $stats['porcentaje_ninas'] ?>%">
                        </div>
                    </div>
                    <p class="text-right text-xs text-red-600 font-bold mt-1"><?= $stats['porcentaje_ninas'] ?>%</p>
                </div>
            </div>

            <?php
            // Filter arrays for the report
            $listaNinos = array_filter($ninos, function ($n) {
                return $n['genero'] == 'M';
            });
            $listaNinas = array_filter($ninos, function ($n) {
                return $n['genero'] == 'F';
            });

            // Sort by age
            usort($listaNinos, function ($a, $b) {
                return $a['edad'] - $b['edad'];
            });
            usort($listaNinas, function ($a, $b) {
                return $a['edad'] - $b['edad'];
            });
            ?>

            <!-- Listados -->
            <div class="grid grid-cols-2 gap-8">

                <!-- Tabla Niños -->
                <div class="border border-green-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="bg-green-700 text-white px-4 py-3 flex justify-between items-center">
                        <h3 class="font-bold flex items-center gap-2">
                            <span>👦</span> Listado de Niños
                        </h3>
                        <span class="bg-green-800 px-2 py-0.5 rounded text-xs text-white"><?= count($listaNinos) ?>
                            Registros</span>
                    </div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-green-100 text-green-900 border-b border-green-200">
                                <th class="px-4 py-2 text-left font-bold uppercase text-[10px]">Nombre Completo</th>
                                <th class="px-4 py-2 text-center w-16 font-bold uppercase text-[10px]">Edad</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php if (empty($listaNinos)): ?>
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-black italic">No hay niños registrados</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($listaNinos as $index => $n): ?>
                                    <tr class="<?= $index % 2 === 0 ? 'bg-white' : 'bg-green-50' ?>">
                                        <td
                                            class="px-4 py-2 text-gray-900 font-bold uppercase text-xs border-b border-gray-100">
                                            <?= htmlspecialchars($n['nombre_completo']) ?>
                                        </td>
                                        <td class="px-4 py-2 text-center font-bold text-black border-b border-gray-100">
                                            <?= $n['edad'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Tabla Niñas -->
                <div class="border border-red-200 rounded-xl overflow-hidden shadow-sm">
                    <div class="bg-red-700 text-white px-4 py-3 flex justify-between items-center">
                        <h3 class="font-bold flex items-center gap-2">
                            <span>👧</span> Listado de Niñas
                        </h3>
                        <span class="bg-red-800 px-2 py-0.5 rounded text-xs text-white"><?= count($listaNinas) ?>
                            Registros</span>
                    </div>
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-red-100 text-red-900 border-b border-red-200">
                                <th class="px-4 py-2 text-left font-bold uppercase text-[10px]">Nombre Completo</th>
                                <th class="px-4 py-2 text-center w-16 font-bold uppercase text-[10px]">Edad</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php if (empty($listaNinas)): ?>
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-black italic">No hay niñas registradas</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($listaNinas as $index => $n): ?>
                                    <tr class="<?= $index % 2 === 0 ? 'bg-white' : 'bg-red-50' ?>">
                                        <td
                                            class="px-4 py-2 text-gray-900 font-bold uppercase text-xs border-b border-gray-100">
                                            <?= htmlspecialchars($n['nombre_completo']) ?>
                                        </td>
                                        <td class="px-4 py-2 text-center font-bold text-black border-b border-gray-100">
                                            <?= $n['edad'] ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Footer -->
            <div
                class="mt-8 pt-4 border-t-2 border-dashed border-gray-200 flex justify-between items-end text-gray-400 text-xs">
                <div>
                    <p class="font-bold text-gray-500 uppercase">Sistema Navideño 2025</p>
                    <p>Reporte Oficial de Entrega de Regalos</p>
                </div>
                <div class="text-right">
                    <p>GemetechITServices - Software a la medida</p>
                    <div class="w-48 h-8 border-b border-gray-300 mt-2"></div>
                </div>
            </div>

        </div>
    </div>

    <?php include 'app/views/includes/controls.php'; ?>
    <script src="<?= BASE_URL ?>assets/js/app.js"></script>

    <script>
        // Data for Chart
        const ageData = <?= json_encode($stats['edades']) ?>;
        const labels = ageData.map(item => item.edad + ' años');
        const counts = ageData.map(item => item.count);

        // Render Chart
        const ctx = document.getElementById('ageChart').getContext('2d');
        const ageChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Niños por edad',
                    data: counts,
                    backgroundColor: 'rgba(99, 102, 241, 0.5)',
                    borderColor: 'rgba(99, 102, 241, 1)',
                    borderWidth: 1,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)'
                        },
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // PDF Download Function
        function downloadPDF() {
            const template = document.getElementById('printableTemplate');

            // UPDATE DATE AND TIME DYNAMICALLY
            const now = new Date();
            const dateOptions = { day: '2-digit', month: 'long', year: 'numeric' };
            const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };

            document.getElementById('pdfDate').innerText = now.toLocaleDateString('es-ES', dateOptions);
            document.getElementById('pdfTime').innerText = now.toLocaleTimeString('es-ES', timeOptions);

            // Show template temporarily
            template.style.display = 'block';
            template.classList.remove('hidden');

            const opt = {
                margin: [0.3, 0.3, 0.3, 0.3], // Smaller margins for landscape
                filename: 'Reporte_Navidad_Horizontal.pdf',
                image: { type: 'jpeg', quality: 1.0 },
                html2canvas: { scale: 2, useCORS: true, windowWidth: 1400 }, // Wider window for landscape
                jsPDF: { unit: 'in', format: 'a4', orientation: 'landscape' }
            };

            // Use the button to show feedback
            const btn = document.getElementById('downloadBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = '⌛ Generando PDF Horizontal...';
            btn.disabled = true;

            html2pdf().set(opt).from(template).save().then(() => {
                // Restore state
                template.style.display = 'none';
                template.classList.add('hidden');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    </script>
</body>

</html>
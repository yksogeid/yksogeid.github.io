<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carnets QR - Navidad</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- QRCode.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- html2pdf.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        .badge-card {
            width: 85.6mm;
            /* ID-1 format width */
            height: 53.98mm;
            /* ID-1 format height */
            position: relative;
            overflow: hidden;
            border: 2px solid #e5e7eb;
            background: white;
            break-inside: avoid;
            page-break-inside: avoid;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .decorative-circle {
            position: absolute;
            border-radius: 50%;
            z-index: 0;
        }

        /* Specific container for PDF generation to ensure white background */
        #carnetsContainer {
            background-color: white;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen p-8">

    <!-- Header / Controls -->
    <div class="max-w-7xl mx-auto mb-8 flex justify-between items-center no-print">
        <div>
            <a href="<?= BASE_URL ?>ninos/create"
                class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors mb-2">
                <span>←</span> Volver al registro
            </a>
            <h1 class="text-3xl font-bold text-gray-800">🪪 Carnets de Identificación</h1>
            <p class="text-gray-600 text-sm mt-1">Descarga estos carnets para el control de asistencia con QR</p>
        </div>
        <button onclick="downloadPDF()" id="downloadBtn"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center gap-2">
            <span>⬇️</span> Descargar QRs (PDF)
        </button>
    </div>

    <!-- Badges Container -->
    <div id="carnetsContainer" class="bg-white">

        <?php
        // Break array into chunks of 9 for perfect 3x3 pages
        $chunks = array_chunk($ninos, 9);
        foreach ($chunks as $pageIndex => $pageNinos):
            ?>
            <!-- A4 Landscape Page Container (Safe Area: ~287mm x ~200mm) 
                 Using 285mm x 190mm to ensure it fits with margins without overflowing -->
            <div class="page-container relative mx-auto bg-white px-2 py-4 grid grid-cols-3 gap-x-6 gap-y-4 content-start"
                style="width: 285mm; height: 190mm; overflow: hidden; page-break-inside: avoid;">

                <?php foreach ($pageNinos as $n): ?>
                    <!-- Badge Item -->
                    <div class="badge-card relative overflow-hidden bg-white rounded-xl shadow-md border border-gray-200 flex flex-col"
                        style="width: 86mm; height: 54mm; page-break-inside: avoid; break-inside: avoid;">

                        <!-- Header -->
                        <div
                            class="h-[14mm] bg-gradient-to-r from-red-600 to-red-500 flex items-center justify-between px-3 relative overflow-hidden">
                            <!-- Stripes decoration -->
                            <div class="absolute right-0 top-0 h-full w-20 bg-white/10 skew-x-12 transform translate-x-10">
                            </div>

                            <div class="flex items-center gap-1.5 text-white z-10">
                                <span class="text-sm">🎁</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-white/90">Pase Navidad
                                    2025</span>
                            </div>
                            <div
                                class="z-10 bg-white/20 px-1.5 py-0.5 rounded text-[8px] font-bold text-white uppercase tracking-wider backdrop-blur-sm">
                                Novena Cuadra La 22a
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="flex-1 flex flex-row p-3 relative">
                            <!-- Left Info -->
                            <div class="w-[55%] flex flex-col justify-between pr-2 z-10">
                                <div>
                                    <h2 class="text-base font-black text-gray-800 leading-tight uppercase line-clamp-2">
                                        <?= htmlspecialchars($n['nombre_completo']) ?>
                                    </h2>
                                    <p class="text-[9px] font-medium text-gray-400 mt-0.5 uppercase tracking-wide">
                                        Participante Autorizado
                                    </p>
                                </div>

                                <div class="flex items-center gap-2 mt-2">
                                    <span
                                        class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[9px] font-bold border border-gray-200">
                                        <?= $n['edad'] ?> Años
                                    </span>
                                    <span
                                        class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-[9px] font-bold border border-gray-200">
                                        <?= $n['genero'] == 'M' ? '👦 Niño' : '👧 Niña' ?>
                                    </span>
                                </div>

                                <!-- Powered By (Larger) -->
                                <div class="mt-auto pt-2">
                                    <div class="flex flex-col text-[10px] text-gray-500 leading-none">
                                        <span class="text-[8px] uppercase tracking-wide">Patrocinado por:</span>
                                        <span class="font-black text-indigo-700 text-sm mt-0.5">GemetechIT</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right QR (Larger) -->
                            <div class="w-[45%] flex items-center justify-end">
                                <div
                                    class="bg-white p-1 rounded-lg border-2 border-dashed border-gray-300 shadow-sm relative transform scale-105 origin-right">
                                    <div
                                        class="absolute -top-1.5 -right-1.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white z-20">
                                    </div>
                                    <div id="qr-<?= $n['id'] ?>"></div>
                                </div>
                            </div>
                        </div>

                        <!-- ID Float -->
                        <div class="absolute bottom-2 right-2 text-[8px] font-mono text-gray-300 transform rotate-0 z-0">
                            #<?= $n['id'] ?>
                        </div>
                    </div>

                    <script>
                        new QRCode(document.getElementById("qr-<?= $n['id'] ?>"), {
                            text: "<?= $n['id'] ?>",
                            width: 100,
                            height: 100,
                            colorDark: "#1f2937",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    </script>
                <?php endforeach; ?>
            </div>

            <!-- Explicit Page Break for html2pdf -->
            <?php if ($pageIndex < count($chunks) - 1): ?>
                <div class="html2pdf__page-break"></div>
            <?php endif; ?>
        <?php endforeach; ?>

        <?php if (empty($ninos)): ?>
            <div class="text-center py-20 text-gray-400">
                No hay niños registrados para generar carnets.
            </div>
        <?php endif; ?>

    </div>

    <script>
        function downloadPDF() {
            const element = document.getElementById('carnetsContainer');
            const btn = document.getElementById('downloadBtn');
            const originalText = btn.innerHTML;

            btn.innerHTML = '⌛ Generando PDF (Puede tardar)...';
            btn.disabled = true;

            const opt = {
                margin: [5, 5, 5, 5],
                filename: 'Pases_Navidad_3x3.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: {
                    scale: 2, // Reduced from 3 to prevent crashes
                    useCORS: true,
                    scrollY: 0,
                    backgroundColor: '#ffffff', // Prevent black background
                    logging: false
                },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' },
                pagebreak: { mode: ['css', 'legacy'] }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }).catch(err => {
                console.error(err);
                alert('Hubo un error al generar el PDF. Intenta con menos registros o recarga la página.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        }
    </script>
</body>

</html>
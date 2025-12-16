<?php

require_once __DIR__ . '/../models/Nino.php';

class EstadisticasController
{
    public function index()
    {
        $ninoModel = new Nino();

        $stats = [
            'total' => $ninoModel->getTotal(),
            'ninos' => $ninoModel->getCountNinos(),
            'ninas' => $ninoModel->getCountNinas(),
            'edades' => $ninoModel->getAgeDistribution()
        ];

        // Calculate percentages
        $stats['porcentaje_ninos'] = $stats['total'] > 0 ? round(($stats['ninos'] / $stats['total']) * 100, 1) : 0;
        $stats['porcentaje_ninas'] = $stats['total'] > 0 ? round(($stats['ninas'] / $stats['total']) * 100, 1) : 0;

        // Also fetch list for report if needed, though report might be separate.
        // The user wants "descargar reporte como listado de niños y demas". 
        // We can pass the full list to the view to be hidden but used for PDF generation.
        $ninos = $ninoModel->getAll();

        require_once __DIR__ . '/../views/estadisticas/index.php';
    }
}

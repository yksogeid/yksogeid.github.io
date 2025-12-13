<?php

class HomeController extends Controller
{
    public function index()
    {
        $ninoModel = $this->model('Nino');
        $asistenciaModel = $this->model('Asistencia');

        // Logic from original index.php
        try {
            $ninos = $ninoModel->getAll();
            $total_ninos = count($ninos);
        } catch (Exception $e) {
            $ninos = [];
            $total_ninos = 0;
        }

        try {
            $asistencias = $asistenciaModel->getAll();
            // $total_asistencias will be calculated based on 'asistio' field in the loop below
        } catch (Exception $e) {
            $asistencias = [];
        }

        // Stats Logic
        $asistencias_por_fecha = [];
        $total_asistencias_real = 0; // Solo contar los que tienen asistio = true

        foreach ($asistencias as $asistencia) {
            // Check if 'asistio' key exists and is true
            if (isset($asistencia['asistio']) && $asistencia['asistio']) {
                $fecha = $asistencia['fecha'];
                if (!isset($asistencias_por_fecha[$fecha])) {
                    $asistencias_por_fecha[$fecha] = 0;
                }
                $asistencias_por_fecha[$fecha]++;
                $total_asistencias_real++;
            }
        }

        // Update total_asistencias to reflect only true attendances if that's desired for all stats,
        // or just use a new variable. Logic implied count($asistencias) was total before.
        // Let's replace total_asistencias with the real count.
        $total_asistencias = $total_asistencias_real;

        krsort($asistencias_por_fecha);

        $promedio_asistencia = $total_ninos > 0 && count($asistencias_por_fecha) > 0
            ? round($total_asistencias / count($asistencias_por_fecha), 1)
            : 0;

        $fecha_max_asistencia = "";
        $max_asistencia = 0;
        foreach ($asistencias_por_fecha as $fecha => $cantidad) {
            if ($cantidad > $max_asistencia) {
                $max_asistencia = $cantidad;
                $fecha_max_asistencia = $fecha;
            }
        }

        $porcentaje_asistencia = $total_ninos > 0 && count($asistencias_por_fecha) > 0
            ? round(($promedio_asistencia / $total_ninos) * 100)
            : 0;

        // Pass data to view
        $this->view('home/index', [
            'total_ninos' => $total_ninos,
            'total_asistencias' => $total_asistencias,
            'promedio_asistencia' => $promedio_asistencia,
            'asistencias_por_fecha' => $asistencias_por_fecha,
            'fecha_max_asistencia' => $fecha_max_asistencia,
            'max_asistencia' => $max_asistencia,
            'porcentaje_asistencia' => $porcentaje_asistencia
        ]);
    }
}

<?php

class AsistenciaController extends Controller
{
    public function create()
    {
        $ninoModel = $this->model('Nino');
        $asistenciaModel = $this->model('Asistencia');
        $ninos = [];
        $asistencia_hoy = [];

        try {
            $ninos = $ninoModel->getAll();
            $hoy = date("Y-m-d");
            $records = $asistenciaModel->getByDate($hoy);

            // Map records to array of nino_id => true
            foreach ($records as $record) {
                if ($record['asistio']) {
                    $asistencia_hoy[$record['nino_id']] = true;
                }
            }
        } catch (Exception $e) {
            // handle error
        }

        $this->view('asistencia/create', [
            'ninos' => $ninos,
            'asistencia_hoy' => $asistencia_hoy,
            'mensaje' => '',
            'fecha_formateada' => $this->getFechaFormateada()
        ]);
    }

    public function store()
    {
        $mensaje = "";
        $fecha = date("Y-m-d");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $ninoModel = $this->model('Nino');
            $asistenciaModel = $this->model('Asistencia');

            try {
                $todos_ninos = $ninoModel->getAll();
            } catch (Exception $e) {
                $todos_ninos = [];
            }

            $checked_ids = isset($_POST["asistencia"]) ? $_POST["asistencia"] : [];
            $total_asistentes = count($checked_ids);

            // Lista unificada para guardar (Update/Insert)
            $to_save = [];

            foreach ($todos_ninos as $nino) {
                $id = $nino['id'];

                // Si está marcado = true, si no = false
                $asistio = isset($checked_ids[$id]);

                $to_save[] = [
                    "nino_id" => $id,
                    "fecha" => $fecha,
                    "asistio" => $asistio
                ];
            }

            // Ejecutar operación masiva (1 sola petición)
            try {
                if (!empty($to_save)) {
                    $asistenciaModel->saveBatch($to_save);
                }
            } catch (Exception $e) {
            }

            if ($total_asistentes > 0) {
                $mensaje = "✅ Asistencia actualizada: $total_asistentes niño(s) presente(s)";
            } else {
                $mensaje = "⚠️ Asistencia actualizada: No hay niños presentes hoy";
            }
        }

        // Fetch ninos again for the view
        $ninoModel = $this->model('Nino');
        $asistenciaModel = $this->model('Asistencia'); // Need this to show updated checks
        $ninos = [];
        $asistencia_hoy = [];

        try {
            $ninos = $ninoModel->getAll();
            $records = $asistenciaModel->getByDate($fecha);
            foreach ($records as $record) {
                if ($record['asistio']) {
                    $asistencia_hoy[$record['nino_id']] = true;
                }
            }
        } catch (Exception $e) {
            $ninos = [];
        }

        $this->view('asistencia/create', [
            'ninos' => $ninos,
            'asistencia_hoy' => $asistencia_hoy,
            'mensaje' => $mensaje,
            'fecha_formateada' => $this->getFechaFormateada()
        ]);
    }

    private function getFechaFormateada()
    {
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        return date('d') . ' de ' . $meses[date('n') - 1] . ' de ' . date('Y');
    }
}

<?php

class NinosController extends Controller
{
    public function create()
    {
        $ninoModel = $this->model('Nino');
        try {
            $ninos = $ninoModel->getAll();
            $total_ninos = count($ninos);
        } catch (Exception $e) {
            $total_ninos = 0;
        }

        $this->view('ninos/create', [
            'total_ninos' => $total_ninos,
            'ninos' => $ninos
        ]);
    }

    public function store()
    {
        $mensaje = "";
        $tipo_mensaje = "";
        $old = $_POST;

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            try {
                $nombre = trim($_POST["nombre"]);
                $edad = intval($_POST["edad"]);
                $genero = isset($_POST["genero"]) ? $_POST["genero"] : "";

                // Validaciones
                if (empty($nombre)) {
                    $mensaje = "⚠️ El nombre no puede estar vacío";
                    $tipo_mensaje = "warning";
                } elseif ($edad < 1 || $edad > 10) {
                    $mensaje = "⚠️ La edad debe estar entre 1 y 10 años";
                    $tipo_mensaje = "warning";
                } elseif (!in_array($genero, ['M', 'F'])) {
                    $mensaje = "⚠️ Debes seleccionar un género válido";
                    $tipo_mensaje = "warning";
                } else {
                    $data = [
                        "nombre_completo" => $nombre,
                        "edad" => $edad,
                        "genero" => $genero
                    ];

                    $ninoModel = $this->model('Nino');
                    $ninoModel->create($data);

                    $mensaje = "✅ ¡$nombre ha sido registrado exitosamente!";
                    $tipo_mensaje = "success";
                    $old = []; // Clear form on success
                }
            } catch (Exception $e) {
                $mensaje = "❌ Error al registrar: " . $e->getMessage();
                $tipo_mensaje = "error";
            }
        }

        // Get count for view
        try {
            $ninos = $this->model('Nino')->getAll(); // efficient? maybe not but okay for now
            $total_ninos = count($ninos);
        } catch (Exception $e) {
            $total_ninos = 0;
        }

        // Pass message back to view
        $this->view('ninos/create', [
            'mensaje' => $mensaje,
            'tipo_mensaje' => $tipo_mensaje,
            'old' => $old,
            'total_ninos' => $total_ninos,
            'ninos' => $ninos
        ]);
    }
    public function carnets()
    {
        $ninoModel = $this->model('Nino');
        try {
            $ninos = $ninoModel->getAll();
        } catch (Exception $e) {
            $ninos = [];
        }

        $this->view('ninos/carnets', [
            'ninos' => $ninos
        ]);
    }
}

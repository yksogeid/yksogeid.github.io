<?php

class CompartirController extends Controller
{
    public function index()
    {
        $compartirModel = $this->model('CompartirNovena');
        try {
            $compartires = $compartirModel->getAll();
        } catch (Exception $e) {
            $compartires = [];
        }

        $this->view('compartir/index', [
            'compartires' => $compartires
        ]);
    }

    public function create()
    {
        $ninoModel = $this->model('Nino');
        try {
            $ninos = $ninoModel->getAll();
        } catch (Exception $e) {
            $ninos = [];
        }

        $this->view('compartir/create', [
            'ninos' => $ninos
        ]);
    }

    public function store()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nino_id = $_POST['nino_id'] ?? '';
            $nombre_responsable = trim($_POST['nombre_responsable'] ?? '');
            $relacion = $_POST['relacion'] ?? '';
            $fecha = $_POST['fecha'] ?? '';

            try {
                if (empty($nino_id) || empty($nombre_responsable) || empty($relacion) || empty($fecha)) {
                    throw new Exception("Todos los campos son obligatorios.");
                }

                $data = [
                    'nino_id' => $nino_id,
                    'nombre_responsable' => $nombre_responsable,
                    'relacion' => $relacion,
                    'fecha' => $fecha
                ];

                $this->model('CompartirNovena')->create($data);

                // Redirect to index with success?
                // Basic PHP redirect for now.
                header('Location: ' . BASE_URL . 'compartir');
                exit;

            } catch (Exception $e) {
                $ninoModel = $this->model('Nino');
                $ninos = $ninoModel->getAll();

                $this->view('compartir/create', [
                    'error' => $e->getMessage(),
                    'ninos' => $ninos,
                    'old' => $_POST
                ]);
            }
        }
    }

    public function edit($id)
    {
        if (!$id) {
            header('Location: ' . BASE_URL . 'compartir');
            exit;
        }

        $compartirModel = $this->model('CompartirNovena');
        $item = $compartirModel->getById($id);

        if (!$item) {
            header('Location: ' . BASE_URL . 'compartir');
            exit;
        }

        $ninoModel = $this->model('Nino');
        $ninos = $ninoModel->getAll();

        $this->view('compartir/edit', [
            'item' => $item,
            'ninos' => $ninos
        ]);
    }

    public function update($id)
    {
        if (!$id || $_SERVER["REQUEST_METHOD"] !== "POST") {
            header('Location: ' . BASE_URL . 'compartir');
            exit;
        }

        $nino_id = $_POST['nino_id'] ?? '';
        $nombre_responsable = trim($_POST['nombre_responsable'] ?? '');
        $relacion = $_POST['relacion'] ?? '';
        $fecha = $_POST['fecha'] ?? '';

        try {
            if (empty($nino_id) || empty($nombre_responsable) || empty($relacion) || empty($fecha)) {
                throw new Exception("Todos los campos son obligatorios.");
            }

            $data = [
                'nino_id' => $nino_id,
                'nombre_responsable' => $nombre_responsable,
                'relacion' => $relacion,
                'fecha' => $fecha
            ];

            $this->model('CompartirNovena')->update($id, $data);
            header('Location: ' . BASE_URL . 'compartir');
            exit;

        } catch (Exception $e) {
            // Fetch data again to show form with error
            $compartirModel = $this->model('CompartirNovena');
            $item = $compartirModel->getById($id);
            $ninoModel = $this->model('Nino');
            $ninos = $ninoModel->getAll();

            $this->view('compartir/edit', [
                'error' => $e->getMessage(),
                'item' => $item, // Keep original item or merge with POST? Using item for ID mostly.
                'ninos' => $ninos,
                'old' => $_POST // Use old input
            ]);
        }
    }

    public function delete($id)
    {
        if ($id) {
            $this->model('CompartirNovena')->delete($id);
        }
        header('Location: ' . BASE_URL . 'compartir');
        exit;
    }
}

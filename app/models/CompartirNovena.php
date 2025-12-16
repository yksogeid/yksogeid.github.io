<?php
require_once __DIR__ . '/../core/Database.php';

class CompartirNovena
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        // Join with ninos to get the child's name
        $sql = "SELECT cn.*, n.nombre_completo 
                FROM compartir_novena cn 
                LEFT JOIN ninos n ON cn.nino_id = n.id 
                ORDER BY cn.fecha DESC";
        $results = $this->db->query($sql);

        // Map to match view expectation: item['ninos']['nombre_completo']
        $mapped = [];
        foreach ($results as $row) {
            $row['ninos'] = ['nombre_completo' => $row['nombre_completo'] ?? 'Desconocido'];
            $mapped[] = $row;
        }
        return $mapped;
    }

    public function getById($id)
    {
        $result = $this->db->query("SELECT * FROM compartir_novena WHERE id = ?", [$id]);
        return !empty($result) ? $result[0] : null;
    }

    public function create($data)
    {
        $keys = array_keys($data);
        $fields = implode(", ", $keys);
        $placeholders = ":" . implode(", :", $keys);

        $sql = "INSERT INTO compartir_novena ($fields) VALUES ($placeholders)";

        return $this->db->query($sql, $data);
    }

    public function update($id, $data)
    {
        $setParts = [];
        foreach ($data as $key => $value) {
            $setParts[] = "$key = :$key";
        }
        $setStr = implode(", ", $setParts);

        $sql = "UPDATE compartir_novena SET $setStr WHERE id = :id_pk";
        $data['id_pk'] = $id;

        return $this->db->query($sql, $data);
    }

    public function delete($id)
    {
        return $this->db->query("DELETE FROM compartir_novena WHERE id = ?", [$id]);
    }
}

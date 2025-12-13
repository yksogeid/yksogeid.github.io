<?php
require_once __DIR__ . '/../core/Database.php';

class Asistencia
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        return $this->db->request("asistencia");
    }

    public function getByDate($fecha)
    {
        return $this->db->request("asistencia", "GET", null, "?fecha=eq." . $fecha);
    }

    public function saveBatch($data)
    {
        if (empty($data))
            return;
        // Upsert on conflict id, fecha (Bulk)
        return $this->db->request("asistencia", "POST", $data, "?on_conflict=nino_id,fecha");
    }

    public function deleteBatch($nino_ids, $fecha)
    {
        if (empty($nino_ids))
            return;
        $ids_string = implode(',', $nino_ids);
        return $this->db->request("asistencia", "DELETE", null, "?nino_id=in.(" . $ids_string . ")&fecha=eq." . $fecha);
    }

    // Helper methods for stats can go here if we want to thinner controllers
}

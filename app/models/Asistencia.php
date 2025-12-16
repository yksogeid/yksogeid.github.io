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
        return $this->db->query("SELECT * FROM asistencia");
    }

    public function getByDate($fecha)
    {
        return $this->db->query("SELECT * FROM asistencia WHERE fecha = ?", [$fecha]);
    }

    public function saveBatch($data)
    {
        if (empty($data))
            return;

        $values = [];
        $params = [];
        foreach ($data as $i => $row) {
            $nKey = ":n" . $i;
            $fKey = ":f" . $i;
            $aKey = ":a" . $i;

            $values[] = "($nKey, $fKey, $aKey)";

            $params[$nKey] = $row['nino_id'];
            $params[$fKey] = $row['fecha'];
            $params[$aKey] = $row['asistio'] ? 1 : 0;
        }

        $valuesStr = implode(", ", $values);
        $sql = "INSERT INTO asistencia (nino_id, fecha, asistio) VALUES $valuesStr 
                ON DUPLICATE KEY UPDATE asistio = VALUES(asistio)";

        return $this->db->query($sql, $params);
    }

    public function deleteBatch($nino_ids, $fecha)
    {
        if (empty($nino_ids))
            return;

        $placeholders = implode(',', array_fill(0, count($nino_ids), '?'));
        $sql = "DELETE FROM asistencia WHERE fecha = ? AND nino_id IN ($placeholders)";

        $params = array_merge([$fecha], $nino_ids);
        return $this->db->query($sql, $params);
    }

    // Helper methods for stats can go here if we want to thinner controllers
}

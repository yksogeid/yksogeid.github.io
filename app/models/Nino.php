<?php
require_once __DIR__ . '/../core/Database.php';

class Nino
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM ninos ORDER BY nombre_completo ASC");
    }

    public function create($data)
    {
        $keys = array_keys($data);
        $fields = implode(", ", $keys);

        // Create placeholders like :nombre_completo, :edad
        $placeholders = ":" . implode(", :", $keys);

        $sql = "INSERT INTO ninos ($fields) VALUES ($placeholders)";

        return $this->db->query($sql, $data);
    }
    public function getCountNinos()
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM ninos WHERE genero = 'M'");
        return $result[0]['count'] ?? 0;
    }

    public function getCountNinas()
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM ninos WHERE genero = 'F'");
        return $result[0]['count'] ?? 0;
    }

    public function getTotal()
    {
        $result = $this->db->query("SELECT COUNT(*) as count FROM ninos");
        return $result[0]['count'] ?? 0;
    }

    public function getAgeDistribution()
    {
        return $this->db->query("SELECT edad, COUNT(*) as count FROM ninos GROUP BY edad ORDER BY edad ASC");
    }
}

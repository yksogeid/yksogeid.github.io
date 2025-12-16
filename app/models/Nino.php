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
}

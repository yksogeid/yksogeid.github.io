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
        return $this->db->request("ninos");
    }

    public function create($data)
    {
        return $this->db->request("ninos", "POST", $data);
    }
}

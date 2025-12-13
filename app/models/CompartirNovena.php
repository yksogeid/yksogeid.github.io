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
        // Supabase PostgREST syntax for join: select=*,ninos(nombre_completo)
        return $this->db->request("compartir_novena", "GET", null, "?select=*,ninos(nombre_completo)");
    }

    public function getById($id)
    {
        $data = $this->db->request("compartir_novena", "GET", null, "?id=eq." . $id);
        return !empty($data) ? $data[0] : null;
    }

    public function create($data)
    {
        return $this->db->request("compartir_novena", "POST", $data);
    }

    public function update($id, $data)
    {
        return $this->db->request("compartir_novena", "PATCH", $data, "?id=eq." . $id);
    }

    public function delete($id)
    {
        return $this->db->request("compartir_novena", "DELETE", null, "?id=eq." . $id);
    }
}

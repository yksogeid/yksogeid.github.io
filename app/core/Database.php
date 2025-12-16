<?php

class Database
{
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    private $charset = DB_CHARSET;
    public $pdo;
    public $error;

    public function __construct()
    {
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=" . $this->charset;
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            throw new Exception("Connection failed: " . $this->error);
        }
    }

    /**
     * Prepare and execute a query
     * @param string $sql
     * @param array $params
     * @return array|bool Returns array of results for SELECT, true/false for others or lastInsertId if needed
     */
    public function query($sql, $params = [])
    {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);

            // Check if there are columns to fetch (SELECT, SHOW, DESCRIBE, etc.)
            if ($stmt->columnCount() > 0) {
                return $stmt->fetchAll();
            }

            // For INSERT, UPDATE, DELETE return row count
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}

<?php

//class to connect to the database (singleton)
class DBManager
{
    private static ?DBManager $instance = null;

    private PDO $db;

    //open the connection with pdo
    private function __construct()
    {
        $this->db = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    //get the instance, create it if needed
    public static function getInstance(): DBManager
    {
        if (!self::$instance) {
            self::$instance = new DBManager();
        }
        return self::$instance;
    }

    //run a query, use a prepared statement if there are params
    public function query(string $sql, ?array $params = null): PDOStatement
    {
        if ($params === null) {
            $query = $this->db->query($sql);
        } else {
            $query = $this->db->prepare($sql);
            $query->execute($params);
        }
        return $query;
    }

    //id of the last inserted row
    public function lastInsertId(): string
    {
        return $this->db->lastInsertId();
    }
}

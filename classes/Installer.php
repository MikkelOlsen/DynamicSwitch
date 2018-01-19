<?php

class Installer extends \PDO 
{
    private $db = null;
    
    public function __construct(DB $db) 
    {
        $this->db = $db;
    }

    public function createDatabase(string $dbName)
    {
            $check = $this->db->query("SHOW DATABASES LIKE :dbName", [':dbName' => $dbName]);
            if($check->fetch()) {
                return true;
            }
            return false;
        
    }
}
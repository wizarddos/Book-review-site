<?php

class Database{
    private string $dsn;
    private string $username;
    private string $password;

    public function __construct()
    {
        if(require_once "../data/connect.php"){
            $this->dsn = $db_dsn;
            $this->username = $db_user;
            $this->password = $db_pass;
        }
    }


    public function runQuery(string $query, array $arg){
        $sql = $query;
        try{
            $db = new PDO($this->dsn, $this->username, $this->password);
            $stmt = $db->prepare($sql);
            $stmt->execute($arg);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $db = null;
            return $result;
        }catch(PDOException $e){
            return ['error' => $e->getMessage()];
        }
    }
}

$db = new Database();
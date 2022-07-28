<?php

class Database{
    private string $dsn;
    private string $username;
    private string $password;

    public function __construct()
    {
        $this->dsn = "mysql:host=".$_SERVER['SERVER_NAME'].";dbname=book-site";;
        $this->username = 'root';
        $this->password = '';
    }


    public function runQuery(string $query, array $arg = []){
        $sql = $query;
        try{
            $db = new PDO($this->dsn, $this->username, $this->password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
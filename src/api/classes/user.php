<?php

class User{
    private string $username;
    private int $id;
    private string $email;
    private string $ip;
    private bool $isAdmin;
    private object $db;

    public function __construct()
    {
        include("database.php");
        $this->username = "";
        $this->id = 0;
        $this->email = "";
        $this->ip = $_SERVER['REMOTE_ADDR'];
        $this->db = new Database();
    }

    public function logIn(array $request) : bool{
        $username = $request['username'];
        $pass = $request['password'];
 
        $sql = "SELECT * FROM users WHERE username = :username";

        $usernameResults = $this->db->runQuery($sql, [':username' => $username]);


        if(!empty($usernameResults) && !isset($usernameResults['error'])){
            $user = $usernameResults[0];
            if(password_verify($pass, $user['pass'])){
                
                $this->username = $user['username'];
                $this->id = $user['id'];
                $this->email = $user['email'];
                $this->ip = $_SERVER['REMOTE_ADDR'];
                $this->isAdmin = $user['isAdmin'];

                $_SESSION['auth-token'] = base64_encode(json_encode([
                    'username' => $this->username,
                    'id' => $this->id,
                    'email' => $this->email,
                    'ip' => $this->ip,
                    'isAdmin' => $this->isAdmin
                ]));
                return true;
            }
        }

        return false;

    }

    public function logout(){
        session_unset();

        header('Location: ../../public');
        return true;
    }

    public function register($data){
        $username = htmlentities($data['username'], ENT_HTML5, 'UTF-8');
        $email = htmlentities($data['email'], ENT_QUOTES, 'UTF-8');
        $pass = htmlentities($data['password'], ENT_HTML5, 'UTF-8');
        $repeated = htmlentities($data['repeated'], ENT_HTML5, 'UTF-8');
        $isOk = true;
        if($pass!==$repeated){
            $isOk = false;
            
        }
        

        if($isOk){
            $sql = 'SELECT `username`, `email` FROM `users` WHERE username = ?';
            $result = $this->db->runQuery($sql, [$username]);
            if(empty($result)){
                $sql = 'SELECT `username`, `email` FROM `users` WHERE email = ?';
                $result = $this->db->runQuery($sql, [$email]);
                if(empty($result)){
                    
                    $sql = 'INSERT INTO `users` VALUES(?, ?, ?, ?, ?, ?)';
                    
                    $result = $this->db->runQuery($sql, [NULL, $username, password_hash($pass, PASSWORD_DEFAULT), $email, '', false]);
                    return true;
                }
            }
        }
        return false;

    }
}
<?php
class User{
    private string $username;
    private int $id;
    private string $email;
    private string $ip;

    public function __construct()
    {
        $this->username = "";
        $this->id = 0;
        $this->email = "";
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function logIn(array $request) : bool{
        $username = $request['username'];
        $pass = $request['password'];

        require_once "database.php";

        $sql = "SELECT * FROM users WHERE username = :username";

        $usernameResults = $db->runQuery($sql, [':username' => $username]);


        if(!empty($usernameResults) && !isset($usernameResults['error'])){
            $user = $usernameResults[0];
            if(password_verify($pass, $user['pass'])){
                
                $this->username = $user['username'];
                $this->id = $user['id'];
                $this->email = $user['email'];
                $this->ip = $_SERVER['REMOTE_ADDR'];

                $_SESSION['auth-token'] = base64_encode(json_encode([
                    'username' => $this->username,
                    'id' => $this->id,
                    'email' => $this->email,
                    'ip' => $this->ip
                ]));
                return true;
            }
        }

        return false;

    }
}
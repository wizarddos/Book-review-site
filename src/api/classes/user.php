<?php

class User{
    private string $username;
    private int $id;
    private string $email;
    private string $ip;
    private bool $isAdmin;

    private object $db;
    private object $eventlog;

    public function __construct()
    {
        include("database.php");
        require_once "eventlog.php";

        $this->username = "";
        $this->id = 0;
        $this->email = "";
        $this->ip = $_SERVER['REMOTE_ADDR'];

        $this->db = new Database();
        $this->eventlog = new Eventlog();
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

                if($this->eventlog->logEvent(EVENT_TYPE_LOGIN, $_SESSION['auth-token'])){
                    return true;
                }

                return false;
            }
        }

        return false;

    }

    public function logout(){
        
        if($this->eventlog->logEvent(EVENT_TYPE_LOGOUT, $_SESSION['auth-token'])){
            session_unset();
            header('Location: ../../public');
            return true;
        }
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

    public function changeEmail(array $request){
        $email = filter_var($request['newEmail'], FILTER_VALIDATE_EMAIL) ?? null;

        $email = htmlentities($email, ENT_QUOTES, 'UTF-8');


        print_r($email);
        $sql = 'SELECT * FROM `users` WHERE email = ?';
        $result = $this->db->runQuery($sql, [$email]);

        if(count($result) > 0)
            return false;

        $sql = 'UPDATE `users` SET email = ? WHERE id = ?';

        $result = $this->db->runQuery($sql, [$email, json_decode(base64_decode($_SESSION['auth-token']))->id]);
        if($this->eventlog->logEvent(EVENT_TYPE_CHANGE_MAIL, $_SESSION['auth-token'])){
            return true;
        }

        return false;
    }

    public function changePass(array $request){
        $old = $request['oldPass'];
        $new = $request['newPass'];
        $repeated = $request['repeatPass'];
        $id = json_decode(base64_decode($_SESSION['auth-token']))->id;

        if($id){
            $sql = 'SELECT * FROM `users` WHERE `id` = ?';
            $result = $this->db->runQuery($sql, [$id])[0];
            
            if(password_verify($old, $result['pass'])){
                if($repeated === $new){
                    $sql = "UPDATE `users` SET `pass` = ? WHERE `id` = ?";
                    $result = $this->db->runQuery($sql, [password_hash($new, PASSWORD_DEFAULT), $id]);

                    if($this->eventlog->logEvent(EVENT_TYPE_CHANGE_PASS, $_SESSION['auth-token'])){
                        return true;
                    }

                }
            }
        }
    }

    public function showFriends(string $token){
        if($_SESSION['auth-token'] !== $token){
            return false;
        }
        $sql = 'SELECT * FROM `users` WHERE `id` = ?';
        $id = json_decode(base64_decode($token))->id;

        $result = $this->db->runQuery($sql, [$id])[0];
        if(empty($result['friends'])){
            echo '<p>Nie masz dodanych przyjaciół</p>';
        }else{
            $friends = explode(', ', $result['friends']);
            foreach($friends as $friend){
                $result = $this->db->runQuery($sql, [$friend])[0];
                $name = $result['username'];
                $id = $result['id'];

                echo<<<END
                    <a href = "user.php?userid=">$name</a>
                    <a class = "text-danger" href = "../src/api/userController.php?action=deleteFriend&friendid=$id">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a><br/>
                END;
            }

            return true;
        }

        
    }

    public function addFriend($request, $token){
        if(!is_numeric($request['friendsid']) || $token !== $_SESSION['auth-token']){
            return false;
        }

        $friendid = $request['friendsid'];
        $sql = 'SELECT * FROM `users` WHERE `id` = ?';
        $result = $this->db->runQuery($sql, [$friendid]);
        if(!empty($result[0])){
            $userID = json_decode(base64_decode($token))->id;

            $result = $this->db->runQuery($sql, [$userID])[0];

            if(stristr($result['friends'], $friendid)){
                return false;
            }

            if(empty($result['friends'])){
                $friends = $friendid;
            }else{
                $friends = $result['friends'].', '.$friendid;
            }


            $sql = 'UPDATE `users` SET `friends` = ? WHERE `id` = ?';

            $result = $this->db->runQuery($sql, [$friends, $userID]);

            if($this->eventlog->logEvent(EVENT_TYPE_ADD_FRIEND, $_SESSION['auth-token'])){
                return true;
            }
        }else{
            return false;
        }
        return false;
    }

    public function deleteFriend($request, $token){
        if($token !== $_SESSION['auth-token']){
            return false;
        }

        if(!is_numeric($request['friendid'])){
            return false;
        }

        $friendToDelete = $request['friendid'];
        $userID = json_decode(base64_decode($token))->id;
        $sql = 'SELECT * FROM `users` WHERE `id` = ?';

        $result = $this->db->runQuery($sql, [$userID])[0];
        $friends = explode(', ', $result['friends']);

        if(in_array($friendToDelete, $friends)){
            unset($friends[array_search($friendToDelete, $friends)]);

            $newFriends = implode(', ', $friends);
            $sql = 'UPDATE `users` SET `friends` = ? WHERE `id` = ?';
            $this->db->runQuery($sql, [$newFriends, $userID]);

            if($this->eventlog->logEvent(EVENT_TYPE_DELETE_FRIEND, $_SESSION['auth-token'])){
                return true;
            }

            return false;
        }else{
            return false;
        }
        
    }   
}

function getHandleFromID(int $id){
     $sql = "SELECT `username` FROM `users` WHERE id = ?";
     $db = new Database();
     return $db->runQuery($sql, [$id])[0]['username'];
}
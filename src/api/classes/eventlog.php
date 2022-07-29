<?php 
define('EVENT_TYPE_NEW_BOOK', 'b_newbook');
define('EVENT_TYPE_NEW_REVIEW', 'b_newreview');
define('EVENT_TYPE_BOOK_READED_PAGES', 'b_changedpages');
define('EVENT_TYPE_START_READING', 'b_startreading');

define('EVENT_TYPE_REGISTER', 'u_register');
define('EVENT_TYPE_LOGIN', 'u_login');
define('EVENT_TYPE_LOGOUT', 'u_logout');
define('EVENT_TYPE_CHANGE_PASS', 'u_changepass');
define('EVENT_TYPE_CHANGE_MAIL', 'u_chagemail');
define('EVENT_TYPE_DELETE_PROFILE', 'u_deleteprofile');

define('EVENT_TYPE_ADD_FRIEND', 'f_addfriend');
define('EVENT_TYPE_DELETE_FRIEND', 'f_deletefriend');


if(session_id() === ''){
    session_start();
}
class Eventlog{
    private object $db;
    private string $tablename;
    

    public function __construct() {

        $this->db = new Database();
        $this->tablename = 'eventlog';
    }

    public function logEvent(string $event, string $token){

        if($token !== $_SESSION['auth-token'])
            return false;
        
        $userToken = json_decode(base64_decode($token));

        $sql = 'INSERT INTO `'.$this->tablename.'` VALUES(?, ?, ?, ?, ?)';
        
        $result = $this->db->runQuery($sql, [NULL, $userToken->id, $event, date('Y-m-d'), $userToken->ip]);
        return true;
        
    }
}
<?php 
define('EVENT_TYPE_NEW_BOOK', 'b_newbook');
define('EVENT_TYPE_NEW_REVIEW', 'b_newreview');
define('EVENT_TYPE_BOOK_READED_PAGES', 'b_changedpages');
define('EVENT_TYPE_START_READING', 'b_startreading');

define('EVENT_TYPE_REGISTER', 'u_register');
define('EVENT_TYPE_CHANGE_PASS', 'u_changepass');
define('EVENT_TYPE_CHANGE_MAIL', 'u_chagemail');

define('EVENT_TYPE_ADD_FRIEND', 'f_addfriend');
define('EVENT_TYPE_DELETE_FRIEND', 'f_deletefriend');

define('ADMIN_EVENT_APPROVE_BOOK', 'a_approvebook');
define('ADMIN_EVENT_USER_BANNED', 'a_userbanned');
define('ADMIN_EVENT_USER_UNBANNED', 'a_userunbanned');
define('ADMIN_EVENT_ALTER_TABLE', 'a_altertable');



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

    public function getEvents(int $userid, string $event){
        $sql = "SELECT * FROM `".$this->tablename."` WHERE `userid` = ? AND `event` = ?";
        $result = $this->db->runQuery($sql, [$userid, $event]);
        return !empty($result) ?  $result : false;
    }
}

function fetchFollowedPeopleEvents(){
    $sql = 'SELECT * FROM `users` WHERE `id` = ?';
    $db = new Database();

    $userid = json_decode(base64_decode($_SESSION['auth-token']))->id;

    $friends = $db->runQuery($sql, [$userid])[0]['friends'];
    

    $sql = "SELECT * FROM `eventlog` WHERE `userid` IN(?) AND `event` LIKE 'b_%' ORDER BY `id` DESC LIMIT 3";
    $result = $db->runQuery($sql, [$friends] );
    

    return $result;
}

function matchDescriptionToEvent($event){
    switch($event){
        case 'b_newbook': return 'dodał książkę'; break;
        case 'b_newreview': return 'zrecenzował książkę'; break;
        case 'b_changedpages': return 'przeczytał kolejne strony książki'; break;
        case 'b_startreading': return 'zaczął nową książkę'; break;
        default: return 'wykonał nieznaną aktywność'; break;
    }
}
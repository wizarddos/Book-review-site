<?php
session_start();
require_once "classes/admin.php";
$req = json_decode(file_get_contents('php://input'));

switch($req->action){
    case 'deleteRequestedBook': echo json_encode(['status'=>deleteBook($_SESSION['auth-token'], $req)]); break;

    default: echo json_encode([]);
}
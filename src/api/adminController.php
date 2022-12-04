<?php
session_start();
require_once "classes/admin.php";
$req = !isset($_POST) ? $_GET : $_POST;

switch($req['action']){
    case 'deleteRequestedBook': echo json_encode(['status'=>deleteBook($_SESSION['auth-token'], $req)]); break;
    case 'addBook': addBook($req, $_SESSION['auth-token']) ? header('Location: ../../public/adminPanel.php') : die(); break;
    default: echo json_encode(['error' => 'No action specified']);
}
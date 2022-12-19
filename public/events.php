<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);

    if(!$userData['isAdmin']){
        header('Location: 403.php', true, 403);
        header('Location: 403.php');
    }

    require_once "../src/api/classes/admin.php";
    
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href="styles/editProfile.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <link rel = "stylesheet" href = "styles/admin.css" />
    <title>Panel Admina </title>
</head>
<body class = "background-darker">
    <?php require_once "ui/header.php" ?>
    <h2 class = "align-center">Log wydarzeń</h2>
    <form class = "form align-center" method = "POST" action = "../src/api/adminController.php">
        <input class = "input-field" type = "number" name = "userid" placeholder="ID użytkownika" />
        <input class ="input-field" type="text" name = "event" placeholder="Wydarzenie (struktura c_nazwa-eventu)"/>
        <input class = "input-field" type ="hidden" name = "action" value = "getEvents" />
        <button class ="form-submit " type="submit">Szukaj</button>
    </form>
</body>
</html>
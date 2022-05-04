<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "ui/metas.php"; ?>
    <title>Twój profil </title>
</head>
<body>
    <?php require_once "ui/header.php" ?>
    <main class = "four-el-grid-layout">
        <section class = "grid-el">
            <h1>Witaj ponownie <?php echo $userData['username'] ?></h1>
        </section>
        <section class = "grid-el">
            <h1>Kontynuuj czytanie</h1>
            <?php echo "książka" ?>
        </section>
        <section class = "grid-el">
            <h1>Witaj ponownie <?php echo $userData['username'] ?></h1>
        </section>
        <section class = "grid-el">
            <h1>Witaj ponownie <?php echo $userData['username'] ?></h1>
        </section>
    </main>
</body>
</html>
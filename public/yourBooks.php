<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
    require_once 'ui/book-card.php';
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href="styles/profile.css" />
    <title>Twój profil </title>
</head>
<body class = "background-darker">
    <?php require_once "ui/header.php" ?>

    <section class = "tabs-nav">
        <button class = "tab-nav-button button-tab active" id = "read">Przeczytane</button>
        <button class = "tab-nav-button button-tab" id = "ongoing">W trakcie</button>
        <button class = "tab-nav-button button-tab" id = "favourite">Ulubione</button>
        <button class = "tab-nav-button button-tab" id ="added">Dodane</button>
    </section>
    <div class = "tabs-container">
        <?php //! html template start ?>
        <section class = "content tab" id = "tab0">
            <?php 
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
            ?>
        </section>
        <section class = "content hidden tab" id = "tab1">
            <?php 
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
            ?>
        </section>
        <section class = "content hidden tab" id = "tab2">
            <?php 
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
            ?>
        </section>
        <section class = "content hidden tab" id = "tab3">
            <div class ="add-book">
                <a href = "addBook.php" class = "button-styled-link accept-background">Dodaj Książke</a>
            </div>
            <?php 
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
            ?>
        </section>
        <?php //! html template end ?>
    </div>

    <script src = "ui/js/tabs.js"></script>
</body>
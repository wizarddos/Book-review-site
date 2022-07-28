<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
    require_once 'ui/book-card.php';
    require_once "../src/api/classes/books.php";

    $books = new Books();
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
        <section class = "content tab" id = "tab0">
            <?php 
                $finishedBooks = $books->showBooks('finished', isset($userData), [$userData['id']]);
                foreach($finishedBooks as $readData){
                    $book = $books->fetchForCard($readData['book_id']);
                    generateCard([$book[0]['path'], $book[0]['book_title'], $book[0]['book_author'], $book[0]['book_categories'], $book[0]['date'], $book[0]['book_rate']], $book[0]['book_id']);
                }
            ?>
        </section>
        <section class = "content hidden tab" id = "tab1">
            <?php 
               $finishedBooks = $books->showBooks('read', isset($userData), [$userData['id']]);
               foreach($finishedBooks as $readData){
                   $book = $books->fetchForCard($readData['book_id']);
                   generateCard([$book[0]['path'], $book[0]['book_title'], $book[0]['book_author'], $book[0]['book_categories'], $book[0]['date'], $book[0]['book_rate']], $book[0]['book_id']);
               }
            ?>
        </section>
        <section class = "content hidden tab" id = "tab2">
            <?php 
                $finishedBooks = $books->showBooks('favourite', isset($userData), [$userData['id']]);
                foreach($finishedBooks as $readData){
                    $book = $books->fetchForCard($readData['book_reviewed_id']);
                    generateCard([$book[0]['path'], $book[0]['book_title'], $book[0]['book_author'], $book[0]['book_categories'], $book[0]['date'], $book[0]['book_rate']], $book[0]['book_id']);
                }
            ?>
        </section>
        <section class = "content hidden tab" id = "tab3">
            <div class ="add-book">
                <a href = "addBook.php" class = "button-styled-link accept-background">Dodaj Książke</a>
            </div>
            <?php 
               $finishedBooks = $books->showBooks('added', isset($userData), [$userData['id']]);
               foreach($finishedBooks as $readData){
                   $book = $books->fetchForCard($readData['book_id']);
                   generateCard([$book[0]['path'], $book[0]['book_title'], $book[0]['book_author'], $book[0]['book_categories'], $book[0]['date'], $book[0]['book_rate']], $book[0]['book_id']);
               }
            ?>
        </section>
    </div>

    <script src = "ui/js/tabs.js"></script>
</body>
<?php 
session_start();
require_once "ui/book-card.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php" ?>
    <link rel = "stylesheet" href = "styles/search-books.css">
    <link rel = "stylesheet" href = "styles/recommended-books.css">
    <title>Nowe książki</title>
</head>
<body class = "background-darker">
    <?php require_once 'ui/header.php'; ?>
    <main class = "two-el-layout grid-gap-small">
        <section class = "books grid-el grid-el-main">
            <h2>Najwyżej oceniane Książki</h2>
            <?php 
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
            ?>
            
        </section>
    </main>
</body>
</html>
<?php 
session_start();     
require_once "ui/book-card.php";
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php" ?>
    <link rel = "stylesheet" href = "styles/forms.css">
    <link rel = "stylesheet" href = "styles/search-books.css">
    <link rel = "stylesheet" href = "styles/recommended-books.css">
    <title>Szukaj Książek</title>
</head>
<body class = "background-darker">
    <?php require_once 'ui/header.php'; ?>
    <main class = "two-el-layout grid-gap-small">
        <section class = "categories grid-el grid-el-side">
            <h2>Kategorie książek</h2>
            <?php //! html template start ?>
                <ul class = "category-list">
                    <a class= "category-link" href = "category.php?category="><li>Fantasy</li></a>
                    <a class= "category-link" href = "category.php?category="><li>Kryminał</li></a>
                    <a class= "category-link" href = "category.php?category="><li>Sci-fi</li></a>
                    <a class= "category-link" href = "category.php?category="><li>Dokumentalne</li></a>

                </ul>
            <?php //! html template end ?>
        </section>
        <section class = "books grid-el grid-el-main">
            <h2>Polecane Książki</h2>
            <?php 
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
            ?>
            
        </section>
    </main>
</body>

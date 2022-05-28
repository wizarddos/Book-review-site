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
                    <a class= "category-link" href = "category.php?categoryid="><li>Fantasy</li></a>
                    <a class= "category-link" href = "category.php?categoryid="><li>Kryminał</li></a>
                    <a class= "category-link" href = "category.php?categoryid="><li>Sci-fi</li></a>
                    <a class= "category-link" href = "category.php?categoryid="><li>Dokumentalne</li></a>

                </ul>
            <?php //! html template end ?>
        </section>
        <section class = "books grid-el grid-el-main">
            <h2>Polecane Książki</h2>
            <?php 
                require 'ui/book-card.php';  
                require 'ui/book-card.php';
            ?>
            
        </section>
    </main>
</body>

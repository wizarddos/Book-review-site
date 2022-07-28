<?php 
session_start();     
require_once "ui/book-card.php";

require_once "../src/api/classes/books.php";
$books = new Books();
$recomendedBooks = $books->showBooks('recommended', isset($_SESSION['auth-token']));
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
                <ul class = "category-list">
                    <a class= "category-link" href = "category.php?category=fantasy"><li>Fantasy</li></a>
                    <a class= "category-link" href = "category.php?category=kryminal"><li>Kryminał</li></a>
                    <a class= "category-link" href = "category.php?category=sci-fi"><li>Sci-fi</li></a>
                    <a class= "category-link" href = "category.php?category=komedia"><li>Komedia</li></a>

                </ul>
        </section>
        <section class = "books grid-el grid-el-main">
            <h2>Polecane Książki</h2>
            <?php 
                foreach($recomendedBooks as $book){
                    generateCard([$book['path'], $book['book_title'], $book['book_author'], $book['book_categories'], $book['date'], $book['book_rate']], $book['book_id']);
                }
            ?>
            
        </section>
    </main>
</body>

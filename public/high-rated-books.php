<?php 
session_start();
require_once "ui/book-card.php";
require_once "../src/api/classes/books.php";

$books = new Books();
$highRatedBooks = $books->showBooks('highRated', isset($_SESSION['auth-token']));
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
                foreach($highRatedBooks as $book){
                    generateCard([$book['path'], $book['book_title'], $book['book_author'], $book['book_categories'], $book['date'], $book['book_rate']], $book['book_id']);
                }
            ?>
            
        </section>
    </main>
</body>
</html>
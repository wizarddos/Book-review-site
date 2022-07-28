<?php 
session_start() ;
require_once "ui/book-card.php";

require_once "../src/api/classes/books.php";
$books = new Books();
$categoryBooks = $books->showBooks('category', isset($_SESSION['auth-token']), [$_GET['category']]);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php" ?>
    <link rel = "stylesheet" href = "styles/search-books.css">
    <link rel = "stylesheet" href = "styles/recommended-books.css">
    <title>Kategoria <?php echo $_GET['category'] ?></title>
</head>
<body class = "background-darker">
    <?php require_once 'ui/header.php'; ?>
    <main class = "two-el-layout grid-gap-small">
        <section class = "books grid-el grid-el-main">
            <h2>Książki z Kategorii - <?php echo $_GET['category'] ?></h2>
            <?php 
                foreach($categoryBooks as $book){
                    generateCard([$book['path'], $book['book_title'], $book['book_author'], $_GET['category'], $book['date'], $book['book_rate']], $book['book_id']);
                }
            ?>
        </section>
    </main>
</body>
</html>
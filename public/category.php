<?php 
session_start() ;
require_once "ui/book-card.php";
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
        <?php //! PHP template start ?>
        <section class = "books grid-el grid-el-main">
            <h2>Książki z Kategorii - <?php echo $_GET['category'] ?></h2>
            <?php 
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
            ?>
        </section>
        <?php //! PHP template start ?>
    </main>
</body>
</html>
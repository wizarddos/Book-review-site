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
                require 'ui/book-card.php';  
                require 'ui/book-card.php';
            ?>
            
        </section>
    </main>
</body>
</html>
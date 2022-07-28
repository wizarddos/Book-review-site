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
    <title>Szukaj Książek</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <main class = "centered-content margined-el">
        <form method = "GET" action="../src/api/bookController.php">
            <h1>Szukaj Książek</h1>
            <input type = "text" class ="input-field" name = "search" placeholder = "Szukaj...">
            <br/>
            <input type = "hidden" name = "action" value = "searchBook">
            <input type = "submit" class = "button-grouped button-accept" value = "Szukaj">
            <button id = "filter" class = "button-grouped">Filtruj</button>
                <div class = "filter-conditions hidden">
                    <label>Szukaj
                    <input type = "hidden" name = "isFiltered" value = "0">
                    <select name = "filter" class = "input-field">
                        <option value = "author">autora</option>
                        <option value = "category">kategorii</option>
                    </select>
                    </label>
                </div>
        </form>
        <?php 
            if(isset($_SESSION['searchResults'])){
                $books = $_SESSION['searchResults'];
                foreach($books as $book){
                    generateCard([$book['path'], $book['book_title'], $book['book_author'], $book['book_categories'], $book['date'], $book['book_rate']], $book['book_id']);
                }
                
                $_SESSION['searchReults'] = "";
            }else if(isset($_SESSION['no_books'])){
                echo '<p>'.$_SESSION['no_books'].'</p>';
            }
        ?>
        <script src = "ui/js/filter.js"></script>
    </main>
</body>
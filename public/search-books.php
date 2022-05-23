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
        <form method = "GET" action = "../src/bookController.php">
            <h1>Szukaj Książek</h1>
            <input type = "text" class ="input-field" name = "search" placeholder = "Szukaj...">
            <br/>
            <input type = "hidden" name = "action" value = "searchBook">
            <input type = "submit" class = "button-grouped button-accept" value = "Szukaj">
            <button id = "filter" class = "button-grouped">Filtruj</button>
                <div class = "filter-conditions hidden">
                    <label>Szukaj tylko u
                    <input type = "hidden" name = "isFiltered" value = "0">
                    <select name = "filter" class = "input-field">
                        <option value = "author">autora</option>
                        <option value = "publisher">wydawcy</option>
                        <option value = "category">kategorii</option>
                    </select>
                    </label>
                </div>
        </form>

        <?php //!html template start ?>
            <div class = "result-book">
                <img src = "img/book-cover.jpg" class = "book-cover" alt = "okładka książki książka"/>
                <div class = "bookInfo">
                   <a href = "bookDetails.php?bookid="><h2>Książka</h2></a>
                   <a href = "authorDetails.php?authorid="><p>Autor</p></a>
                    <p>Cena</p>
                   <a href = "bookCategory.php?categoryid="> <p>Kategoria</p></a>
                   <a href = "publishers.php?publisherid="> <p>Wydawnictwo</p></a>
                    <p>Data wydania</p>
                </div>
            </div>
        <?php //!html template end ?>
        <?php //!html template start ?>
            <div class = "result-book">
                <img src = "img/book-cover.jpg" class = "book-cover" alt = "okładka książki książka"/>
                <div class = "bookInfo">
                   <a href = "bookDetails.php?bookid="><h2>Książka</h2></a>
                   <a href = "authorDetails.php?authorid="><p>Autor</p></a>
                    <p>Cena</p>
                   <a href = "bookCategory.php?categoryid="> <p>Kategoria</p></a>
                   <a href = "publishers.php?publisherid="> <p>Wydawnictwo</p></a>
                    <p>Data wydania</p>
                </div>
            </div>
        <?php //!html template end ?>
        <script src = "ui/js/filter.js"></script>
    </main>
</body>
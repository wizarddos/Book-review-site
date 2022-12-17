<?php session_start() ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href = "styles/homepage.css">
    <title>Strona Główna</title>
</head>
<body>
    <?php require_once 'ui/header.php'; require_once 'ui/book-card.php' ?>
    <main class = "main-content">
        <section class = "ad-baner">
            <div class = "ad-baner-content">
                <h1 class = "text-header-super-large">Czytanie książek jest łatwe!</h1>
                <a href = "register.php" class = "button-styled-link">Dołącz już dziś</a>
            </div>
        </section>
        <section class = "books">
            <h2>Książki z wielu gatunków czekają na ciebie</h2>

            <section class = "book-examples">

            <?php
                require_once "../src/api/classes/books.php";

                $book = new Books();

                $result = $book->showBooks('highRated', false);

                $i = 0;
                foreach($result as $book){
                    if($i == 5){
                        break;
                    }else{
                        $title = $book['book_title'];
                        $category = $book['book_categories'];
                        echo <<<END
                        <section class='book-side'>
                            <img class = 'card' src = "img/book-cover.jpg" alt = 'okładka książki' />
                            <div class="overlay">
                                    <div class = 'category'>
                                        Kategoria:  <br/>
                                            $category
                                    </div>
                                    <div class="rating">
                                        <p>Ocena: </p>
                        END;
                        getRating($book['book_rate']);
                        echo<<<END
                                    </div>
                                </div>
                            <p class = 'title'>$title</p>
                        </section>
                        END;

                        $i++;
                    }
                }
            ?>
            </section>
        </section>

        <section class = 'users'>
                <h2>Dołącz do grona</h2>
                <p class="text-enormous">
                    <?php
                        require_once "../src/api/classes/user.php";
                        echo getAllUsers()
                    ?>
                </p>
                <p>Użytkowników i bądź częścią tej społeczności!</p>
        </section>
    </main>

    <footer class = "footer">
        icons from <a href = 'https://icons8.com/'>icons8</a> <br/>
    </footer>
</body>
</html>
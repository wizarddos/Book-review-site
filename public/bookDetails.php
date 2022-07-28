<?php 
session_start(); 
require_once "../src/api/classes/books.php";
require_once "../src/api/classes/user.php";
require_once "ui/book-card.php";

$book = new Books();
$bookDetails = $book->fetchBookDetails($_GET);
$bookDetails = $bookDetails[0];

$reviews = $book->fetchReviews($_GET['bookid']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href = "styles/bookDetails.css">
    <title>Książka - <?php echo $bookDetails['book_title'] ?></title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
        <main class = "book-layout">
            <section class = "left-panel">
                <section class = "book-info">
                    <img class = "book-cover" src = "img/book-cover.jpg" alt = "Okładka książki: '<?php echo $bookDetails['book_title'] ?>'"/>
                    <section class = "left-panel-side">
                        <h1 class = "book-title"><?php echo $bookDetails['book_title'] ?></h1>
                        <p class = "book-author">Autor: <?php echo $bookDetails['book_author'] ?></p>
                    </section>
                </section>
                <form class  = "start-reading" action = "../src/api/bookController.php" method = "post">
                    <input type = "hidden" name = "bookId" value = "<?php echo $bookDetails['book_id'] ?>">
                    <input type = "hidden" name = "action" value = "startReading">
                    <input class = "start-reading-button" type = "submit" value = "Rozpocznij czytanie" />
                    <?php 
                        echo isset($_SESSION['read_err']) ? '<p class = "text-danger">'.$_SESSION['read_err'].'</p>' : '';
                        unset($_SESSION['read_err']);
                    ?>
                </form>
                <?php
                    $bookID = $bookDetails['book_id'];
                    if($book->isBookBeingRead($bookID, $_SESSION['auth-token'])){
                        echo<<<END
                            <form class = "start-reading" action="changeReadPages.php" method = 'GET'>
                                <input type = "hidden" name = "bookid" value = "$bookID">
                                <input class = "start-reading-button" type = "submit" value = "Zmień ilość przeczytanych stron" />
                            </form>
                        END;
                    }
                ?>
                
                <div class ="add-review">
                    <a href = "addBookReview.php?bookid=<?php echo $bookDetails['book_id'] ?>" class = "button-styled-link accept-background">Dodaj Recenzję</a>
                </div>
            </section>
            <section class = "right-panel">
                <section class = "book-details">
                    <h2 class = "section-header">O książce:</h2>
                    <p class = "book-desc">
                        <?php echo $bookDetails['book_desc'] ?>
                    </p>
                </section>
                <section class = "book-reviews">
                    <h2 class = "section-header">Recenzje</h2>
                    <?php
                        foreach($reviews as $review){
                            $reviewer = getHandleFromID($review['reviewer_id']);
                            $desc = $review['description'];
                            $stars = $review['stars'];
                            echo<<<END
                            <div class = "review">
                                <p class = "review-author">
                                        <img class = "review-author-avatar" src = "img/pfp.svg" alt = "Avatar"/>
                                        Autor recenzji: $reviewer 
                            END;
                            echo getRating($stars);
                            echo<<<END
                                </p>
                                <p class = "review-content">
                                    $desc
                                </p>
                            </div>
                            END;
                        }
                    ?>
                   

                    <p class = "no-more-reviews">Nie ma więcej recenzji</p>
                </section>
        </main>    
</body>
</html>
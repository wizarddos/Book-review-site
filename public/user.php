<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
    if((int)$_GET['userid'] === $userData['id']){
        header('Location: profile.php');
    }else{
        require_once "ui/book-card.php";
        require_once "../src/api/classes/books.php";
    }
}
?>

<html lang="pl">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href = "styles/bookDetails.css">
    <title>Książka</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>

        <main class = "book-layout">
            <section class = "left-panel">
                <section class = "book-info">
                   
                    <section class = "left-panel-side">
                        <h1 class = "book-title">Użytkownik - <?php echo $userData['username'] ?></h1>
                        <p class = "book-author">Ranga: <?php echo $userData['isAdmin'] ? 'Administrator' : 'Użytkownik' ?> </p>
                    </section>
                </section>
            </section>
            <section class = "right-panel">
                <section class = "book-details">
                    <h2 class = "section-header">Ostatnio Przeczytana Książka</h2>
                    <p class = "book-desc">
                        <?php
                            $books = new Books();
                            $book = $books->fetchLastReadBook((int)$_GET['userid']);
                            if($book){
                                $book = $book[0];
                                generateCard([$book['path'], $book['book_title'], $book['book_author'], $book['book_categories'], $book['date'], $book['book_rate']], $book['book_id']);
                            }else{
                                echo "<p>Twój znajomy nie skończył żadnej książki </p>";
                            }
                            
                        ?>
                    </p>
                </section>
                <section class = "book-reviews">
                    <h2 class = "section-header">Najnowsza Recenzja</h2>
                    <div class = "review">
                        <p class = "review-content">
                            <?php
                                $review = $books->fetchLastReviev((int)$_GET['userid']);

                                if($review){
                                    $review = $review[0];
                                    echo $review['description'].' - '.$books->fetchForCard($review['book_reviewed_id'])[0]['book_title'];
                                }
                            ?>
                        </p>
                    </div>
                </section>
        </main>    
</body>
</html>
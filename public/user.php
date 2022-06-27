<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
    if($_GET['userid'] === $userData['id']){
        header('Location: profile.php');
    }else{
        require_once "ui/book-card.php";
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

    <?php //! front-end template start ?>
        <main class = "book-layout">
            <section class = "left-panel">
                <section class = "book-info">
                   
                    <section class = "left-panel-side">
                        <h1 class = "book-title">Użytkownik - </h1>
                        <p class = "book-author">Dołączył: </p>
                    </section>
                </section>
            </section>
            <section class = "right-panel">
                <section class = "book-details">
                    <h2 class = "section-header">Ostatnio Przeczytana Książka</h2>
                    <p class = "book-desc">
                        <?php
                         generateCard(['img/book-cover.jpg', 'Długi Tytuł', 'autor', '20.90','Kategoria','wydawca','2022-01-03', 3]);
                        ?>
                    </p>
                </section>
                <section class = "book-reviews">
                    <h2 class = "section-header">Najnowsza Recenzja</h2>
                    <div class = "review">
                        <p class = "review-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In bibendum risus felis, sit amet dignissim dolor mattis non.
                            <br/>Aliquam mauris elit, maximus vitae lacus non, vehicula luctus dui. Maecenas sit amet tempus metus, sed placerat nulla. 
                            <br/>Sed id felis varius, posuere quam a, iaculis sem. 
                            <br/>In hac habitasse platea dictumst. 
                            <br/> Sed venenatis ligula ac est consectetur, nec pretium mauris rutrum. 
                            <br/>Donec lobortis ultrices ligula et egestas. Nulla accumsan, nisi ut viverra dapibus, nibh massa commodo ex, quis egestas ex lorem et quam.
                            <br/> Curabitur nec magna tempor quam pulvinar tempor. 
                            <br/>Curabitur pellentesque ut sapien congue pellentesque.
                        </p>
                    </div>

                    <p class = "no-more-reviews">Nie ma więcej recenzji</p>
                </section>
        </main>    
    <?php //! front-end template end ?>
</body>
</html>
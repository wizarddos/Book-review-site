<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
    require_once "../src/api/classes/books.php";

    $books = new Books();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href="styles/profile.css" />
    <title>Twój profil </title>
</head>
<body class = "background-darker">
    <?php require_once "ui/header.php" ?>
    <main  class = "three-el-grid-layout">
        <section class = "grid-el">
            <h1>Witaj ponownie <?php echo $userData['username'] ?></h1>
            <div class = "profile-options">
                <a href = "editProfile.php" class = "button-styled-link warning-background">Edytuj profil</a>
                <a href = "yourBooks.php" class = "button-styled-link warning-background">Twoje Książki</a>
                
            </div>
            <div class = "profile-options">
            <a href = "../src/api/userController.php?action=logout" class = "button-styled-link danger-background">Wyloguj się</a>
                <?php
                    if($userData['isAdmin']){
                        echo '<a href = "adminPanel.php" class = "button-styled-link danger-background">Panel Admina</a>';
                    }
                ?>
            </div>
            
        </section>
        <section class = "grid-el continue-reading">
            <h1>Kontynuuj czytanie</h1>
                <ul class = "list">
                <?php 
                    $finishedBooks = $books->showBooks('read', isset($userData), [$userData['id']]);
                    foreach($finishedBooks as $readData){
                        $book = $books->fetchForCard($readData['book_id']);
                        echo  '<a href = "bookDetails.php?bookid='.$readData['book_id'].'">'.$book[0]['book_title'].'-'.$book[0]['book_author'].'</a> <br/>';
                    }

                    if(empty($finishedBooks)){
                        echo '<p>Nie czytasz żadnych książek</p>';
                        echo '<a href = "recommended-books.php">Zacznij nową książkę</a>';
                    }
                ?>
                </ul>
        </section>
        <section class = "grid-el">
            <h1>Ostatnia aktywność twoich znajomych</h1>
            <section>
                <ul class = "list">
                    <?php //! PHP template start?> 
                        <div class = "friends-activity">
                            <a href = "user.php?userid=">{FriendName}</a>
                            <p>{read/added/deleted/started}</p>
                            <a href = "bookDetails.php?bookid=">{BookName}</a>
                        </div>
                        <div class = "friends-activity">
                            <a href = "user.php?userid=">{FriendName}</a>
                            <p>{read/added/deleted/started}</p>
                            <a href = "bookDetails.php?bookid=">{BookName}</a>
                        </div>
                    <?php   //! PHP template end ?>
                </ul>
            </section>
        </section>
    </main>
</body>
</html>
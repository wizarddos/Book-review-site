<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once 'ui/metas.php'; ?>

    <link rel = "stylesheet" href = "styles/addBookReview.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dodaj Opinie</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <main class = "centered-content ad-baner">
       <form method="POST" action="../src/api/bookController.php" class="form">
           <legend> <h1>Dodaj Recenzję dla książki: Książka</h1></legend>
           <?php require_once "ui/stars.php"; ?>
           <textarea name="review" class="review-content" cols="60" rows="10" placeholder="Wpisz swoją opinię..."></textarea><br/>
           <input type = "hidden" name = "action" value = "newReview">
           <input type = "hidden" name = "bookID" value = "<?php echo $_GET['bookid']?>">
           <input class = "form-submit" type="submit" value="Dodaj Recenzję"><br/><br/>
           <?php 
                echo isset($_SESSION['review_err']) ?  $_SESSION['review_err']  : "";
                unset($_SESSION['review_err']);
           ?>
       </form>
   </main>
    <script src = "ui/js/stars.js"></script>
</body>
</body>
</html>
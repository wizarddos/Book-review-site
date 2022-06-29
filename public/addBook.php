<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'ui/metas.php'; ?>

    <link rel = "stylesheet" href = "styles/addBookReview.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dodaj Książkę</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <?php //! html template start ?>
    <main class = "centered-content ad-baner">
       <form method="POST" action="../src/api/bookController.php" class="form">
           <legend> <h1>Dodaj Książkę</h1></legend>
           <input type = "text" name = "title" placeholder="Tytuł książki" class = "input-field" />
           <br/>
           <input type = "text" name = "author" placeholder="Autor książki" class = "input-field" />
           <br/>
           <textarea name="review" class="review-content" cols="60" rows="10" placeholder="Opis Książki"></textarea><br/>
           <input type = "hidden" name = "action" value = "newBook">
           <input class = "form-submit" type="submit" value="Dodaj Książkę"><br/><br/>
           <?php echo isset($_SESSION['review_err']) ?  $_SESSION['review_err']  : "";?>
       </form>
   </main>
    <?php //! html template end ?>
    <script src = "ui/js/stars.js"></script>
</body>
</body>
</html>
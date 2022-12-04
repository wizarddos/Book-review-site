<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    require_once "../src/api/classes/admin.php";
    
    $bookID = htmlentities($_GET['bookID'], ENT_QUOTES, "UTF-8");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'ui/metas.php'; ?>

    <link rel = "stylesheet" href = "styles/addBookReview.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <link rel = "stylesheet" href = "styles/admin.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dodaj Książkę</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <main class = "centered-content ad-baner">
       <form method="POST" action="../src/api/adminController.php" class="form">
            <legend> <h1>Uzupełnij książkę</h1></legend>
            <input type = "text" name = "cover" placeholder="Ścieżka do okładki" class = "input-field" />
            <br/>
            <input type = "number" name = "pages" placeholder="ilość stron" class = "input-field" />
            <br/>
           <label>Kategorie: <select name = "category" class = "category-select"></label>
                <?php getCategories($_SESSION['auth-token']) ?>
            </select><br/>
            <input type = "hidden" name = "action" value = "addBook">
            <input type = "hidden" name = "id" value=" <?php echo $_GET['bookID'] ?>" />
            <input class = "form-submit" type="submit" value="Dodaj Książkę"><br/><br/>
            <?php echo isset($_SESSION['review_err']) ?  $_SESSION['review_err']  : "";?>
       </form>
   </main>
    <script src = "ui/js/stars.js"></script>
</body>
</body>
</html>
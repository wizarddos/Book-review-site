<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    require_once "../src/api/classes/books.php";
    $userData = json_decode(base64_decode($_SESSION['auth-token']));
    $book = new Books();
    $bookDetails = $book->fetchBookDetails($_GET);
    $bookDetails = $bookDetails[0];

    $readDetails = $book->fetchReadDetails($userData->id, $bookDetails['book_id'])[0];
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once 'ui/metas.php'; ?>

    <link rel = "stylesheet" href = "styles/addBookReview.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <title>Książka - <?php echo $bookDetails['book_title'] ?></title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <main class = "centered-content ad-baner">
       <form method="POST" action="../src/api/bookController.php" class="form">
         <legend><h1>Zmień przeczytane strony <br/> (książka ma <?php echo $bookDetails['pages'] ?> stron)</h1></legend>
         <input class = "input-field" type="number" name = "newPages"
                min='<?php echo ($readDetails['pages_read']+1) ?>' 
                value = '<?php echo ($readDetails['pages_read']+1) ?>'
                max = '<?php echo $bookDetails['pages'] ?>'
        /><br/>
        <input type = "hidden" value = 'changeReadPages' name = 'action' />
        <input type = "hidden" value = '<?php echo  $bookDetails['book_id'] ?>' name = 'book-id' />
        <input type = "submit" class = 'form-submit button-accept' value = "Potwierdź" />
        <?php
            if(isset($_SESSION['changeReadPages_e'])){
                echo '<p class = "text-danger">'.$_SESSION['changeReadPages_e'].'</p>';
                unset($_SESSION['changeReadPages_e']);
            }
        ?>
       </form>
   </main>
</body>
</html>
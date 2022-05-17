<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'ui/metas.php'; ?>

    <link rel = "stylesheet" href = "styles/addBookReview.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dodaj Opinie</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <?php //! html template start ?>
    <main class = "centered-content ad-baner">
       <form method="POST" action="../src/api/userController.php" class="form">
           <legend> <h1>Dodaj Recenzję dla książki: Książka</h1></legend>
           <?php require_once "ui/stars.php"; ?>
           <textarea name="review" class="review-content" cols="60" rows="10" placeholder="Wpisz swoją opinię..."></textarea><br/>
           <input type = "hidden" name = "action" value = "newReview">
           <input class = "form-submit" type="submit" value="Dodaj Recenzję"><br/><br/>
           <?php echo isset($_SESSION['review_err']) ?  $_SESSION['review_err']  : "";?>
       </form>
   </main>
    <?php //! html template end ?>
    <script src = "ui/js/stars.js"></script>
</body>
</body>
</html>
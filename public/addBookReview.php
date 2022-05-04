<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once 'ui/metas.php'; ?>
    <link rel = "stylesheet" href = "css/addBookReview.css">
    <title>Dodaj Opinie</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <?php //! html template start ?>
    <main class = "centered-content ad-baner">
       <form method="POST" action="../src/api/userController.php" class="form">
           <legend> <h1>Dodaj Recenzję dla książki Książka</h1></legend>
           <?php require_once "ui/stars.php"; ?>
           <input type = "hidden" name = "action" value = "login">
           <input class = "form-submit" type="submit" value="Zaloguj się"><br/><br/>
           <?php echo isset($_SESSION['review_err']) ?  $_SESSION['review_err']  : "";?>
       </form>
   </main>
    <?php //! html template end ?>
</body>
</body>
</html>
<?php session_start();
if(isset($_SESSION['auth-token'])){
    header('Location: profile.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href = "styles/forms.css">
    <title>Zaloguj Się</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>

    <main class = "centered-content ad-baner">
       
        <form method="POST" action="../src/api/userController.php" class="form">
            <legend> <h1>Zaloguj się i wróć do swoich książek</h1></legend>
            <label>Nazwa:<input type="text" class = "input-field" name="username" placeholder="Nazwa użytkownika" required><br/></label>
            <label>Hasło:<input type="password" class = "input-field" name="password" placeholder="Hasło" required><br/></label>
            <input type = "hidden" name = "action" value = "login">
            <input class = "form-submit" type="submit" value="Zaloguj się"><br/><br/>
            <?php echo isset($_SESSION['login_err']) ?  $_SESSION['login_err']  : "";?>
            <a class = "content-link" href = "register.php">Nie masz konta? Zarejestruj się!</a>
        </form>
    </main>
</body>
</html>
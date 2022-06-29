<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php" ?>
    <link rel = "stylesheet" href = "styles/forms.css">
    <title>Zarejestruj się</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <main class = "centered-content ad-baner">
       
       <form method="POST" action="../src/api/userController.php" class="form">
           <legend> <h1>Zarejestruj się, i odkryj świat książek</h1></legend>
           <label>Nazwa:<input type="text" class = "input-field" name="username" placeholder="Nazwa użytkownika" required><br/></label>
           <label>Email:<input type="text" class = "input-field" name="email" placeholder="Adres email" required><br/></label>
           <label>Hasło:<input type="password" class = "input-field" name="password" placeholder="Hasło" required><br/></label>
           <label>Powtórz:<input type="password" class = "input-field" name="repeated" placeholder="Powtórz hasło" required><br/></label>
           <input type = "hidden" name = "action" value = "register">
           <input class = "form-submit" type="submit" value="Zarejestruj się"><br/><br/>
           <a class = "content-link" href = "login.php">Masz już konto? Zaloguj się!</a>
       </form>
    </main>
</body>
</html>
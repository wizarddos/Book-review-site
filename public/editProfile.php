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
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href="styles/editProfile.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <title>Twój profil </title>
</head>
<body class = "background-darker">
    <?php require_once "ui/header.php" ?>
    <main class = "two-el-layout grid-gap-small">
        <nav class = "grid-el grid-el-side">
            <h2>Twój Profil</h2>
            <ul class = "list">
                <li class = "spacing"><button class = "tab-nav-button link-styled-button active" >Twoje Dane</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button" >Znajomi</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button">Zmień Hasło</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button">Usuń profil</button></li>
            </ul>
        </nav>
        <section class = "grid-el grid-el-main">
            <section class = "content tab" id = "tab0">
                <h2>Twoje Dane</h2>
                <p>ID - <?php echo $userData['id'] ?></p>
                <p>Nazwa użytkownika - <?php echo $userData['username'] ?></p>
                <section class = "email">
                    <p>Email - <?php echo $userData['email'] ?></p>
                    <?php 
                        if(isset($_SESSION['e_changemail'])){
                            echo '<p class "text-danger">'.$_SESSION['e_changemail'].'</p>';
                            unset($_SESSION['e_changemail']);
                        }
                    ?>
                    <button class = "openForm" value= "changeEmail">Zmień</button>
                    <form id = "changeEmail" class = "hidden" action="../src/api/userController.php" method = 'get'>
                        <input type = "email" class = "input-field" name = "newEmail" required />
                        <input type="hidden" name='action' value='changeEmail' />
                        <button type = "submit" class = "form-submit">Zmień Email</button>
                    </form>
                </section>
            </section>
            <section class = "content hidden tab" id = "tab1">
                <h2>Twoi Znajomi</h2>
                <button class = "openForm" value= "addFriend">Zmień</button>
                <form id = "addFriend" class = "hidden" action="../src/api/userController.php?action=addFriend">
                        <input type = "number" class = "input-field" name = "friendsid" placeholder="ID znajomego"/>
                        <button type = "submit" class = "form-submit">Dodaj Znajomego</button>
                </form>
                <br/>
                <a href = "user.php?userid=">Nazwa </a>
                    <a class = "text-danger" href = "../src/api/userController.php?action=deletefriend&friendid=">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                <br/>

                <a href = "user.php?userid=">nazwa </a>
                    <a class = "text-danger" href = "../src/api/userController.php?action=deletefriend&friendid=">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
            </section>
            <section class = "content hidden tab" id = "tab2">
                <h2>Zmień Hasło</h2>
                <form method = "POST" action="../src/api/userController.php">
                    <input type = "password" class = "input-field" name = "oldPass" placeholder="Stare Hasło" /><br/>
                    <input type = "password" class = "input-field" name = "newPass" placeholder="Nowe Hasło" /><br/>
                    <input type = "password" class = "input-field" name = "repeatPass" placeholder="Powtórz hasło" /><br/>
                    <input  type = "hidden" class = "input-field" value = "editPass" name = "action" />
                    <button type = "submit" class = "form-submit">Wyślij</button>

                </form>
            </section>
            <section class = "content hidden tab" id = "tab3">
                <h2 class = "text-danger">Usuń Profil</h2>
                <button class = "danger-background" id = "delete-profile">Usuń profil</button>
                <form id = "delete-profile-form" class = "hidden" method="POST" action = "../src/api/userController.php">
                    <legend>Uwaga! Tej decyzji nie można cofnąć</legend>
                    <input type = "password" class = "input-field" placeholder="Wprowadź hasło"  required/>
                    <input type = "hidden" name = "token" value = "<?php echo $_SESSION['auth-token'] ?>" />
                    <input type = "hidden" name = "action" value = "delProfile" />
                    <button type = "submit" class = "danger-background form-submit">Usuń</button>
                </form>
            </section>
        </section>
    </main>
    <script src = "ui/js/tabs.js"></script>
    <script src = "ui/js/open-form.js"></script>
    <script>
        const deleteButton = document.querySelector('#delete-profile');
        const confirmationForm = document.querySelector('#delete-profile-form');

        deleteButton.addEventListener('click', ()=>{
            confirmationForm.classList.toggle('hidden');
        })
    </script>
</body>
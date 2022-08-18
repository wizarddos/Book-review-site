<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);
    require_once "../src/api/classes/user.php";

    $user = new User();
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
                <li class = "spacing"><button class = "tab-nav-button link-styled-button" >Obserwowani</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button">Zmień Hasło</button></li>
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
                <h2>Obserwowani</h2>
                <button class = "openForm" value= "addFriend">Zmień</button>
                <form id = "addFriend" class = "hidden" action="../src/api/userController.php">
                        <input type = "number" class = "input-field" name = "friendsid" placeholder="ID znajomego"  min = "0"/>
                        <input type = 'hidden' value = 'addFriend' name = 'action'/>
                        <button type = "submit" class = "form-submit">Obserwuj</button>
                </form>
                <br/>

                <?php
                    if(isset($_SESSION['e_friend'])){
                        echo '<p class = "text-danger">'.$_SESSION['e_friend'].'</p>';
                        unset($_SESSION['e_friend']);
                    }
                    $user->showFriends($_SESSION['auth-token']);
                ?>
                   

            </section>
            <section class = "content hidden tab" id = "tab2">
                <h2>Zmień Hasło</h2>
                <form method = "POST" action="../src/api/userController.php">
                    <input type = "password" class = "input-field" name = "oldPass" placeholder="Stare Hasło" /><br/>
                    <input type = "password" class = "input-field" name = "newPass" placeholder="Nowe Hasło" /><br/>
                    <input type = "password" class = "input-field" name = "repeatPass" placeholder="Powtórz hasło" /><br/>
                    <input  type = "hidden" class = "input-field" value = "changePass" name = "action" />
                    <button type = "submit" class = "form-submit">Wyślij</button>

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
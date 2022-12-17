<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $userData = json_decode(base64_decode($_SESSION['auth-token']), true);

    if(!$userData['isAdmin']){
        header('Location: 403.php', true, 403);
        header('Location: 403.php');
    }

    require_once "../src/api/classes/admin.php";
    
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href="styles/editProfile.css" />
    <link rel = "stylesheet" href = "styles/forms.css" />
    <link rel = "stylesheet" href = "styles/admin.css" />
    <title>Panel Admina </title>
</head>
<body class = "background-darker">
    <?php require_once "ui/header.php" ?>
    <main class = "two-el-layout grid-gap-small">
        <nav class = "grid-el grid-el-side">
            <h2 class = 'centered'>Panel Admina</h2>
            <ul class = "list">
                <li class = "spacing"><button class = "tab-nav-button link-styled-button active" >Propozycje książek</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button" >Zdarzenia</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button">Użytkownicy</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button">Edytuj Tabelę</button></li>
                <li class = "spacing"><button class = "tab-nav-button link-styled-button">Bany</button></li>
            </ul>
        </nav>
        <section class = "grid-el grid-el-main">
            <section class = "content tab" id = "tab0">
               <h2>Propozycje książek</h2>
               <table class = 'admin-table'>
                    <tr class = "header">
                        <td>Tytuł</td>
                        <td>Opis</td>
                        <td>Autor</td>
                    </tr>
                    <?php displayBooks($_SESSION['auth-token']) ?>
               </table>
            </section>
            <section class = "content hidden tab" id = "tab1">
                <h2 class = "centered">Zdarzenia</h2>
                <a href = "events.php">Przejdź do podstrony zdarzeń</a>
            </section>
            <section class = "content hidden tab" id = "tab2">
                <h2>Użytkownicy</h2>
                <table class = 'admin-table'>
                    <tr class = "header">
                        <td>id</td>
                        <td>nazwa</td>
                        <td>e-mail</td>
                    </tr>
                    <?php
                        $users = getUsers($_SESSION['auth-token']);

                        foreach($users as $user){
                            echo '<tr>';
                                echo '<td>'.$user['id'].'</td>';
                                echo $user['isBanned'] ? '<td class = "text-danger">' : "<td>";
                                echo $user['username']."</td>";
                                echo '<td>'.$user['email'].'</td>';
                                echo '<td><button class = "button-danger" id="'.$user['id'].'">Ban</button></td>';
                            echo '</tr>';
                            
                        }
                    ?>
               </table>
            </section>
            <section class="content hidden tab" id="tab3">
                <h2 class = "centered">Tabele z bazy danych</h2>
                <a href = "editTable.php">Przejdź do podstrony tabel</a>
            </section>
            <section class="content hidden tab" id="tab4">
                <h2>Bany</h2>
                <table class = 'admin-table'>
                    <tr class = "header">
                        <td>id</td>
                        <td>nazwa</td>
                        <td>e-mail</td>
                    </tr>
                    <?php
                        $users = getUsers($_SESSION['auth-token']);

                        $banned = array_filter($users, function($user){
                            return $user['isBanned'] == 1;
                        });

                        foreach($banned as $user){
                            echo '<tr>';
                                echo '<td>'.$user['id'].'</td>';
                                echo $user['isBanned'] ? '<td class = "text-danger">' : "<td>";
                                echo $user['username']."</td>";
                                echo '<td>'.$user['email'].'</td>';
                                echo '<td><button class = "button-accept" id="'.$user['id'].'">unban</button></td>';
                            echo '</tr>';
                            
                        }
                    ?>
                </table>
            </section>
        </section>
    </main>
    <script src = "ui/js/tabs.js"></script>
    <script src = "ui/js/open-form.js"></script>
    <script src = "ui/js/sendBooks.js"></script>
</body>
<?php
session_start();
if(!isset($_SESSION['auth-token'])){
    header('Location: 403.php');
}else{
    $eventData = json_decode(base64_decode($_SESSION['auth-token']), true);

    if(!$eventData['isAdmin']){
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
    <h2 class = "align-center">Log wydarzeń</h2>
    <form class = "form align-center" method = "POST" action = "../src/api/adminController.php">
        <input class = "input-field" type = "number" name = "userid" placeholder="ID użytkownika" value="<?php echo  $_SESSION['userid'] ?? null ?>" />
        <input class ="input-field" type="text" name = "event" placeholder="Wydarzenie (struktura c_nazwa-eventu)" value="<?php echo  $_SESSION['event'] ?? null ?>"/>
        <input class = "input-field" type ="hidden" name = "action" value = "getEvents" />
        <button class ="form-submit " type="submit">Szukaj</button>
    </form>

    <section class="events">

        <table class = 'admin-table'>
            <tr class = "header">
                <td>id</td>
                <td>id użytkownika</td>
                <td>wydarzenie</td>
                <td>czas</td>
                <td>ip</td>
            </tr>
            <?php
                $events = $_SESSION['getEventsResults'] ?? null;
                if($events){
                    foreach($events as $event){
                        echo '<tr>';
                            echo '<td>'.$event['id'].'</td>';
                            echo '<td>'.$event['userid'].'</td>';
                            echo '<td>'.$event['event'].'</td>';
                            echo '<td>'.$event['timestamp'].'</td>';
                            echo '<td>'.$event['ipaddress'].'</td>';
                        echo '</tr>';
                        
                    }
                    unset($_SESSION['getEventsResults']);
                }
            ?>
        </table>
    </section>

</body>
</html>
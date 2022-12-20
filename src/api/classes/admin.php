<?php

require_once 'database.php';
require_once 'eventlog.php';
$db = new Database();
$events = new Eventlog();

function addBook(array $data, string $token){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    global $db;
    global $events;

    $isValid = is_numeric($data['pages']) && is_numeric($data['id']);
    $cover = htmlentities($data['cover'], ENT_QUOTES, 'UTF-8');
    if($isValid){
        $sql = 'SELECT * FROM `books-to-check` WHERE `checkid` = ?';
        $res = $db->runQuery($sql, [$data['id']])[0];
        print_r($res);
        $sql = 'INSERT INTO `books-info` VALUES(?, ?, ?, ?, ?, ? , ?, ?, ?, ?)';

        $db->runQuery($sql, [NULL, $res['name'], $res['author'], $res['description'], $data['category'], 0, $cover, $data['pages'], $res['addedBy'], date('Y-d-m')]);

        deleteBook($token, ['bookID' => $data['id']]);

        if($events->logEvent(ADMIN_EVENT_APPROVE_BOOK, $token)){
            return true;
        }
    }
}

function getBooksToAccept(string $token){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    global $db;
    $limit = 25;

    $sql = "SELECT * FROM `books-to-check` LIMIT $limit";
    
    return $db->runQuery($sql);

    
}


function displayBooks(string $token){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    $books = getBooksToAccept($token);
    foreach($books as $book){
        echo '<tr>';
            echo '<td>'.$book['name'].'</td>';
            echo '<td>'.$book['description'].'</td>';
            echo '<td>'.$book['author'].'</td>';
            echo '<td><a href = "acceptBook.php?bookID='.$book['checkid'].'">Dodaj</a></td>';
            echo '<td><button class = "button-danger" id="'.$book['checkid'].'">Usuń</button></td>';
        echo '</tr>';
        
    }
}


function deleteBook(string $token, array $data){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    global $db;

    $bookID = is_numeric($data['bookID']) ? $data['bookID'] : null;

    if($bookID){
        $sql = 'DELETE FROM `books-to-check` WHERE `checkid` = ? ';
        return $db->runQuery($sql, [$bookID]);
    }

}

function getCategories(string $token){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    global $db;

    $sql = "SELECT DISTINCT `book_categories` FROM `books-info`";

    $categories = $db->runQuery($sql);

    foreach($categories as $category){
        echo '<option value = "'.$category['book_categories'].'">'.$category['book_categories'].'</option>';
    }
}


function getUsers(string $token){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    global $db;
    $sql = "SELECT `username`, `id`, `isBanned`, `isAdmin`, `email` FROM `users`";

    return $db->runQuery($sql);
}    

function switchBan(string $token, array $data){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    global $db, $events;
    
    $id = is_numeric($data['userID']) ? $data['userID'] : null;

    $sql = "SELECT `isBanned` FROM `users` WHERE `id` = ?";
    $result = $db->runQuery($sql, [$id])[0];

    $banUpdated = !$result['isBanned'];

    $sql = "UPDATE `users` SET `isBanned` = ? WHERE `id` = ?";
    $res = $db->runQuery($sql, [$banUpdated, $id]);
    return $events->logEvent(($banUpdated ? ADMIN_EVENT_USER_BANNED : ADMIN_EVENT_USER_UNBANNED), $token);
 
}


function getEvents(string $token, array $data){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    $_SESSION['userid'] = is_numeric($data['userid']) ? $data['userid'] : null;
    $_SESSION['event'] = htmlentities($data['event'], ENT_QUOTES, "UTF-8");

    global $events;

    if(is_null($_SESSION['userid']) || is_null($_SESSION['event'])){
        $_SESSION['getEventsResults'] = [];
        return false;
    }

    $result = $events->getEvents($_SESSION['userid'], $_SESSION['event']);
    if($result){
        $_SESSION['getEventsResults'] = $result;
        return true;
    }

}


function isAdmin(string $token){
    return json_decode(base64_decode($token))->isAdmin;
}
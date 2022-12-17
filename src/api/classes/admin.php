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


function isAdmin(string $token){
    return json_decode(base64_decode($token))->isAdmin;
}
<?php 
require_once 'database.php';
$db = new Database();

function addBook(bool $approved, array $data, string $token){

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
            echo '<td><button class = "button-accept" id="'.$book['checkid'].'">Dodaj</button></td>';
            echo '<td><button class = "button-danger" id="'.$book['checkid'].'">Usuń</button></td>';
        echo '</tr>';
        
    }
}


function deleteBook(string $token, object $data){
    !isAdmin($token) ? header('Location: ../../../public/profile.php') : null;
    global $db;

    $bookID = is_numeric($data->bookID) ? $data->bookID : null;

    if($bookID){
        $sql = 'DELETE FROM `books-to-check` WHERE `checkid` = ? ';
        return $db->runQuery($sql, [$bookID]);
    }

}
    


function isAdmin(string $token){
    return json_decode(base64_decode($token))->isAdmin;
}
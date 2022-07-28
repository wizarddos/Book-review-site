<?php 
session_start();
if(!empty($_POST)){
    $request = $_POST;
}else{
    $request = $_GET;
}

if(!isset($request['action'])){
    echo json_encode(['error' => 'No action specified']);
    exit;
}else{
    require_once "classes/books.php";
    $user = isset($_SESSION['auth-token']) ? json_decode(base64_decode($_SESSION['auth-token'])) : null;
    $book = new Books();
    
    switch($request['action']){
        case "newBook": 
            if($book->addNewBook($request, $user->id)){
                header('Location: ../../public/profile.php');
            }else{
                header("Location: ../../public/403.php");
            } break;

        case 'newReview':
            if($book->addBookReview($request, $user->id)){
                header('Location: ../../public/profile.php');
            }else{
                header("Location: ../../public/addBookReview.php?bookid=".$request['bookID']);
            } break;
        
        case 'searchBook':
            unset($_SESSION['searchResults']);
            if($result = $book->showBooks('search', isset($_SESSION['auth-token']), $request)){
                $_SESSION['searchResults'] = $result;
            }else{
                $_SESSION['no_books'] = "brak wyników";
            }
            header('Location: ../../public/search-books.php');

        case 'startReading':
            if($book->startReading($request, isset($_SESSION['auth-token']), $_SESSION['auth-token'])){
                header('Location: ../../public/profile.php');
            }else{
                header('Location: ../../public/bookDetails.php?bookid='.$request['bookId']);
            }
        
        case 'changeReadPages':
            if($book->updateReadBooks($request, $_SESSION['auth-token'])){
                header('Location: ../../public/profile.php');
            }else{
                
            }
    }

}
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
    require_once "classes/user.php";

    $_SESSION['userClass'] = new User();
    switch($request['action']){
        case 'login': 
            if($_SESSION['userClass']->logIn($request)){
                header('Location: ../../public/profile.php');
            }else{
                header('Location: ../../public/login.php');
            }
        break;
        case 'register': 
                if($_SESSION['userClass']->register($request)){
                    if($_SESSION['userClass']->logIn(['username' => $request['username'], 'password' => $request['password']])){
                        header('Location: ../../public/profile.php');
                    }
                } break;

        case 'logout': $_SESSION['userClass']->logout(); break;
        case 'changeEmail': 

            if($_SESSION['userClass']->changeEmail($request)){
                header('Location: ../../public/profile.php');
            } else{
                $_SESSION['e_changemail'] = ' Ten email jest już zajęty';
                header('Location: ../../public/editProfile.php');
            } break;

        case 'changePass': 

                if($_SESSION['userClass']->changePass($request)){
                    header('Location: ../../public/profile.php');
                } else{
                    $_SESSION['e_changepass'] = 'Niepoprawne hasło';
                    header('Location: ../../public/editProfile.php');
                } break;
            
        case 'addFriend':
            if($_SESSION['userClass']->addFriend($request, $_SESSION['auth-token'])){
                header('Location: ../../public/profile.php');
            } else{
                $_SESSION['e_friend'] = 'Taki użytkownik nie istnieje, bądź masz go już w znajomych';
                header('Location: ../../public/editProfile.php');
            } break;

        case 'deleteFriend':
            if($_SESSION['userClass']->deleteFriend($request, $_SESSION['auth-token'])){
                header('Location: ../../public/profile.php');
            } else{
                $_SESSION['e_friend'] = 'Ta osoba nie jest twoim znajomym';
                header('Location: ../../public/editProfile.php');
            } break;

        default: echo json_encode(['error' => 'No such action']);
    }
}
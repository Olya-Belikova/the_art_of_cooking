<?php
error_reporting(E_ERROR | E_PARSE);

include SITE_ROOT . "/app/database/db.php";

$errMsg = []; //массив для вывода ошибок


function userAuth($user){ //данные заносятся в супер массив $_SESSION, который содержит инф. о заголовках и инмтоположении скриптов
    $_SESSION['id'] = $user['id'];
    $_SESSION['login'] = $user['username'];
    $_SESSION['admin'] = $user['admin'];
    if($_SESSION['admin']){
        header('location: ' . BASE_URL . "admin/posts/index.php"); //если польователь являеться админом, он попадает в админ панель
    }else{
        header('location: ' . BASE_URL); //иначе открываеться главная страница
    }
}

$users = selectAll('users');

//Код бля формы РЕГИСТРАЦИИ
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-reg'])){ //отправка данных через метод POST

    $admin = 0;
    $login = trim($_POST['login']); //логин + очишает плля от лишних пробелов
    $email = trim($_POST['mail']); //mail + очишает плля от лишних пробелов
    $passF = trim($_POST['pass-first']); //пароль + очишает плля от лишних пробелов
    $passS = trim($_POST['pass-second']);

    if($login === '' || $email === '' || $passF === ''){ //проверка на пустые поля в форме
        array_push($errMsg, "Не все поля заполнены!");
    }elseif (mb_strlen($login, 'UTF8') < 2){  //проверка на введение минимального размера пороля
        array_push($errMsg, "Логин должен быть более 2-х символов");
    }elseif ($passF !== $passS) { //проверка на совпадение поролей
        array_push($errMsg, "Пароли в обеих полях должны соответствовать!");
    }else{
        $existence = selectOne('users', ['email' => $email]); //ЗАПРОС К БД "если введенный email совпадает с существуемым, то ..."
        if($existence['email'] === $email){
            array_push($errMsg, "Пользователь с такой почтой уже зарегистрирован!");
        }else{
            $pass = password_hash($passF, PASSWORD_DEFAULT); //пароль + шифровка
            $post = [ //массив для записи полученных данных
                'admin' => $admin,
                'username' => $login,
                'email' => $email,
                'password' => $pass
            ];
            $id = insert('users', $post); //отправляем запись в БД
            $user = selectOne('users', ['id' => $id] ); //нужно получить пользователя по указанному id
            userAuth($user); //сохраняет информацию в супер массиве $_SESSION
        }
    }
}else{
    //сохраняет заполненные строки в случие ошибки
    $login = '';
    $email = '';
}

//Код бля формы АВТОРИЗАЦИИ
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['button-log'])){

    $email = trim($_POST['mail']);
    $pass = trim($_POST['password']);

    if($email === '' || $pass === '') {  //проверка на пустые поля в форме
        array_push($errMsg, "Не все поля заполнены!");
    }else{
        $existence = selectOne('users', ['email' => $email]);
        if($existence && password_verify($pass, $existence['password'])){ //если существует массив $existence и пароли совпадают, то...
            userAuth($existence);
        }else{
            array_push($errMsg, "Почта либо пароль введены неверно!");
        }
    }
}else{
    $email = '';
}

// Код добавления пользователя в админке
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create-user'])){


    $admin = 0;
    $login = trim($_POST['login']);
    $email = trim($_POST['mail']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);

    if($login === '' || $email === '' || $passF === ''){ //проверка на пустые поля в форме
        array_push($errMsg, "Не все поля заполнены!");
    }elseif (mb_strlen($login, 'UTF8') < 2){
        array_push($errMsg, "Логин должен быть более 2-х символов");
    }elseif ($passF !== $passS) {
        array_push($errMsg, "Пароли в обеих полях должны соответствовать!");
    }else{
        $existence = selectOne('users', ['email' => $email]); //Обращение к БД и проверка пользователя (если 'user' существует, то...)
        if($existence['email'] === $email){
            array_push($errMsg, "Пользователь с такой почтой уже зарегистрирован!");
        }else{
            $pass = password_hash($passF, PASSWORD_DEFAULT); //иначе пользователь добавляеться в БД, в таблицу users
            if (isset($_POST['admin'])) $admin = 1;
            $user = [
                'admin' => $admin,
                'username' => $login,
                'email' => $email,
                'password' => $pass
            ];
            $id = insert('users', $user);
            $user = selectOne('users', ['id' => $id] );
            userAuth($user);
        }
    }
}else{
    $login = '';
    $email = '';
}

// Код удаления пользователя в админке
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];
    delete('users', $id);
    header('location: ' . BASE_URL . 'admin/users/index.php');
}

// РЕДАКТИРОВАНИЕ ПОЛЬЗОВАТЕЛЯ ЧЕРЕЗ АДМИНКУ
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])){
    $user = selectOne('users', ['id' => $_GET['edit_id']]);

    $id =  $user['id'];
    $admin =  $user['admin'];
    $username = $user['username'];
    $email = $user['email'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update-user'])){

    $id = $_POST['id'];
    $mail = trim($_POST['mail']);
    $login = trim($_POST['login']);
    $passF = trim($_POST['pass-first']);
    $passS = trim($_POST['pass-second']);
    $admin = isset($_POST['admin']) ? 1 : 0;

    if($login === ''){
        array_push($errMsg, "Не все поля заполнены!");
    }elseif (mb_strlen($login, 'UTF8') < 2){
        array_push($errMsg, "Логин должен быть более 2-х символов");
    }elseif ($passF !== $passS) {
        array_push($errMsg, "Пароли в обеих полях должны соответствовать!");
    }else{
        $pass = password_hash($passF, PASSWORD_DEFAULT);
        if (isset($_POST['admin'])) $admin = 1;
        $user = [
            'admin' => $admin,
            'username' => $login,
//            'email' => $mail,
            'password' => $pass
        ];

        $user = update('users', $id, $user);
        header('location: ' . BASE_URL . 'admin/users/index.php');
    }
}else{
    $id =  $user['id'];
    $admin =  $user['admin'];
    $username = $user['username'];
    $email = $user['email'];
}

/*if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['pub_id'])){
    $id = $_GET['pub_id'];
    $publish = $_GET['publish'];

    $postId = update('posts', $id, ['status' => $publish]);

    header('location: ' . BASE_URL . 'admin/posts/index.php');
    exit();
}*/
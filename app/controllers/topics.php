<?php
include SITE_ROOT . "/app/database/db.php";

$errMsg = ''; //переменная для вывода ошибок
$id = '';
$name = '';
$description = '';

$topics = selectAll('topics'); //массив всех записей в БД


//Форма создания категории
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-create'])){
    $name = trim($_POST['name']) ? trim($_POST['name']) : '';
    $description = trim($_POST['description']) ? trim($_POST['description']) : '';

    if($name === '' || $description === ''){ //проверка на пустые поля в форме
        $errMsg = "Не все поля заполнены!";
    }elseif (mb_strlen($name, 'UTF8') < 2){ //ЗАПРОС К БД "если введенный email совпадает с существуемым, то ..."
        $errMsg = "Категория должна быть более 2-х символов";
    }else{
        $existence = selectOne('topics', ['name' => $name]);
        if($existence['name'] === $name){
            $errMsg = "Такая категория уже есть в базе";
        }else{
            $topic = [
                'name' => $name,
                'description' => $description
            ];
            $id = insert('topics', $topic);
            $topic = selectOne('topics', ['id' => $id] );
            header('location: ' . BASE_URL . 'admin/topics/index.php');
        }
    }
}else{
    $name = '';
    $description = '';
}


//форма по редактированию карегирий
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])){ //Проверка глобального массива GET, в котором должен быть ID. Есть он есть, то...
    $id = $_GET['id'];
    $topic = selectOne('topics', ['id' => $id]);
    $id = $topic['id'];
    $name = $topic['name'];
    $description = $topic['description'];
}

if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['topic-edit'])){
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if($name === '' || $description === ''){ //проверка на пустые поля в форме
        $errMsg = "Не все поля заполнены!";
    }elseif (mb_strlen($name, 'UTF8') < 2){
        $errMsg = "Категория должна быть более 2-х символов";
    }else{
        $topic = [
            'name' => $name,
            'description' => $description
        ];
        $id = $_POST['id'];
        $topic_id = update('topics', $id, $topic);
        header('location: ' . BASE_URL . 'admin/topics/index.php');
    }
}

// Удаление категории
if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['del_id'])){ //Проверка глобального массива GET, в котором должен быть ID. Есть он есть, то...
    $id = $_GET['del_id'];
    delete('topics', $id);
    header('location: ' . BASE_URL . 'admin/topics/index.php');
}
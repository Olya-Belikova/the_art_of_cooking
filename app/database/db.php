<?php

session_start(); //старт сессии PHP
require 'connect.php'; //конект к файлу connect.php для доступа к БД

 //тестовая функция(отладочная)
function tt($value){ //функция принимает значение $value
    echo '<pre>';
    print_r($value); //вывод форматированного кода
    echo '</pre>';
    exit();
}
function tte($value){
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}
// Проверка выполнения запроса к БД
function dbCheckError($query){ //функция обращаеться к обекту $query
    $errInfo = $query->errorInfo();
    if ($errInfo[0] !== PDO::ERR_NONE){ //если массив $errInfo[0] не равен ошибке ERR_NONE
        echo $errInfo[2]; //выводиться переменная с индексом 2, который выводит ошибку
        exit();
    }
    return true;//в ином влучае ошибок нет
}

// Запрос на получение всех данных с одной таблицы
function selectAll($table, $params = []){ //отрибутом служит переменна я $table, которая будет являться именем таблици, к которой будет делаться запрос
    global $pdo; //глобальная переменная
    $sql = "SELECT * FROM $table"; //переменная $sql принимает переменную $table

    if(!empty($params)){ //empty() - проверяет, пуста ои переменная $params. Если параметры не пустые, то...
        $i = 0; //вспомогательная переменаая
        foreach ($params as $key => $value){ //разбираем $params на ключ($key) и значение($value)
            if (!is_numeric($value)){//если $value не являеться числом, то значение берется в ""
                $value = "'".$value."'";
            }
            if ($i === 0){ //если переменная ровна 0, то..
                $sql = $sql . " WHERE $key=$value"; //то мы обращаемся к $sql и подставляем значение $key и $value
            }else{ //иначе подставляется AND
                $sql = $sql . " AND $key=$value"; 
            }
            $i++; //инкримент
        }
    }

    $query = $pdo->prepare($sql); //обращаемся к классу PDO и через метод prepare пробрасываем переменную $sql
    $query->execute(); //команда выполнения запроса через метод execute 
    dbCheckError($query); //проверка на ошибки
    return $query->fetchAll(); //возвращаем все данные из одной таблицы
}


// Запрос на получение одной строки с выбранной таблицы
function selectOne($table, $params = []){
    global $pdo;
    $sql = "SELECT * FROM $table";

    if(!empty($params)){
        $i = 0;
        foreach ($params as $key => $value){
            if (!is_numeric($value)){
                $value = "'".$value."'";
            }
            if ($i === 0){
                $sql = $sql . " WHERE $key=$value";
            }else{
                $sql = $sql . " AND $key=$value";
            }
            $i++;
        }
    }

    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}

// Запись в таблицу БД
function insert($table, $params){ //функйия принимает значение $table(таблицы) и ее параметры
    global $pdo;
    $i = 0; //дополнительная переменная жля корректного вывода
    $coll = ''; //колонки
    $mask = ''; //значение для колонки
    foreach ($params as $key => $value) {
        if ($i === 0){ //если $i === 0, то 
            $coll = $coll . "$key"; //добавляем значние ключа без пробела и запятых
            $mask = $mask . "'" ."$value" . "'"; //добавдяем значение для колонок в строковом виде
        }else { //иначе выводим со знаками
            $coll = $coll . ", $key";
            $mask = $mask . ", '" . "$value" . "'";
        }
        $i++;
    }

    $sql = "INSERT INTO $table ($coll) VALUES ($mask)"; //запрос записи значения в БД, в таблицу

    $query = $pdo->prepare($sql);
    $query->execute($params);
    dbCheckError($query);
    return $pdo->lastInsertId(); //значение Id для будущей проверки и отследивания работы с записью
}

// Функция РЕДАКТИРОВАНИЯ строки в таблицу
function update($table, $id, $params){ //функция принимает значение таблицы, id покоторому ищет строку и параметры для редактирования
    global $pdo;
    $i = 0;
    $str = '';//строка запросов с обновленными данными
    foreach ($params as $key => $value) {
        if ($i === 0){//проверка для корректного ввода запроса
            $str = $str . $key . " = '" . $value . "'";
        }else {
            $str = $str .", " . $key . " = '" . $value . "'";
        }
        $i++;
    }

    $sql = "UPDATE $table SET $str WHERE id = $id"; //скрипт для обновления строки
    $query = $pdo->prepare($sql);
    $query->execute($params);
    dbCheckError($query);

}

// Функция УДАЛЕНИЯ строки в таблицу
function delete($table, $id){ // функция принимает таблицу и id
    global $pdo;
    //DELETE FROM `topics` WHERE id = 3
    $sql = "DELETE FROM $table WHERE id =". $id; //запрос на удаление 
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);

}
// Выборка записей (posts) с автором в админку
    function selectAllFromPostsWithUsers($table1, $table2){
        global $pdo;
        $sql = "SELECT 
        t1.id,
        t1.title,
        t1.img,
        t1.content,
        t1.status,
        t1.id_topic,
        t1.created_date,
        t2.username
        FROM $table1 AS t1 JOIN $table2 AS t2 ON t1.id_user = t2.id";
        $query = $pdo->prepare($sql);
        $query->execute();
        dbCheckError($query);
        return $query->fetchAll();

    }

// Выборка записей (posts) с автором на главную
function selectAllFromPostsWithUsersOnIndex($table1, $table2, $limit, $offset){
    global $pdo;
    $sql = "SELECT p.*, u.username FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id WHERE p.status=1 LIMIT $limit OFFSET $offset";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

// Выборка записей (posts) с автором на главную
function selectTopTopicFromPostsOnIndex($table1){
    global $pdo;
    $sql = "SELECT * FROM $table1 WHERE id_topic = 18";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();

}


// Поиск по заголовкам и содержимому (простой)
function seacrhInTitileAndContent($text, $table1, $table2){
    $text = trim(strip_tags(stripcslashes(htmlspecialchars($text))));
    global $pdo;
    $sql = "SELECT 
        p.*, u.username 
        FROM $table1 AS p 
        JOIN $table2 AS u 
        ON p.id_user = u.id 
        WHERE p.status=1
        AND p.title LIKE '%$text%' OR p.content LIKE '%$text%'";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchAll();
}

// Выборка записи (posts) с автором для синг
function selectPostFromPostsWithUsersOnSingle($table1, $table2, $id){
    global $pdo;
    $sql = "SELECT p.*, u.username FROM $table1 AS p JOIN $table2 AS u ON p.id_user = u.id WHERE p.id=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetch();
}

// Считаем количество строк в таблице
function countRow($table){
    global $pdo;
    $sql = "SELECT Count(*) FROM $table";
    $query = $pdo->prepare($sql);
    $query->execute();
    dbCheckError($query);
    return $query->fetchColumn();
}
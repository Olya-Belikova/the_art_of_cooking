<?php
        include "../../path.php";
        include "../../app/controllers/commentaries.php";
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Custom Styling -->
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Playfair+Display" />
    <link rel="icon" href="../../assets/favicon.ico">
    <title>The art of cooking</title>
</head>

<body>
    <main class="d-flex flex-column h-100">
        <?php include("../../app/include/header-admin.php"); ?>

        <div class="container">
            
            <?php include "../../app/include/sidebar-admin.php"; ?>

            <div class="posts col-9">
            <h2 class="main-header text-center">Управление комментариями</h2>
            <br>
                <div class="row title-table">
                    <div class="col-1">ID</div>
                    <div class="col-3">Комментарий</div>
                    <div class="col-2">Автор</div>
                    <div class="col-6"></div>
                </div>
                <?php foreach ($commentsForAdm as $key => $comment): ?>
                <div class="row post">
                    <div class="id col-1"><?=$comment['id']; ?></div>
                    <div class="title col-3"><?=mb_substr($comment['comment'], 0, 50, 'UTF-8'). '...'  ?></div>
                    <?php
                        $user = $comment['email'];
                        $user = explode('@', $user);
                        $user = $user[0];
                    ?>
                    <div class="author col-2"><?=$user; ?></div>
                    <div class="col-2"><a class="red" href="edit.php?id=<?=$comment['id'];?>">редактировать</a></div>
                    <div class="col-1"><a class="del" href="edit.php?delete_id=<?=$comment['id'];?>">удалить</a></div>
                    <?php if ($comment['status']): ?>
                    <div class="col-3"><a class="status"
                            href="edit.php?publish=0&pub_id=<?=$comment['id'];?>">опубликовано</a></div>
                    <?php else: ?>
                    <div class="col-3"><a class="status"
                            href="edit.php?publish=1&pub_id=<?=$comment['id'];?>">не опубликовано</a></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php include("../../app/include/footer.php"); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</html>
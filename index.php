<?php
    include "path.php";
    include "app/controllers/topics.php";

    $page = isset($_GET['page']) ? $_GET['page']: 1;
    $limit = 2;
    $offset = $limit * ($page - 1);
    $total_pages = round(countRow('posts') / $limit, 0);

    $posts = selectAllFromPostsWithUsersOnIndex('posts', 'users', $limit, $offset);
    $topTopic = selectTopTopicFromPostsOnIndex('posts');


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
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Playfair+Display" />

    <!-- Custom Styling -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="assets/favicon.ico">
    <title>The art of cooking</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include("app/include/header.php"); ?>

    <main>
        <!-- блок карусели START-->
        <div class="container">
            <div class="row">
                <h2 class="slider-title text-center">Популярные публикации</h2>
            </div>

            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner" style="height: 500px !important;">
                    <?php foreach ($topTopic as $key => $post): ?>
                    <?php if($key == 0):?>
                    <div class="carousel-item active">
                        <?php else: ?>
                        <div class="carousel-item">
                            <?php endif; ?>
                            <a href="<?=BASE_URL . 'single.php?post=' . $post['id'];?>">
                                <img src="<?=BASE_URL . 'assets/images/posts/' . $post['img'] ?>"
                                    alt="<?=$post['title']?>" class="d-block w-100">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5><?=substr($post['title'], 0, 120)?></h5>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Предыдущая</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Следующая</span>
                    </button>
                </div>
            </div>
            <!-- блок карусели END-->

            <!-- блок main-->
            <div class="container">
                <div class="content row">
                    <!-- Main Content -->
                    <div class="main-content col-md-9 col-12">
                        <h2>Последние публикации</h2>
                        <?php foreach ($posts as $post): ?>
                        <div class="post row">
                            <div class="img col-12 col-md-4">
                                <img src="<?=BASE_URL . 'assets/images/posts/' . $post['img'] ?>"
                                    alt="<?=$post['title']?>" class="img-thumbnail">
                            </div>
                            <div class="post_text col-12 col-md-8">
                                <div class="post-name"
                                    style="display: flex; justify-content:space-between; align-items: center;">
                                    <h3><a
                                            href="<?=BASE_URL . 'single.php?post=' . $post['id'];?>"><?=substr($post['title'], 0, 80)?></a>
                                    </h3>
                                    <p class="author">Aвтор: <i><?=$post['username'];?></i></p>
                                </div>
                                <i class="far fa-calendar"> <?=$post['created_date'];?></i>
                                <p class="preview-text">
                                    <?=mb_substr($post['content'], 0, 125, 'UTF-8'). '...'  ?>
                                </p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        <?php include("app/include/pagination.php"); ?>
                    </div>
                    <!-- sidebar Content -->
                    <div class="sidebar col-md-3 col-12">
                        <div class="section search">
                            <h3>Поиск</h3>
                            <form action="search.php" method="post">
                                <input type="text" name="search-term" class="text-input"
                                    placeholder="Введите запрос...">
                            </form>
                        </div>
                        <div class="section topics">
                            <h3>Категории</h3>
                            <ul>
                                <?php foreach ($topics as $key => $topic): ?>
                                <li>
                                    <a
                                        href="<?=BASE_URL . 'category.php?id=' . $topic['id']; ?>"><?=$topic['name']; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>

                </div>

            </div>
    </main>

    <!-- footer -->
    <?php include("app/include/footer.php"); ?>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>

</html>
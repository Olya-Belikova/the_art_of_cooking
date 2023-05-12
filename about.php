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

<body>

    <?php include("app/include/header.php"); ?>

    <!-- блок main-->
    <div class="container">
        <div class="content row">
            <!-- Main Content -->
            <div class="main-content col-md-9 col-12">
                <h2>О блоге &laquo;The art of cooking&raquo;</h2>
                <h2></h2>
                <p>
                    Всех нас объединяет любовь к кулинарии. Мы не боимся экспериментировать со вкусами, потому что это —
                    ключ к созданию гастрономического шедевра. На нашем сайте собраны рецепты блюд из разных стран и
                    даже самых отдаленных уголков мира. Благодаря пошаговым инструкциям, фото и видео, каждая хозяйка
                    сможет повторить их на своей кухне.
                </p>
                <p>
                <b>&laquo;The art of cooking&raquo;</b> — это не только энциклопедия простых и сложных, домашних и изысканных рецептов,
                    но и социальная сеть, на площадке которой кулинары общаются, делятся опытом и дают полезные советы.
                </p>
                <img src="assets/images/about.jpg" alt="Photo" class="mx-auto d-block w-50 img-thumbnail">
                <br>
                <div class="text-center socials">
                    <a href="#"><i class="fa-2x fab fa-facebook"></i></a>
                    <a href="#"><i class="fa-2x fab fa-instagram"></i></a>
                    <a href="#"><i class="fa-2x fab fa-twitter"></i></a>
                    <a href="#"><i class="fa-2x fab fa-youtube"></i></a>
                </div>
            </div>
            <!-- sidebar Content -->
            <div class="sidebar col-md-3 col-12">

                <div class="section search">
                    <h3>Поиск</h3>
                    <form action="search.php" method="post">
                        <input type="text" name="search-term" class="text-input" placeholder="Введите искомое слово...">
                    </form>
                </div>


                <div class="section topics">
                    <h3>Категории</h3>
                    <ul>
                        <?php foreach ($topics as $key => $topic): ?>
                        <li>
                            <a href="<?=BASE_URL . 'category.php?id=' . $topic['id']; ?>"><?=$topic['name']; ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

            </div>

        </div>

    </div>

    <!-- блок main END-->
    <!-- footer -->
    <?php include("app/include/footer.php"); ?>
    <!-- // footer -->


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
-->
</body>

</html>
<?php   include("path.php");
        include "app/controllers/users.php";
?>
<html lang="ru">

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
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Playfair+Display" />
    <link rel="icon" href="assets/favicon.ico">
    <title>The art of cooking</title>
</head>

<body class="d-flex flex-column h-100">

    <main class="flex-shrink-0">
        <?php include("app/include/header.php"); ?>
        <!-- END HEADER -->
        <!-- FORM -->
        <div class="container reg_form">
            <form class="row justify-content-center" method="post" action="log.php">
                <h2 class="col-12">Авторизация</h2>
                <div class="w-100"></div>
                <div class="mb-3 col-12 col-md-4">
                    <label for="formGroupExampleInput" class="form-label">E-mail:</label>
                    <input name="mail" value="<?=$email?>" type="email" class="form-control" id="exampleInputEmail1"
                        aria-describedby="emailHelp" placeholder="E-mail">
                </div>
                <div class="w-100"></div>
                <div class="mb-3 col-12 col-md-4">
                    <label for="exampleInputPassword1" class="form-label">Пароль:</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                        placeholder="Пароль">
                </div>
                <div class="w-100"></div>
                <div class="mb-3 col-12 col-md-4">
                    <button type="submit" name="button-log" class="col-4 btn btn-secondary login-btn">Войти</button>
                    <a class="reg-link" href="<?php echo BASE_URL . "reg.php"; ?>">Зарегистрироваться</a>
                </div>
            </form>
        </div>
        <!-- END FORM -->
    </main>

    <!-- footer -->
    <?php include("app/include/footer.php"); ?>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous">
    </script>
</body>

</html>
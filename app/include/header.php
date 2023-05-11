<header class="container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <h1>
                    <a href="<?php echo BASE_URL ?>">My blog</a>
                </h1>
            </div>
            <nav class="col-8">
                <ul>
                    <li><a href="<?php echo BASE_URL ?>">Главная</a> </li>
                    <li><a href="<?php echo BASE_URL . 'about.php'?>">О нас</a> </li>
                    <li><a href="<?php echo BASE_URL . 'catalog.php'?>">Каталог</a> </li>

                    <li>
                        <?php if (isset($_SESSION['id'])): //если в $_SESSION есть параметр id, то...?>
                            <a href="#">
                                <i class="fa fa-user"></i>
                                <?php echo $_SESSION['login']; //печатаеться логин пользователя?>
                            </a>
                            <ul>
                                <?php if ($_SESSION['admin']): //если в $_SESSION парамете admin, то...?>
                                    <li><a href="#">Админ панель</a> </li> <!--эта панель есть-->
                                <?php endif; ?>
                                <li><a href="<?php echo BASE_URL . "logout.php"; ?>">Выход</a> </li>
                            </ul>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL . "log.php"; ?>">
                                <i class="fa fa-user"></i>
                                Войти
                            </a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . "reg.php"; ?>">Регистрация</a> </li>
                            </ul>
                        <?php endif; //конец?>

                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

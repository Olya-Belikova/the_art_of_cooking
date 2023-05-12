<header class="container">
    <div class="container">
        <div class="row">
            <div id="logo" class="col-4">
                    <a href="<?php echo BASE_URL ?>">
                        <img src="assets/logo.svg" alt="logo" height="55px" />
                    </a>
            </div>
            
            <nav class="col-7">
                <ul>
                    <li><a href="<?php echo BASE_URL ?>">Главная</a> </li>
                    <li><a href="<?php echo BASE_URL . 'about.php'?>">О блоге</a> </li>
                    <li><a href="<?php echo BASE_URL . 'catalog.php'?>">Рецепты</a> </li>
                </ul>
            </nav>
            <ul class="col-1">
                <li id="login">
                        <?php if (isset($_SESSION['id'])): ?>
                            <a href="#">
                                <?php echo $_SESSION['login']; ?>
                            </a>
                            <ul>
                                <?php if ($_SESSION['admin']): ?>
                                    <li class="admin-button"><a href="#">Панель управления</a> </li>
                                <?php endif; ?>
                                <li class="exit-button"><a href="<?php echo BASE_URL . "logout.php"; ?>">Выход</a> </li>
                            </ul>
                        <?php else: ?>
                            <a href="<?php echo BASE_URL . "log.php"; ?>">Войти</a>
                            <ul>
                                <li><a href="<?php echo BASE_URL . "reg.php"; ?>">Регистрация</a> </li>
                            </ul>
                        <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</header>

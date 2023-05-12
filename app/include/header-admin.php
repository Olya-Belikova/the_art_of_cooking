<header class="container">
    <div class="container">
        <div class="row">
            <div id="logo" class="col-4">
                    <a href="<?php echo BASE_URL ?>">
                        <img src="../../assets/logo.svg" alt="logo" height="55px" />
                    </a>
            </div>
            <nav class="col-8">
                <ul>
                    <li>
                        <a href="#">
                            <?php echo $_SESSION['login']; ?>
                        </a>
                    </li>
                    <li>
                        <a class="logout-btn" href="<?php echo BASE_URL . "logout.php"; ?>">Выход</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>

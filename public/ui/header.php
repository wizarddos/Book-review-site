
<header class = "main-nav">
    <ul class="main-nav-ul">
        <li><a href = "index.php" class = "header-link">Strona Główna</a></li>
        <li><a href = "search-books.php" class = "header-link">Szukaj</a></li>
        <li><a href = "recommended-books.php" class = "header-link">Polecane</a></li>
        <li><a href = "hot-books.php" class = "header-link">Nowe</a></li>
        <li><a href = "high-rated-books.php" class = "header-link">Najwyżej oceniane</a></li>
        <?php 
            if(isset($_SESSION['auth-token'])) {
                    echo '<li><a href = "profile.php" class = "header-link">Profil</a></li>';
            }else{
                echo '<li><a href = "login.php" class = "header-link">Zaloguj</a></li>';
            }
        ?>
    </ul>
</header>
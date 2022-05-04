<?php session_start() ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href = "styles/homepage.css">
    <title>Strona Główna</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>
    <main class = "main-content">
        <section class = "ad-baner">
            <div class = "ad-baner-content">
                <h1 class = "text-header-super-large">Czytanie książek jest łatwe!</h1>
                <a href = "register.php" class = "button-styled-link">Dołącz już dziś</a>
            </div>
        </section>
        <!--Gdy będzie więcej contentu na innych stronach, dokończyć i wstawić zdjęcia-->
    </main>
</body>
</html>
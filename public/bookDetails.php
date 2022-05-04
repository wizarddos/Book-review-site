<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "ui/metas.php"; ?>
    <link rel = "stylesheet" href = "styles/bookDetails.css">
    <title>Książka</title>
</head>
<body>
    <?php require_once 'ui/header.php'; ?>

    <?php //! front-end template start ?>
        <main class = "book-layout">
            <section class = "left-panel">
                <section class = "book-info">
                    <img class = "book-cover" src = "img/book-cover.jpg" alt = "Okładka książki: 'książka'"/> <?php //! 'książka' do podmienienia w php?>
                    <section class = "left-panel-side">
                        <h1 class = "book-title">Książka</h1>
                        <p class = "book-author">Autor: Autor</p>
                    </section>
                </section>
                <form class  = "start-reading" action = "../src/api/routes.php" method = "post">
                    <input type = "hidden" name = "bookId" value = "1">
                    <input type = "hidden" name = "action" value = "startReading">
                    <input class = "start-reading-button" type = "submit" value = "Rozpocznij czytanie" />
                </form>
            </section>
            <section class = "right-panel">
                <section class = "book-details">
                    <h2 class = "section-header">O książce:</h2>
                    <p class = "book-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In bibendum risus felis, sit amet dignissim<br/>
                        dolor mattis non. Aliquam mauris elit, maximus vitae lacus non, vehicula luctus dui. Maecenas sit amet tempus metus, sed <br/>
                        placerat nulla. Sed id felis varius, posuere quam a, iaculis sem. In hac habitasse platea dictumst. Sed venenatis ligula ac est <br/>
                        consectetur, nec pretium mauris rutrum. Donec lobortis ultrices ligula et egestas. Nulla accumsan, nisi ut viverra dapibus, nibh massa <br/>
                        commodo ex, quis egestas ex lorem et quam. Curabitur nec magna tempor quam pulvinar tempor. Curabitur pellentesque ut sapien congue pellentesque.
                    </p>
                </section>
                <section class = "book-reviews">
                    <h2 class = "section-header">Recenzje</h2>
                    <div class = "review">
                        <p class = "review-author">
                                <img class = "review-author-avatar" src = "img/pfp.svg" alt = "Avatar autora recenzji"/>
                                Autor recenzji: test-user
                            </p>
                        <p class = "review-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In bibendum risus felis, sit amet dignissim dolor mattis non.
                            <br/>Aliquam mauris elit, maximus vitae lacus non, vehicula luctus dui. Maecenas sit amet tempus metus, sed placerat nulla. 
                            <br/>Sed id felis varius, posuere quam a, iaculis sem. 
                            <br/>In hac habitasse platea dictumst. 
                            <br/> Sed venenatis ligula ac est consectetur, nec pretium mauris rutrum. 
                            <br/>Donec lobortis ultrices ligula et egestas. Nulla accumsan, nisi ut viverra dapibus, nibh massa commodo ex, quis egestas ex lorem et quam.
                            <br/> Curabitur nec magna tempor quam pulvinar tempor. 
                            <br/>Curabitur pellentesque ut sapien congue pellentesque.
                        </p>
                    </div>

                    <p class = "no-more-reviews">Nie ma więcej recenzji</p>
                </section>
        </main>    
    <?php //! front-end template end ?>
</body>
</html>
<?php 
    function generateCard($bookData){
        [$path, $title, $author, $price, $category, $publisher, $date, $rating] = $bookData;
        echo <<<END
        <div class = "result-book">
            <img src = "$path" class = "book-cover" alt = "okładka książki książka"/>
                <div class = "bookInfo">
                    <a href = "bookDetails.php?bookid="><h2>$title</h2></a>
                    <p>$author</p>
                    <p>$price</p>
                    <a href = "category.php?category="> <p>$category</p></a>
                    <p>$publisher</p>
                    <p>$date</p>
                    <p>
                        Ocena: 
        END;
        getRating($rating);
    }

    function getRating($rating){
        for($i=0; $i < 5; $i++){
            if($i < $rating){
                echo ' <i class = "fa fa-star checked"></i>';
            }else{
                echo ' <i class = "fa fa-star"></i>';
            }
        }

        echo <<<END
            </p>
        </div>
        </div>
        END;
    }
?>


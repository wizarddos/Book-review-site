<?php 
    function generateCard($bookData, $id=0){
        [$path, $title, $author, $category, $date, $rating] = $bookData;
        echo <<<END
        <div class = "result-book">
            <img src = "$path" class = "book-cover" alt = "okładka książki książka"/>
                <div class = "bookInfo">
                    <a href = "bookDetails.php?bookid=$id"><h2>$title</h2></a>
                    <p>$author</p>
                    <a href = "category.php?category=$category"> <p>$category</p></a>
                    <p>$date</p>
                    <p>
                        Ocena: 
        END;
        getRating($rating);
            echo <<<END
            </p>
        </div>
        </div>
        END;
    }

    function getRating($rating){
        for($i=0; $i < 5; $i++){
            if($i < $rating){
                echo ' <i class = "fa fa-star checked"></i>';
            }else{
                echo ' <i class = "fa fa-star"></i>';
            }
        }
    }
?>


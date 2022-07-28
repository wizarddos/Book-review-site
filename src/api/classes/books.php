<?php
class Books{
    private object $db;

    public function __construct()
    {   
        include('database.php');
        $this->db = new Database();
    }

    public function showBooks($type, $isLoged, $args = []){
        $sql = "SELECT * FROM  `books-info` ";

        switch($type){
            case 'recomended': break;
            case 'new': $sql = $sql." ORDER BY `book_id` DESC"; break;
            case 'highRated': $sql = $sql." ORDER BY `book_rate` DESC"; break;
            case 'category': $sql = $sql." WHERE book_categories IN(?)";  break;
            case 'search': $sql = $this->searchForBooks($sql, $args); $args = [$args['search']]; break;
           
            deafult: break;    
        }

        if($isLoged){
            switch($type){
                case 'added': $sql = $sql." WHERE added_by = ?"; break;
                case 'finished': $sql = "SELECT * FROM `books-read` WHERE `reader_id` = ? AND `isFinished` = 1"; break;
                case 'read': $sql = "SELECT * FROM `books-read` WHERE `reader_id` = ? AND `isFinished` = 0"; break;
                case 'favourite': $sql = "SELECT * FROM `books-reviews` WHERE `reviewer_id` = ? AND stars = 5"; break;
            }
        }

        $sql = $sql." LIMIT 10";
        $result = $this->db->runQuery($sql, $args);

        return $result;

    }

    public function addBookReview($request, $added_by){
        if(empty($request['stars']) || empty($request['review'])){
            return false;
        }
        
        $reviewContent = htmlentities($request['review'], ENT_QUOTES, "UTF-8");
        $stars = is_numeric($request['stars']) ? $request['stars'] : null;
        $toBook = is_numeric($request['bookID']) ? $request['bookID'] : null;

        if(!$stars || !$toBook)
            return false;

        $sql = "SELECT * FROM `books-reviews` WHERE `reviewer_id` = ? AND `book_reviewed_id` = ?";

        $isReviewAdded = $this->db->runQuery($sql, [$added_by, $toBook]);
        if(!empty($isReviewAdded)){
            $_SESSION['review_err'] = "Inna recenzja już została dodana z tego konta";
            return false;
        }else{
            $sql = "INSERT INTO `books-reviews` VALUES(?, ?, ?, ?, ?, ?)";
            $args = [NULL, $stars, $reviewContent, $added_by, $toBook, date('Y-m-d')];
            $result = $this->db->runQuery($sql, $args);
            $sql = "SELECT `stars` FROM `books-reviews` WHERE book_reviewed_id = ?";
            $result = $this->db->runQuery($sql, [$toBook]);
            $avg = 0;
            foreach($result as $row){
                $avg = $avg + $row['stars'];
            }

            $avg = $avg /count($result);

            $sql = 'UPDATE `books-info` SET `book_rate` = ? WHERE `book_id` = ?';
            $this->db->runQuery($sql, [$avg, $toBook]);


            return true;
        }
        
    }

    public function fetchReviews(int $bookid){
        $id = $bookid;

        $sql = "SELECT * FROM `books-reviews` WHERE `book_reviewed_id` = ? LIMIT 5";
        $result = $this->db->runQuery($sql, [$bookid]);

        return $result;
    }

    public function addNewBook($request, $added_by){
        if(empty($request['title']) || empty($request['author']) || $request['desc']){
            return false;
        }
        $title = htmlentities($request['title'], ENT_QUOTES, "UTF-8");
        $author = htmlentities($request['author'], ENT_QUOTES, "UTF-8");
        $desc= htmlentities($request['desc'], ENT_QUOTES, "UTF-8");

        if(is_string($title) && is_string($author) && is_string($desc)){
            $sql = "INSERT INTO `books-to-check` VALUES(?, ?, ?, ?, ?)";

            $this->db->runQuery($sql, [NULL, $title, $desc, $author, $added_by]);
            return true;
        }
        return false;
    }

    public function fetchForCard($bookid){
        $sql = "SELECT * FROM `books-info` WHERE `book_id` = ?";

        $result = $this->db->runQuery($sql, [$bookid]);
        return $result;
    }

    public function fetchBookDetails($request){
        $id = $request['bookid'];

        $sql = "SELECT * FROM `books-info` WHERE `book_id` = ?";
        return $this->db->runQuery($sql, [$id]);
    }

    public function startReading($request, $isLoged, $token){
        if(!$isLoged)
            return false;
       
        $bookid = is_numeric($request['bookId']) ? $request['bookId'] : null;
        $token = json_decode(base64_decode($token));

        if(!$bookid)
            return false;

        $sql = 'SELECT * FROM `books-read` WHERE `book_id` = ? AND reader_id = ?';
        $result = $this->db->runQuery($sql, [$bookid, $token->id]);

        if(count($result) > 0){
            $_SESSION['read_err'] = 'Już czytasz tę książkę';

            if($result[0]['isFinished']){
                $_SESSION['read_err'] = 'Ta książka już jest przeczytana przez ciebie';
            }
            return false;
        }
        
        $sql = "INSERT INTO `books-read` VALUES (?, ?, ?, ?, ?, ?)";
        $args = [NULL, $bookid, $token->id, 0, date('Y-m-d'), 0];

        return $this->db->runQuery($sql, $args);
    }

    public function isBookBeingRead($bookID, $token){
        $bookID = is_numeric($bookID) ? $bookID : null;
        $token = ($_SESSION['auth-token'] === $token) ? json_decode(base64_decode($token)) : null;

        if(empty($token) || empty($bookID))
            return false;

        $userID = $token->id;

        $sql = 'SELECT * FROM `books-read` WHERE `book_id` = ? AND `reader_id` = ? AND `isFinished` = 0';
        $result = $this->db->runQuery($sql, [$bookID, $userID]);


        if(count($result) > 0)
            return true;
       
        return false;
    }

    public function fetchReadDetails(int $userID, int $bookID){
        $sql = 'SELECT * FROM `books-read` WHERE `reader_id` = ? AND `book_id` = ?';

        return $this->db->runQuery($sql, [$userID, $bookID]);
    }

    public function updateReadBooks(array $request, string $token){
        $token = $token==$_SESSION['auth-token'] ? json_decode(base64_decode($token)) : null;
        
        if(!$token){
            return false;
        }
        
        $newPages = is_numeric($request['newPages']) ? $request['newPages'] : null;
        $bookID = is_numeric($request['book-id']) ? $request['book-id'] : null;

        $args = [$newPages, date('Y-m-d')];

        $sql = 'SELECT `pages` FROM `books-info` WHERE `book_id` = ?';
        $result = $this->db->runQuery($sql, [ $bookID])[0];
        $sql = 'UPDATE `books-read` SET `pages_read` = ? , `last_update` = ? ';


        if($newPages == $result['pages']){
            $sql = $sql.", `isFinished` = ? ";
            $args[2] = 1;
        }

        if($newPages > $result['pages']){
            return false;
            exit();
        }

        $args = array_merge($args, [ $bookID, $token->id]);
        
        $sql = $sql.'WHERE `book_id` = ? AND `reader_id` = ?';
        $result = $this->db->runQuery($sql, $args);
        return true;
    }

    private function searchForBooks($sql, $request){
        if($request['isFiltered']){
            switch($request['filter']){
                case 'author': $sql = $sql."WHERE `book_author` = ?"; break;
                case 'category': $sql = $sql."WHERE `book_categories` = ?";break;
                default: break;
            }
        }else{
            $sql = $sql."WHERE `book_title` = ?";
        }

        return $sql;
    }


}
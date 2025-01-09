    <?php 
    // File: models/NewsModel.php
    include dirname(__DIR__) . '/services/services.php';


    class NewsModel{
        

        public function getAllNews(){
            global $conn;
            $query = "SELECT * FROM news";
            $result = mysqli_query($conn, $query);
            return $result;
        }

        public function getNewsById($id){
            global $conn;
            $query = "SELECT * FROM news WHERE id = $id";
            $result = mysqli_query($conn, $query);
            return $result;
        }

        public function createNews($title, $subtitle, $content, $image, $created_at, $updated_at)
        {
            global $conn;
        
            $query = "INSERT INTO news (title, subtitle, content, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssssss', $title, $subtitle, $content, $image, $created_at, $updated_at);
        
            return mysqli_stmt_execute($stmt);
        }
        

        public function updateNews($id, $title, $subtitle, $content, $image, $updated_at){
            global $conn;
            $query = "UPDATE news SET title = '$title', subtitle = '$subtitle', content = '$content', image = '$image', updated_at = '$updated_at' WHERE id = $id";
            return mysqli_query($conn, $query);
        }

        public function deleteNews($id){
            global $conn;
            $query = "DELETE FROM news WHERE id = $id";
            return mysqli_query($conn, $query);
        }
    }
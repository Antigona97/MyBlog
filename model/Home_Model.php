<?php


class Home_Model extends Model {

    public function getPosts() {
        $sql = 'SELECT user.firstname, user.lastname, file.image, file.thumb, category.category_name, posts.*
                FROM user
                JOIN posts
                ON user.id = posts.user_id
                JOIN file
                ON file.id = posts.file_id
                JOIN category
                ON category.id = posts.category_id ORDER BY timestamp DESC';
        
        $obj = $this->db->prepare($sql);
        
        $obj->execute();
        
        if ($obj->rowCount() > 0) {
            $data = $obj->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }

        return false;
    }

    public function getPostByUrl($url) {
        $sql = 'SELECT user.firstname, user.lastname, file.image, file.thumb, category.category_name, posts.*
            FROM user
            JOIN posts
            ON user.id = posts.user_id
            JOIN file
            ON file.id = posts.file_id
            JOIN category
            ON category.id = posts.category_id WHERE posts.url = :url';

            $obj = $this->db->prepare($sql);

            $obj->execute(array(
                ":url" => $url
            ));

            if($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }
            return false;
    }

    public function getPostsTotal() {
        $sql = 'SELECT * FROM posts';
        
        $obj = $this->db->prepare($sql);
        
        $obj->execute();
        if ($obj->rowCount() > 0) {
            $data = $obj->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }

        return false;
    }

    public function paginationCount($limit, $offset) {
        $sql = 'SELECT * FROM posts LIMIT = :limit OFFSET = :offset';

        $obj = $this->db->prepare($sql);

        $obj->execute(array(
            ":limit" => $limit,
            ":offset" => $offset
        ));

        // Do we have any results?
        if ($obj->rowCount() > 0) {
            // Define how we want to fetch the results
            $data = $obj->fetchAll(PDO::FETCH_OBJ);
            Debug::add($data);
            $iterator = new IteratorIterator($data);

            // Display the results
            foreach ($iterator as $row) {
                echo '<p>', $row['name'], '</p>';
            }
        }
    }

    public function getCommentsByUrl($url){
        $post=$this->getPostByUrl($url);
        foreach ($post as $row){
            $id=$row->id;
            $sql = 'SELECT
            USER.firstname,
            USER.lastname,
                comments.*
            FROM
                comments
            LEFT JOIN USER ON USER.id = comments.user_id
            WHERE post_id = :id and approved=1';

            $obj = $this->db->prepare($sql);

            $obj->execute(array(
                ":id" => $id
            ));

            if ($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }
            return false;
        }
    }

}
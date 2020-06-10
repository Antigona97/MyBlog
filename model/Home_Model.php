<?php


class Home_Model extends Model {


    public function getPosts() {
        $sql = 'SELECT user.fullname, file.image, file.thumb, posts.*
                FROM user
                JOIN posts
                ON user.id = posts.user_id
                JOIN file
                ON file.id = posts.file_id
                where posts.status_id=3
                ORDER BY timestamp DESC';
        
        $obj = $this->db->prepare($sql);
        
        $obj->execute();
        
        if ($obj->rowCount() > 0) {
            $data = $obj->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }

        return false;
    }

    public function getPostByUrl($url) {
        $sql = 'SELECT user.fullname, file.image, file.thumb, posts.*
            FROM user
            JOIN posts
            ON user.id = posts.user_id
            JOIN file
            ON file.id = posts.file_id
            WHERE posts.url = :url';

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


    public function getPostCategory(){
        $sql='SELECT category.category_name, category.url, postcategory.*
        FROM postcategory
        JOIN category
        ON category.id=postcategory.category_id
        JOIN posts
        ON posts.id=postcategory.post_id';

        $obj = $this->db->prepare($sql);

        $obj->execute();
        if ($obj->rowCount() > 0) {
            $data = $obj->fetchAll(PDO::FETCH_OBJ);
            return $data;
        }

        return false;
    }


    public function getCommentsByUrl($url){

        $post=$this->getPostByUrl($url);

            foreach ($post as $row){
                $id=$row->id;
                $sql = 'SELECT
                USER.fullname,
                comments.*
                FROM comments
                JOIN USER 
                ON USER.id = comments.user_id
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
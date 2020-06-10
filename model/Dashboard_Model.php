<?php
    class Dashboard_Model extends Model {

        public function addPost($userId, $post_header, $post_content, $uploadedFile, $post_status, $tags, $url, $category) {

            // 1. Step: insert File ----------------------------------------------------------------------------------------------
            $sql = 'INSERT INTO file (name, image, thumb, size) VALUES (:name, :image, :thumb, :size)';
    
            $obj = $this->db->prepare($sql);
    
            $result1 = $obj->execute(array(
                ':name' => $uploadedFile['name'],
                ':image' => $uploadedFile['image'],
                ':thumb' => $uploadedFile['thumb'],
                ':size' => $uploadedFile['size'],
            ));
    
            // Remember the id of the new file entry
            $file_id = $this->db->lastInsertId();
    
    
            // 2. Step: insert Post ----------------------------------------------------------------------------------------------
    
            $sql = 'INSERT INTO posts(header, content, status_id, tags, url, user_id, file_id) VALUES (:header, :content, :status, :tags, :url, :user_id, :file_id)';
            
            $obj = $this->db->prepare($sql);
            
            $result2 = $obj->execute(array(
                ":header" => $post_header,
                ":content" => $post_content,
                ":status"=>$post_status,
                ":tags" => $tags,
                ":url" => $url,
                ":user_id" => $userId,
                ":file_id" => $file_id,
            ));
           $id=$this->db->lastInsertId();
           $this->addPostCategory($category, $id);
        }

        public function uploadUserImage($userId, $uploadedFile) {
            // 1. Step: insert File ----------------------------------------------------------------------------------------------
            $sql = 'INSERT INTO file (name, image, thumb, size) VALUES (:name, :image, :thumb, :size)';

            $obj = $this->db->prepare($sql);

            $result1 = $obj->execute(array(
                ':name' => $uploadedFile['name'],
                ':image' => $uploadedFile['image'],
                ':thumb' => $uploadedFile['thumb'],
                ':size' => $uploadedFile['size'],
            ));

            // Remember the id of the new file entry
            $file_id = $this->db->lastInsertId();

            // 2. Step: insert Post ----------------------------------------------------------------------------------------------
    
            $sql = "UPDATE user SET file_id = :file_id WHERE id = :id";

            $obj = $this->db->prepare($sql);
            
            $result2 = $obj->execute(array(
                ":id" => $userId,
                ":file_id" => $file_id,
            ));

            return $result1 && $result2;
        }

        public function updateFile($file_id, $file) {
            $sql = 'UPDATE file SET name=:name, image=:image, thumb=:thumb, size=:size WHERE id=:file_id';
    
            $obj = $this->db->prepare($sql);
    
            $result = $obj->execute(array(
                ':file_id' => $file_id,
                ':name' => $file['name'],
                ':image' => $file['image'],
                ':thumb' => $file['thumb'],
                ':size' => $file['size'],
            ));
    
            // Return result
            return $result;
        }

        public function editProfile($user_id, $post_fullname, $post_email, $post_password) {

            $sql = "UPDATE user SET fullname=:fullname, email = :email WHERE id = :id";
            
            $executeArray = array(
                ":fullname" => $post_fullname,
                ":email" => $post_email,
                ":id" => $user_id
            );

            if(!empty($post_password)) {
                $sql = "UPDATE user SET fullname=:fullname, email = :email, password = :password WHERE id = :id";
                $password = $post_password;
                $hashPassword = password_hash($password, PASSWORD_DEFAULT);
                $post_password = $hashPassword;

                $executeArray[':password'] = $post_password;
            }
            
            $obj = $this->db->prepare($sql);

            $result1 = $obj->execute($executeArray);
    
            return $result1;
        }
    
        public function getPosts() {
            $sql = 'SELECT user.fullname, file.image, file.thumb, category.category_name,status.status, posts.*
                    FROM user
                    JOIN posts
                    ON user.id = posts.user_id
                    JOIN file
                    ON file.id = posts.file_id
                    JOIN postcategory
                    ON postcategory.post_id = posts.id
                    JOIN category
                    ON postcategory.category_id=category.id
                    JOIN status
                    ON status.id=posts.status_id
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
            $sql = "SELECT user.fullname, file.image, file.thumb, status.status, posts.*
            FROM user
            JOIN posts
            ON user.id = posts.user_id
            JOIN file
            ON file.id = posts.file_id
            JOIN status
            ON status.id = posts.status_id
            WHERE posts.url=:url";

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

        public function getFileById($id) {
            $sql = "SELECT * FROM file WHERE id = :id";
            $obj = $this->db->prepare($sql);

            $obj->execute(array(
                ":id" => $id
            ));

            if($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }
        
            return false;
        }

        public function getPostsByEmail() {
            $sql = 'SELECT user.fullname, file.image, file.thumb, category.category_name, posts.*
                    FROM user
                    JOIN posts
                    ON user.id = posts.user_id
                    JOIN file
                    ON file.id = posts.file_id
                    JOIN category
                    ON category.id = posts.category_id
                    WHERE user.email = :email';
            
            $obj = $this->db->prepare($sql);
            
            $obj->execute(array(
                ":email" => Session::get('user')['email']
            ));
            
            if ($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }
    
            return false;
        }

        public function getUserById($id) {
            $sql = 'SELECT u.id, u.fullname, u.email, u.login_attempts, u.permission_id, u.file_id, file.image, file.thumb, p.permission
            FROM user as u
            LEFT JOIN file ON file.id = u.file_id
            LEFT JOIN user_permission AS p ON u.permission_id = p.id
            WHERE u.id = :id';
            
            $obj = $this->db->prepare($sql);
            
            $obj->execute(array(
                ":id" => $id
            ));
            
            if ($obj->rowCount() > 0) {
                $data = $obj->fetch(PDO::FETCH_ASSOC);
                return $data;
            }
    
            return false;
        }
    
        public function getUserFromEmail($email) {
            $sql = 'SELECT user.*, user_permission.permission FROM user LEFT JOIN user_permission ON permission_id = user_permission.id WHERE email = :email LIMIT 1';
            $obj = $this->db->prepare($sql);
    
            $obj->execute(array(
                'email' => $email
            ));
    
            $result = $obj->fetch(PDO::FETCH_ASSOC);
    
            return $result;
        }

        public function updatePost($data) {
            $sql = "UPDATE posts SET header = :header, content = :content, status_id=:status, tags=:tags WHERE url = :url";
    
            $obj = $this->db->prepare($sql);
    
            $obj->execute(array(
                ":url" => $data["url"],
                ":header" => $data["header"],
                ":content" => $data["content"],
                ":status" => $data["status"],
                ":tags" => $data["tags"]
            ));
        }
    
        public function getCategories() {
            $sql = "SELECT * FROM category WHERE 1";
            $obj = $this->db->prepare($sql);
    
            $obj->execute();
    
            if($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }
    
            return false;
        }

        public function addPostCategory($category, $post){
            $sql='INSERT INTO `postcategory`(`post_id`, `category_id`) VALUES (:post_id, :category_id)';

            $obj = $this->db->prepare($sql);

            $obj->execute(array(
                ":post_id" => $post,
                ":category_id" => $category
            ));

            if($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }

            return false;
        }

        public function getStatus(){

            $sql='SELECT * FROM status';

            $obj = $this->db->prepare($sql);

            $obj->execute();

            if($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }

            return false;
        }

        public function insertCategory($categoryName, $url) {
            $sql = "INSERT INTO category(category_name, url) VALUES (:category_name, :url)";
            $obj = $this->db->prepare($sql);
    
            $obj->execute(array(
                ":category_name" => $categoryName,
                ":url" => $url
            ));
    
            if($obj->rowCount() > 0) {
                $data = $obj->fetchAll(PDO::FETCH_OBJ);
                return $data;
            }
    
            return false;
        }

        public function getAllUsers() {
            $sql = 'SELECT user.*, user_permission.permission FROM user LEFT JOIN user_permission ON permission_id = user_permission.id ORDER BY user.email ASC';
            $obj = $this->db->prepare($sql);
    
            $obj->execute();
    
            $result = $obj->fetchAll(PDO::FETCH_OBJ);
    
            return $result;
        }

        public function updatePermission($permission, $userEmail) {
            $sql = "UPDATE `user` SET permission_id = :permission WHERE email = :email";

            $obj = $this->db->prepare($sql);

            $obj->execute(array(
                ":permission" => $permission,
                ":email" => $userEmail
            ));
        }

        public function getAllPermissions() {
            $sql = "SELECT * FROM user_permission";
            $obj = $this->db->prepare($sql);
            $obj->execute();

            $result = $obj->fetchAll(PDO::FETCH_OBJ);

            return $result;
        }

        public function getPostCategory(){
            $sql='SELECT category.category_name, postcategory.*
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

        public function getUrl($url){
            $sql='SELECT url
            FROM posts
            where url like concat(:url, "%")';

            $obj = $this->db->prepare($sql);

            $obj->execute(array(
                ':url'=> $url
            ));

            if ($obj->rowCount() > 0) {
                $data = $obj->fetchAll();
                return $data;
            }

            return false;
        }

        # ********************
        # Ban/Unban Functions
        # ********************
        
        public function unbanUser($userEmail) {
            $sql = 'UPDATE user SET login_attempts = 0 WHERE email = :email';
            $obj = $this->db->prepare($sql);
    
            $result = $obj->execute(array(
                ":email" => $userEmail
            ));
    
            return $result;
        }

        public function banUser($userEmail) {
            $sql = 'UPDATE user SET login_attempts = 3 WHERE email = :email';
            $obj = $this->db->prepare($sql);
    
            $result = $obj->execute(array(
                ":email" => $userEmail
            ));
    
            return $result;
        }

        # *****************
        # Delete Functions
        # *****************
        
        public function deleteFile($file_id) {
    
            $sql = 'DELETE FROM file WHERE id = :file_id';
    
            $obj = $this->db->prepare($sql);
    
            $result = $obj->execute(array(
                ':file_id' =>  $file_id
            ));
    
            return $result;
        }

        public function deletePostCategory($post_id){
            $sql = 'DELETE FROM postcategory WHERE post_id = :post_id LIMIT 1;';

            $obj = $this->db->prepare($sql);

            $result = $obj->execute(array(
                ':post_id' => $post_id
            ));

            return $result;
        }

        public function deletePost($url) {

            $sql = 'DELETE FROM posts WHERE url = :url LIMIT 1;';
    
            $obj = $this->db->prepare($sql);
    
            $result = $obj->execute(array(
                ':url' => $url
            ));
    
            return $result;
        }

    }
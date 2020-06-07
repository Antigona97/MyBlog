<?php
    class Dashboard extends Controller {

        # **************
        # Create SEO Url
        # **************
        public function getRelatedSlugs($url){
            $posts=$this->model->getPosts();
            var_dump($posts['url']);
        }
        public  function geneterateSEOurl($url, $wordLimit=0)
        {
            $separator='-';
            if($wordLimit != 0){
                $wordArr = explode(' ', $url);
                $string = implode(' ', array_slice($wordArr, 0, $wordLimit));
            }

            $quoteSeparator = preg_quote($separator, '#');

            $trans = array(
                '&.+?;'                    => '',
                '[^\w\d _-]'            => '',
                '\s+'                    => $separator,
                '('.$quoteSeparator.')+'=> $separator
            );

            $string = strip_tags($url);
            foreach ($trans as $key => $val){
                $string = preg_replace('#'.$key.'#i'.(UTF8_ENABLED ? 'u' : ''), $val, $string);
            }
            $string = strtolower($string);

            return trim(trim($string, $separator));
        }
        # **************
        # Add New Post 
        # **************
        
        public function doAdd() {
            $post = $_POST;
            $category_id = $post['category_id'];
            $userId = Session::get('user')['id'];
            $post_header = trim($post['header']);
            $post_content = trim($post['content']);
            $post_file = $_FILES['post_file'];
            $post_status=$post['status'];
            $url=$this->geneterateSEOurl($post_header);
            $uploadedFile = File::uploadImg($post_file);
            $this->model->addPost($category_id, $userId, $post_header, $post_content, $uploadedFile, $post_status, $url);

            Message::add('Perfect! New post has been added to your blog');

            //header('Location: ' . URL . 'dashboard/add');
        }

        # Rendering the add Page - Only accessible if Admin status
        public function add() {
            if(Session::get('user')['permission'] == "Admin") { 
                $data = $this->model->getCategories();
                $this->view->data = $data;
                $this->view->render('dashboard/add-post');
            } else {
                header('Location: ' . URL . 'dashboard');
            }
        }

        # ****************
        # User Management
        # ****************

        public function allUsers() {
            $allPermissions = $this->model->getAllPermissions();
            $allUsers = $this->model->getAllUsers();
            $this->view->allUsers = $allUsers;
            $this->view->allPermissions = $allPermissions;
            $this->view->render('dashboard/allUsers');
        }

        public function unbanUser() {
            $userEmail = explode("/", $_GET["url"]);
            $this->model->unbanUser($userEmail[2]);
            header("Location: " . URL . "dashboard/allUsers");
        }

        public function banUser() {
            $userEmail = explode("/", $_GET["url"]);
            $this->model->banUser($userEmail[2]);
            header("Location: " . URL . "dashboard/allUsers");
        }

        public function updatePermission() {
            $permission = $_POST['permission_id'];
            $userEmail = explode("/", $_GET["url"]);
            $this->model->updatePermission($permission ,$userEmail[2]);
            header("Location: " . URL . "dashboard/allUsers");
        }

        # **********************
        # Category functionality
        # ***********************
        
        public function category() {
            if(!(Session::get('user'))) {
                header("Location: " . URL . "home");
            } else { 
                $this->view->render('dashboard/category');

            }
        }

        public function addCategory() {
            $getCategory = $_POST['category'];
            $getParent=$_POST['parent'];
            $url=$this->geneterateSEOurl($getCategory);
            $this->model->insertCategory($getCategory, $getParent, $url);
            header("Location: " . URL . "dashboard/category");
        }

        # ******************
        # Edit User Profile
        # ******************

        public function editProfile() {
            if(!(Session::get('user'))) {
                Header("Location: " . URL . "home");
            } else { 
                $userEmail = Session::get('user')['email'];
                $userImgThumb = Session::get('user')['thumb'];
        
                $userData = $this->model->getUserFromEmail($userEmail);
                $this->view->userData = $userData;
                $this->view->userImg = $userImgThumb;
                $this->view->render('dashboard/profile');
            }
        }

        public function doUpdateUser() {
            $post = $_POST;
            $post_firstname = $_POST['firstname'];
            $user = Session::get('user');
            $user_id = $user['id'];
            $post_lastname = $_POST['lastname'];
            $post_email = $_POST['email'];
            $post_password = $_POST['password'];
            $file_id = $_POST['file_id'];
            $new_foto = $_FILES['new_foto'];
            $userEmail = $user['email'];
            $userData = $this->model->getUserFromEmail($userEmail);
            $this->view->userData = $userData;

            if (!$new_foto['error']) {
                
                $uploadedFile = File::uploadImg($new_foto);
                
                if(!empty($user['image'])) {
                    File::delete($user['thumb']);
                    File::delete($user['image']);
                }
                
                if($user['file_id'] === NULL) {
                    $this->model->uploadUserImage($user_id, $uploadedFile);
                } else {
                    $this->model->updateFile($file_id, $uploadedFile);
                }   
            }
            
            $this->view->post = $post;
            $this->model->editProfile($user_id, $post_firstname, $post_lastname, $post_email, $post_password);
            $updatedUser = $this->model->getUserById($user['id']);
            // Debug::add($updatedUser);
            Session::set("user", $updatedUser); 
            // $this->view->render('dashboard/editProfile');
            header('Location: ' . URL . 'dashboard/editProfile');        
        }

        # *************************************
        # CRUD Functionality for View Posts 
        # *************************************

        public function view() {
            if(!(Session::get('user'))) {
                Header("Location: " . URL . "home");
            } else {
                $posts = $this->model->getPosts();
                $this->view->posts = $posts;
                $this->view->render('dashboard/allposts');
            }
        }

        public function edit($url) {
            if(!(Session::get('user'))) {
                Header("Location: " . URL . "home");
            } else {
                $posts = $this->model->getPostByUrl($url);
                $this->view->posts = $posts;
                $this->view->render('dashboard/edit');
            }
        }

        public function doEdit($id) {        
            $post = $_POST;
            $posts = $this->model->getPostById($id);
            $post['id'] = $id;
            $post['header'] = trim($post['header']);
            $post['content'] = trim($post['content']);
            $file_id = $_POST['file_id'];
            $new_foto = $_FILES['new_foto'];

            if(empty($post['header']) || empty($post['content'])) {
                $this->view->post_err = 'Please fill out the complete form';
                return $this->edit();
            }

            if (!$new_foto['error']) {
                $uploadedFile = File::uploadImg($new_foto);

                File::delete($posts[0]->thumb);
                File::delete($posts[0]->image);

                $this->model->updateFile($file_id, $uploadedFile);
            }

            $this->view->post = $post;
            $this->model->updatePost($post);
            Message::add('Post updated');
            
            header('Location: ' . URL . 'home');
        }

        public function delete($url) {
            $post = $this->model->getPostByUrl($url);
            $file_id = $post[0]->file_id;
            
            $this->model->deleteFile($file_id);
            $this->model->deletePost($url);
            File::delete($post[0]->image);
            File::delete($post[0]->thumb);

            Message::add('Post deleted', 'danger');
            header('Location: ' . URL . 'home');
        }

        public function allUserPosts() {
            $allPosts = $this->model->getPostsByEmail();
            $this->view->allPosts = $allPosts;
            $this->view->render('dashboard/allUserPosts');   
        }

        public function index() {
            if(!(Session::get('user'))) {
                Header("Location: " . URL . "home");
            } else {
                $this->view();
            }
        }
    }
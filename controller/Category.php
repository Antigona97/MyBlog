<?php

class Category extends Controller {

    # *************************************************************
    # Functions for individual category pages:
    # Digital Minimalism, Productivity, Mind, Books and Podcasts
    # *************************************************************

    public function showCategory($url) {
        Session::set('activeCategory', $url);
        $categories = Session::get('categories');
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $result = $this->model->getPostsByCategoryId($url, $search);
        $this->view->posts = $result;

        $this->view->render('category/showAll');
    }


    # **********************
    # Comment functionality
    # **********************

    public function insertComment() {
        $comment = $_POST;
        # Split URL to get Id parameter
        $getId = explode("/", $_GET['url']);
        $postId = $getId[2];
        # User input into comment field
        $user_comment = $comment['user_comment'];

        $this->model->userComment($user_comment, $postId);

        # Redirect to same page after comment has been submitted
        header("Location: " . URL . "category/show/$postId");
    }

    public function comments(){
        if(!(Session::get('user'))) {
            Header("Location: " . URL . "home");
        } else {
            $comments=$this->model->getComments();
            $this->view->comments=$comments;

            $this->view->render('category/comments');
        }
    }

    # ************************
    # Show Post Functionality
    # ************************

    public function show($url) {
        # Get all Data needed for post
        $data = $this->model->getPostByUrl($url);
        $comments = $this->model->getAllCommentsByUrl($url);

        # Passing it into the view
        $this->view->data = $data;
        $this->view->comments = $comments;

        $this->view->render('category/show');
    }


    public function approved($id){
        $comment=$this->model->approveComment($id);
        Message::add('Comment approved');
        header('Location:'.URL.'category/comments');
    }

    # ************************
    # Standard Index Render
    # ************************

    public function index() {
        $this->view->render('category/digitalminimalism');
    }

}
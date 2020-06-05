<?php


class Home extends Controller {


    # render all posts on the start page
    public function index() {
        $data = $this->model->getPosts();

        $this->view->post = $data;

        $this->view->render('home/index');
    }

    public function show($url) {
        # Get all Data needed for post
        $data = Category_Model::getPostByUrl($url);
        $comments = Category_Model::getAllCommentsByUrl($url);

        # Passing it into the view
        $this->view->data = $data;
        $this->view->comments = $comments;

        $this->view->render('home/show');
    }


    public function showCategory($url) {
        Session::set('activeCategory', $url);
        $categories = Session::get('categories');
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $result =Category_Model::getPostsByCategoryId($url, $search);
        $this->view->posts = $result;

        $this->view->render('home/showAll');
    }

}
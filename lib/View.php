<?php

class View {

    //True if rendered
    private $rendered = false;

    public function render($name) {

        //Check if view has already been rendered
        if (!$this->rendered) {

            //Prevent double rendering
            $this->rendered = true;

            require 'partial/message.php';


            if(Session::get('controller_name') == 'Dashboard' || Session::get('controller_name')=='Auth' || Session::get('controller_name') =='Category') {
                require 'partial/layout/head.html';
            }elseif (Session::get('controller_name') =='Home' || Session::get('controller_name') =='Category' || Session::get('controller_name') =='Contact' || Session::get('controller_name') == 'About'){
                require 'partial/header.php';
            }

            require_once 'view/' .$name . '.php';

            // Check DEBUG_MODE (config)
            if (DEBUG_MODE) {
                //Draw Debug-View
                require 'partial/debug.php';
            }
            require 'partial/footer_essentials.php';

        }

    }

}
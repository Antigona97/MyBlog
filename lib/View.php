<?php

class View {

    //True if rendered
    private $rendered = false;

    public function render($name) {

        //Check if view has already been rendered
        if (!$this->rendered) {

            //Prevent double rendering
            $this->rendered = true;

            require 'partial/layout/head.html';

            require 'partial/message.php';

            require_once 'view/' .$name . '.php';

            if(Session::get('controller_name') == 'Dashboard') {
                require 'partial/layout/fixed-footer.html';
            }elseif (Session::get('controller_name') =='Home' || Session::get('controller_name') =='Category'){
                require 'partial/header.php';
                require 'partial/footer.php';
            }

            // Check DEBUG_MODE (config)
            if (DEBUG_MODE) {
                //Draw Debug-View
                require 'partial/debug.php';
            }
            require 'partial/footer_essentials.php';

        }

    }

}
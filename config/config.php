<?php

//---------------------------------------------------------
//Debug ?

define('DEBUG_MODE', false);
//---------------------------------------------------------

define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');

define('DB_NAME', 'mvc_db');
define('DB_USER', 'root');
define('DB_PASS', '');

//---------------------------------------------------------

define('URL', '/myblog/');

//---------------------------------------------------------

define('MAXIMUM_LOGINS', 3);

//---------------------------------------------------------

// Set values for Pagination 
define('ACTIVE_PAGE', 0);
define('CARDS_PER_PAGE', 6);

//---------------------------------------------------------


define('SITENAME', 'My Blog');

//---------------------------------------------------------

define('DEFAULT_IMG', URL . 'public/img/default.jpg');

//---------------------------------------------------------

define('IMAGE_UPLOADS_PATH', 'uploads/images');
define('IMAGE_DEFAULT_EXT', '.jpg');
define('IMAGE_THUMB_EXT', '-thumb');
define('IMAGE_THUMB_WIDTH', 200);
define('IMAGE_THUMB_HEIGHT', 200);
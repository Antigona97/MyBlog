<?php

class Auth extends Controller {

    public function doRegister() {
    
        //Get credentials from POST
        $user = $_POST;
        $code=substr(md5(mt_rand()), 0, 4);

        // Get user by Mail
        $userEntry = $this->model->getUserFromEmail($user['email']);

        // Save all emails
        $error = array();

        //Validate Email
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email_err'] = 'Not a valid mail';
        } 

        // Check if Mail already exists
        if ($userEntry) {
            $error['email_err'] = 'E-Mail already exists';
        } 

        // Validate Name
        if(empty($user['fullname'])){
            $error['name_err'] = 'Please enter first name';
        }

        // Validate Password
        if(empty($user['password'])){
            $error['password_err'] = 'Please enter password';
        } elseif(strlen($user['password']) < 8){
            $error['password_err'] = 'Password must be at least 8 characters';
        }

        // Validate Confirm Password
        if(empty($user['confirmpassword'])){
            $error['confirm_password_err'] = 'Please confirm password';
        } else {
            if($user['password'] != $user['confirmpassword']){
                $error['confirm_password_err'] = 'Passwords do not match';
            }
        }
        
        // Check for error - if no error register
        if($error) {

            $this->view->error = $error;
            $this->view->formData = $user;

            $this->view->render('auth/register');
        }else {
            $this->sendCode($user['email'], $code);

            Message::add('A code is sent to your email.');
            Session::set('email',$user['email']);
            $this->model->registerUser($user, $code);

            // Change location (goto login)
            header('Location: ' . URL . 'auth/verificationCode?email='.$user['email']);
        }
    }

    public function doLogin() {
            //Get credentials from POST
            $user = $_POST;

            // Init data
            $user['email'] = trim($user['email']);
            $user['password'] = trim($user['password']);

            // Empty check
            if(empty($user['email']) || empty($user['password'])) {
                $this->view->email_err = 'Filling out the form would be a good start';
                return $this->login();
            } 

            // Adds +1 to the login attempts if login is false
            $this->model->recordLoginAttempt($user['email']);

            // Get User Entry, Check if exists & Verify Password
            $userEntry = $this->model->loginUser($user);

            // Checking user entry + attempted logins
            if($userEntry && $userEntry['login_attempts'] < MAXIMUM_LOGINS) {
                Session::set('user', $userEntry);
                Session::set('user_image', $userEntry['image']);

                // Resets login attempts to 0 if login successfull
                $resetAttempts = $this->model->resetLoginAttempts($user['email']);
                if($user['remember']){
                    setcookie('password', $user['password'], time() + (86400 * 30), "/");
                }
                header('Location: ' . URL . 'home');
                return;
            }

            // Gets the attempted logins from the Database
            $checkLoginAttempts = $this->model->checkLoginAttempts($user['email']);

            // Check if login Attempts exceeded max logins.
            if($checkLoginAttempts >= MAXIMUM_LOGINS) {
                $this->view->email_err = 'Contact Admin. You\'re blocked.';
                return $this->login();
            }

            $this->view->email_err = 'Email or Password wrong.';
            $this->login();
    }

    public function logout() {
        // Remove userEntry from Session
        Session::remove('user');
        session_destroy();

        // Change location (goto home)
        header('Location: ' . URL . 'home');
    }

    public function sendCode($email, $code){
        //function that sends verification code
        $mail=new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "email";
        $mail->Password = "password";
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('password');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Body = "Please verify your account with the code " . $code;
        $mail->send();

    }

    public function verifyCode(){

        $code=isset($_POST['code'])?$_POST['code']:'';
        $email=Session::get('email');

        if(!empty($code) && !empty($email)){
            if($this->model->verify($email,$code)){
                $this->model->updateStatus($email);
                header('Location: ' . URL . 'auth/login');
            }
            Message::add('Please verify your code');
            header("Location".URL.'auth/login');
        }
        header("Location:".URL.'auth/verificationCode');
    }

    public function recoverPassword(){
        $email=isset($_POST['email'])?$_POST['email']:'';
        if(!empty($email)){
            $data=$this->checkIfEmailExists($email);
            if($data>0){
                header("Location:recover-password?email=$email");
            }

        }
    }
    
    # *****************
    # Render functions
    # *****************

    public function login() {
        $this->view->render('auth/login');
    }

    public function register() {
        //Render register view
        $this->view->render('auth/register');
    }

    public function verificationCode(){
        $this->view->render('auth/verificationCode');
    }
    
    public function index() {
        $this->view->render('auth/register');
    }

}
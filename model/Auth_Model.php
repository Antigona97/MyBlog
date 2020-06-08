<?php

class Auth_Model extends Model {
 
    public function registerUser($user, $code) {
        $password = $user['password'];

        $hash = password_hash($password,PASSWORD_DEFAULT);
        
        $user['password'] = $hash;

        $sql = 'INSERT INTO user (fullname, email, password, code) VALUES (:fullname, :email, :password, :code)';

        $obj = $this->db->prepare($sql);

        $obj->execute(array(
            'fullname' => $user['fullname'],
            'email' => $user['email'],
            'password' => $user['password'],
            'code' => $code
        )); 
    }

    public function loginUser($user) {

        //Get userEntry from DB
        $userEntry = $this->getUserFromEmail($user['email']);

        //Check if user exists (and early return if not)
        if (!$userEntry) return false;

        //Get password and hash
        $password = $user['password'];
        $hash = $userEntry['password'];

        //Remove hashed password from $userEntry
        unset($userEntry['password']);

        //Verify password
        if (password_verify($password, $hash)) return $userEntry;

        //Otherwise return false
        return false;
    }

    public function getUserFromEmail($email) {
        $sql = 'SELECT user.*, user_permission.permission, file.thumb, file.image FROM user 
        LEFT JOIN user_permission ON permission_id = user_permission.id 
        LEFT JOIN file ON file_id = file.id WHERE email = :email LIMIT 1';

        $obj = $this->db->prepare($sql);

        $obj->execute(array(
            'email' => $email
        ));

        $result = $obj->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function recordLoginAttempt($email) {
        # +1 login attempts on every false password input
        $sql = 'UPDATE user SET login_attempts = login_attempts + 1 WHERE email = :email ';
        $obj = $this->db->prepare($sql);

        $result = $obj->execute(array(
            'email' => $email
        ));

        return $result;
    }

    public function resetLoginAttempts($email) {
        # if login correct reset attempts to 0
        $sql = 'UPDATE user SET login_attempts = 0 WHERE email = :email';
        $obj = $this->db->prepare($sql);

        $result = $obj->execute(array(
            'email' => $email
        ));

        return $result;
    }

    public function checkLoginAttempts($email) {
        # Check login attempts and see if exceeded the amount of false logins
        $sql = 'SELECT login_attempts FROM user WHERE email = :email';

        $obj = $this->db->prepare($sql);

        $obj->execute(array(
            'email' => $email
        ));

        if($obj->rowCount() > 0) {
            $result = $obj->fetch(PDO::FETCH_ASSOC);
            return $result['login_attempts'];
        }

        return false;
    }

    public function verify($email, $code){
        $sql='SELECT *
        FROM user
        WHERE email=:email and code=:code';

        $obj=$this->db->prepare($sql);
        $obj->execute(array(
            'email'=>$email,
            'code'=>$code
        ));

        if($obj->rowCount()>0){
            $result = $obj->fetchAll();
            return $result;
        } return false;

    }

    public function updateStatus($email){
        $sql='UPDATE user
        SET status=1
        WHERE email=:email';

        $obj=$this->db->prepare($sql);

        $obj->execute(array(
            'email'=>$email
        ));
    }
}

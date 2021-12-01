<?php

class Session {

  private $user_id;
  public $username;
  private $last_login; //this will allow us to expire their login
  public const MAX_LOGIN_AGE = 60*60*24; //this is one day

  public function __construct() {
    //turn on sessions if needed
    session_start();
    $this->check_stored_login();
  }

  //passing in the user object? I think
  public function login($user) {
    //if there is a user in the session and in the property
    if($user) {
      //this protects against session fixation attacks
      session_regenerate_id();
      $this->user_id = $_SESSION['user_id'] = $user->id;
      $this->username = $_SESSION['username'] = $user->username;
      $this->last_login = $_SESSION['last_login'] = time();
    }
    return true;
  }
  //tests if the user is currently logged in
  public function is_logged_in() {
    // return isset($this->user_id);
    return isset($this->user_id) && $this->last_login_is_recent();
  }

  //this will logout any currently logged in user
  public function logout() {
    unset($_SESSION['user_id']);
    unset($_SESSION['username']);
    unset($_SESSION['last_login']);
    unset($this->user_id);
    unset($this->username);
    unset($this->last_login);
    return true;
  }

  private function check_stored_login() {
    //this just checks if the value is stored in the session
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      $this->username = $_SESSION['username'];
      $this->last_login = $_SESSION['last_login'];
    }
  }

  private function last_login_is_recent() {
    if(!isset($this->last_login)) {
      return false;
    } elseif(($this->last_login + self::MAX_LOGIN_AGE) < time()) {
      return false;
    } else {
      return true;
    }
  }
  //this is one method to both set and retrieved the session messages
  public function message($msg="") {
    if(!empty($msg)) {
      //then this is a "set" message
      $_SESSION['message'] = $msg;
      return true;
    } else {
      //then this is a "get" message
      return $_SESSION['message'] ?? '';
    }
  }

  public function clear_message() {
    unset($_SESSION['message']);
  }

}
?>

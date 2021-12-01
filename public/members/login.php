<?php
require_once('../../private/initialize.php');

$errors = [];
$username = '';
$password = '';

if(is_post_request()) {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  // Validations
  if(is_blank($username)) {
    $errors[] = "Username cannot be blank.";
  }
  if(is_blank($password)) {
    $errors[] = "Password cannot be blank.";
  }

  // if there were no errors, try to login
  if(empty($errors)) {
    $member = Member::find_by_username($username);
    // test if admin found and password is correct
    if($member != false && $member->verify_password($password)) {
      // Mark admin as logged in
      // Review this line
      //$session->login($member);
      redirect_to(url_for('/members/index.php'));
    } else {
      // username not found or password does not match
      $errors[] = "Log in was unsuccessful.";
    }
  }
}
 
$page_title = 'Log in'; 
include(SHARED_PATH . '/header.php'); 

?>

<div id="content">
  <h1>Log in</h1>
  
  <?= display_errors($errors); ?>

  <form action="login.php" method="post">
    Username:<br>
    <input type="text" name="username" value="<?= h($username); ?>"><br>
    Password:<br>
    <input type="password" name="password" value=""><br>
    <input type="submit" name="submit" value="Submit">
  </form>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

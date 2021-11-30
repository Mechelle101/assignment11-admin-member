<?php

require_once('../../private/initialize.php');

if(is_post_request()) {

  // Create record using post parameters
  $args = $_POST['bird'];

  $bird = new Bird($args);
  $result = $bird->save();
  
  if($result === true) {
    $new_id = $bird->id;
    $session->message('The bird was created successfully.');
    redirect_to(url_for('birds/show.php?id=' . $new_id));
  } else {
    // show errors
  }

} else {
  // display the form
  $bird = new Bird;
}
// The else ends here. The remainder of the page will display

?>

<?php $page_title = 'Create Bird'; ?>
<?php include(SHARED_PATH . '/member-header.php'); ?>

<div id="content">

  <a class="back-link" href="<?= url_for('/staff/birds/index.php'); ?>">&laquo; Back to List</a>

    <h1>Create Bird</h1>

    <?= display_errors($bird->errors); ?>

    <form action="<?= url_for('birds/new.php'); ?>" method="post">
      <?php include('form_fields.php'); ?>
      <input type="submit" value="Create Bird" />
    </form>

<?php include(SHARED_PATH . '/footer.php'); ?>

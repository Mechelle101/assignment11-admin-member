<?php

require_once('../../private/initialize.php');

if(!isset($_GET['id'])) {
  redirect_to(url_for('/staff/birds/index.php'));
}
$id = $_GET['id'];

$bird = Bird::find_by_id($id);
if($bird == false) {
  redirect_to(url_for('birds/index.php'));
}
?>
<a class="back-link" href="<?= url_for('/staff/birds/index.php'); ?>">&laquo; Back to List</a>

<?php
if(is_post_request()) {

  // Delete bird
  $result = $bird->delete();
  
  $session->message('The bird was deleted successfully.');
  redirect_to(url_for('birds/index.php'));
  
} else {
  // Display form
}

?>

<?php $page_title = 'Delete Bird'; ?>
<?php include(SHARED_PATH . '/member-header.php'); ?>


    <h1>Delete Bird</h1>
    <p>Are you sure you want to delete this bird?</p>
    <p class="item"><?= h($bird->common_name); ?></p>

    <form action="<?= url_for('birds/delete.php?id=' . h(u($id))); ?>" method="post">
      <div id="operations">
        <input type="submit" name="commit" value="Delete Bird" />
      </div>
    </form>

<?php include(SHARED_PATH . '/footer.php'); ?>

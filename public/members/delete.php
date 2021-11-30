<?php

  require_once('../../private/initialize.php');

  $page_title = 'Delete Member'; 
  include(SHARED_PATH . '/member-header.php'); 
?>

  <a class="back-link" href="<?php echo url_for('/members/index.php'); ?>">&laquo; Back to List</a>

<?php
  if(!isset($_GET['id'])) {
    redirect_to(url_for('members/index.php'));
  }
  $id = $_GET['id'];
  $member = Member::find_by_id($id);
  if($member == false) {
    redirect_to(url_for('members/index.php'));
  }

  if(is_post_request()) {

    // Delete admin
    $result = $member->delete();
    $_SESSION['message'] = 'The user was deleted successfully.';
    redirect_to(url_for('members/index.php'));

  } else { ?>
    <h1>Delete Member</h1>
    <p>Are you sure you want to delete this bird enthusiast?</p>
    <p><?= h($member->full_name()); ?></p>
    
    <form action="<?= url_for('members/delete.php?id=' . h(u($id))); ?>" method="post">
        <input type="submit" name="commit" value="Delete Member" />
    </form>
    
  <?php } ?>

  


<?php include(SHARED_PATH . '/footer.php'); ?>

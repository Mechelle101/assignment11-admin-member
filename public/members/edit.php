<?php
  require_once('../../private/initialize.php');
  $page_title = 'Edit Member'; 
  include(SHARED_PATH . '/member-header.php');
?>

  <a class="back-link" href="<?= url_for('members/index.php'); ?>">&laquo; Back to List</a>
<h3>Edit Member</h3>
<?php
  if(!isset($_GET['id'])) {
    redirect_to(url_for('/members/index.php'));
  }
  $id = $_GET['id'];

  $member = Member::find_by_id($id);
  if($member == false) {
    redirect_to(url_for('/members/index.php'));
  }


  if(is_post_request()) {

    // Save record using post parameters
    $args = $_POST['member'];
    $member->merge_attributes($args);
    $result = $member->save();

    if($result === true) {
      $_SESSION['message'] = 'The member was updated successfully.';
      redirect_to(url_for('members/show.php?id=' . $id));
    } else {
      // show errors
      display_errors($member->errors);
    }

  } else { ?>
  
    <form action="<?= url_for('members/edit.php?id=' . h(u($id))); ?>" method="post">
      <?php include('form_fields.php'); ?>
      <input type="submit" value="Edit User" />
    </form>
  <?php } ?>

<?php include(SHARED_PATH . '/footer.php'); ?>

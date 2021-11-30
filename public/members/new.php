<?php

require_once('../../private/initialize.php');

if(is_post_request()) {

  // Create record using post parameters
  $args = $_POST['member'];
  $member = new Member($args);
  $result = $member->save();

  if($result === true) {
    $new_id = $member->id;
    $_SESSION['message'] = 'The member was created successfully.';
    redirect_to(url_for('members/show.php?id=' . $new_id));
  } else {
    // show errors
  }

} else {
  // display the form
  $member = new Member;
}

?>

<?php $page_title = 'Create a Member'; ?>
<?php include(SHARED_PATH . '/member-header.php'); ?>

  <a href="<?=url_for('members/index.php'); ?>">&laquo; Back to List</a>

    <h1>Create Member</h1>

    <?=display_errors($member->errors); ?>

    <form action="<?=url_for('members/new.php'); ?>" method="post">

      <?php include('form_fields.php'); ?>

      <div id="operations">
        <input type="submit" value="Create member" />
      </div>
    </form>

  </div>

</div>

<?php include(SHARED_PATH . '/footer.php'); ?>

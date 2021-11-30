<?php
  require_once('../../private/initialize.php');
  $page_title = 'Edit Bird'; 
  include(SHARED_PATH . '/member-header.php'); 
?>

<a class="back-link" href="<?= url_for('/birds/index.php'); ?>">&laquo; Back to List</a>
<h3>Edit Bird</h3>

<?php
 if(!isset($_GET['id'])) {
   redirect_to(url_for('/birds/index.php'));
  }
  $id = $_GET['id'];
  
  $bird = Bird::find_by_id($id);
  if($bird == false) {
    redirect_to(url_for('/birds/index.php'));
  }
  
  if(is_post_request()) {
    // Save record using post parameters
    $args = $_POST['bird'];
    $bird->merge_attributes($args);
    $result = $bird->save();

   // $result = false;
    if($result === true) {
      $session->message('The bird was updated successfully.');
      redirect_to(url_for('birds/show.php?id=' . $id));
    } else {
      // show errors
      display_errors($birds->errors);
    }
    
  } else { ?>

    <form action="<?= url_for('/birds/show.php?id=' . h(u($id))); ?>" method="post">
      <?php include('form_fields.php'); ?>
      <input type="submit" value="Edit Bird" />
    </form>
  
<?php } ?>

<?php include(SHARED_PATH . '/footer.php'); ?>

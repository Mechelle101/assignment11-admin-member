<?php 
require_once('../private/initialize.php');
include(SHARED_PATH . '/header.php'); 
?>

<p><a href="../public/members/login.php">Log in</a> or <a href="../public/members/new.php">Become a Member</a></p>

<h2>Sample of WNC Birds</h2>
<p>Become a member to add more birds to our database!</p>
    <table border="1">
      <tr>
        <th>Common Name</th>
        <th>Habitat</th>
        <th>Food</th>
        <th>Conservation Level</th>
        <th>Backyard Tips</th>
      </tr>

      <?php $birds = Bird::find_all(); ?>

      <?php foreach($birds as $bird) { ?>
      <tr>
        <td><?=h($bird->common_name); ?></td>
        <td><?=h($bird->habitat); ?></td>
        <td><?=h($bird->food); ?></td>
        <td><?=h($bird->conservation_level()); ?></td>
        <td><?=h($bird->backyard_tips); ?></td>
      </tr>
      <?php } ?>

    </table>
    

<?php include(SHARED_PATH . '/footer.php'); ?>
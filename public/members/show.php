<?php 
  require_once('../../private/initialize.php'); 
  $id = $_GET['id'] ?? '1'; // PHP > 7.0
  $member = Member::find_by_id($id);
  $page_title = 'Show All Users: ' . h($member->full_name());
  include(SHARED_PATH . '/member-header.php'); 
?>

  <a class="back-link" href="<?= url_for('members/index.php'); ?>">&laquo; Back to List</a>

    <h1>member: <?= h($member->full_name()); ?></h1>

      <dl>
        <dt>First name</dt>
        <dd><?= h($member->first_name); ?></dd>
      </dl>
      <dl>
        <dt>Last name</dt>
        <dd><?= h($member->last_name); ?></dd>
      </dl>
      <dl>
        <dt>Email</dt>
        <dd><?= h($member->email); ?></dd>
      </dl>
      <dl>
        <dt>Username</dt>
        <dd><?= h($member->username); ?></dd>
      </dl>
    </div>

  </div>

</div>

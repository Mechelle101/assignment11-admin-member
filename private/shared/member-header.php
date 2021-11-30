<!doctype html>

<html lang="en">
  <head>
    <title>WNC Birds <?php 
      if(isset($page_title)) { 
        echo '- ' . h($page_title); 
      } 
      ?>
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" media="all" href="<?= url_for('/stylesheets/public.css'); ?>" />
  </head>

  <body>

    <header>
      <h1>
        <a href="<?= url_for('../public/index.php'); ?>">
          WNC Birds
        </a>
      </h1>
      <h2>Member's Area</h2>
    </header>

    <navigation>
      <ul>
       <?php
        if($session->is_logged_in()) { ?>
            <li>User: <?= $session->username; ?></li>
            <li><a href="<?= url_for('members/logout.php'); ?>">Logout</li>

        <?php } //else { redirect_to(url_for('members/login.php')); }
          ?>
      </ul>
    </navigation>
  

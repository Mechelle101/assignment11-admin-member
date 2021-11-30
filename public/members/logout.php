<?php
require_once('../../private/initialize.php');

// log out the admin
$session->logout();
redirect_to(url_for('members/login.php'));
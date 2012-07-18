<?php
session_start();

$visits = $_SESSION['visits']++;

if ($visits == 0) {
        echo 'I have never seen you before, but I am glad you are here :)';
}
else {
        echo 'Welcome back! You have been here ', $visits, ' time(s) before';
}
session_destroy();
?>

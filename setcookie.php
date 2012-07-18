<?php
$visits = intval($_COOKIE['visits']);
$name = "Byron";
setcookie('visits', $visits + 1, strtotime('+30 days'));

if ($visits == 0) {
        echo "I have never seen you before " . $name . " but I am glad you are here :)";
}
else {
        echo "Welcome back " . $name . "! You have been here ". $visits .  " time(s) before";
}
?>

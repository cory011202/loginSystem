<?php
ob_start();
session_start();
echo "Welcome " . $_SESSION['gdUserName'];

$userAccess = $_SESSION['gdAccess'];
require_once ("includes/functions.php");
//build the array to see what they have access to.
$rights = array(
         "readMusic" => pow(2, 0),
         "readMovies" => pow(2, 1),
         "readTV" => pow(2, 2),
         "edit_group1" => pow(2, 3),
         "edit_group2" => pow(2, 4),
         "edit_group3" => pow(2, 5),
         "admin_group1" => pow(2, 6),
         "admin_group2" => pow(2, 7),
         "admin_group3" => pow(2, 8),
         "usermanager" => pow(2, 9),
         "systemadmin" => pow(2, 10)
      );

//create the array of links to add to the page based on login.
$links = array (
    "readMusic" => "./media/music.php",
    "readMovies" => "./media/movies.php",
    "readTV" => "./media/tv.php",
    "systemadmin" => "/admin/index.php"
);

if (checkLoggedin()){
    echo "<H1>You are already logged in - <A href = \"login.php?do=logout\">logout</A></h1>";
    foreach($rights as $right){
        $key = array_search("$right", $rights);
            if($userAccess & $right ){
                //echo $key . "\n";
                echo "<a href=\"" . $link = $links[$key] . "\">" . $key ."</a><br />";

               // echo $link;
            }
            //echo $key . " " . $right . "\n";
    }
}else{
    echo "<H1>You are not logged in - <A href = \"login.php\">login</A></h1></h1>";
    header("location: login.php");
}

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Welcome CoryPowell.com</title>
    <link type="text/css" rel="stylesheet" href="includes/style/general.css">
</head>
<body>
</body>
</html>
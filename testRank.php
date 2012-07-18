<?php
/**
 * Created by JetBrains PhpStorm.
 * User: cory
 * Date: 2/10/12
 * Time: 10:20 AM
 * To change this template use File | Settings | File Templates.
 */

require_once("includes/functions.php");

$password = "Vinson0)";
echo $password . "\n";
$salt = sha1(md5($password));
echo $salt . "\n";
$password = md5($salt.$password);
echo $password . "\n";

saltPassword("Vinson0)");

//Create users right array
/*$rights = array(
         "read_group1" => pow(2, 0),
         "read_group2" => pow(2, 1),
         "read_group3" => pow(2, 2),
         "edit_group1" => pow(2, 3),
         "edit_group2" => pow(2, 4),
         "edit_group3" => pow(2, 5),
         "admin_group1" => pow(2, 6),
         "admin_group2" => pow(2, 7),
         "admin_group3" => pow(2, 8),
         "usermanager" => pow(2, 9),
         "systemadmin" => pow(2, 10)
      );*/
$rights = array(
         "read_group1" => 1,
         "read_group2" => 2,
         "read_group3" => 4,
         "edit_group1" => 8,
         "edit_group2" => 16,
         "edit_group3" => 32,
         "admin_group1" => 64,
         "admin_group2" => 128,
         "admin_group3" => 256,
         "usermanager" => 512,
         "systemadmin" => 1024
      );
echo "<pre>";

//Create the test user rights variable
$usersRights = "7";
echo "User Fred has a rank of " . $usersRights . ". This allows him to do the following actions on the site.\n";
$total = 0;
//foreach loop to see if we can spit out each users permissions
foreach ($rights as $right){
    $key = array_search("$right", $rights);
    $total = $total + $right;
    if($usersRights & $right )
        echo $key . "\n";
    //echo $key . " " . $right . "\n";
}
echo $total;
echo "</pre>";

//if statement to see if I understand for sure what this is going to do.
if($usersRights & $rights['edit_group3']){
    echo "User can do what you asked";
}else {
    echo "User can not do what you asked";
}//end if
?>

<?php
require_once('includes/db.php');
require_once('includes/functions.php');
$connection = new inc_dataBase();
//connect to the db
$connection->connect();
/**
 * Created by JetBrains PhpStorm.
 * User: cory
 * Date: 2/22/12
 * Time: 2:48 PM
 * To change this template use File | Settings | File Templates.
 */

//recurseDir("/mnt/web/phpstuff/indexproject");
$masterDir = "/mnt/media/software";
    $dirRoot = explode("/", $masterDir);
    $dirRoot= end($dirRoot);
    echo $dirRoot . "\n<br />";
    //echo $masterDir;

//if statment to see if the dir root has been added to the db
if (!mysql_num_rows(mysql_query("SELECT * FROM directories WHERE name = '$dirRoot' AND parent = '0'"))) {
    echo "I'm Going In.";
    //Query to insert data into database
    $result = mysql_query("INSERT INTO directories (id, name, parent) VALUES (NULL, '$dirRoot','0') ") or die(mysql_error());
    initialRecurseDir($masterDir);
} else {
    //call the function
    recurseDir($masterDir);
}

//disconnect from the db
$connection->disConnect();
?>
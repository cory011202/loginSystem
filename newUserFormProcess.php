<?php
require_once("includes/functions.php");
require_once("includes/db.php");

$userName = $_POST['userName'];
$fName = $_POST['fName'];
$lName = $_POST['lName'];
$email = $_POST['email'];
$confEmail = $_POST['confEmail'];
if($_POST['password'] == $_POST['confPassword'] && $_POST['email'] == $_POST['confEmail'] ){
    echo YAY;
    $password = saltPassword($_POST['password']);
    //create new object for db connection
    $connection = new inc_dataBase();
    //connect to the db
    $connection->connect();
    //Query to insert data into database
    	$result = mysql_query("INSERT INTO users (id, userName, fName, lName, email, password) VALUES (NULL, '$userName', '$fName', '$lName', '$email', '$password') ") or die(mysql_error());
    //disconnect from the db
    $connection->disConnect();

}
echo "<a href='login.php'>Click here to return to login.</a> ";

?>
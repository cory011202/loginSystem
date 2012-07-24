<?php
//get all the required files
require_once("../includes/functions.php");
require_once("../includes/db.php");
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Site Administration</title>
    <link type="text/css" rel="stylesheet" href="../includes/style/general.css">
</head>
<body>
<!--<div id="stylized" class="myform">
    <form id="form" name="form" method="POST" action="newUserFormProcess.php">
        <h1>Approve Users</h1>

        <label>
            Username:
            <span class="small">Add your username</span>
        </label>
        <input type="text" name="userName" id="userNameId" />
        <label>
            First Name:
            <span class="small">Add your first name</span>
        </label>
        <input type="text" name="fName" id="fNameId" />

        <button type="submit">Sign-up</button>
        <div class="spacer"></div>
    </form>
</div>-->
<?php
getInactiveUsers();
?>

</body>
</html>
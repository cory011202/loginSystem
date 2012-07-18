<?php
require_once("includes/class.php");
?>
 <html>
 <head>
 <title>New User Signup</title>
<link rel="stylesheet" type="text/css" href="includes/style/general.css" />
</head> 
<body>
    <div id="wrapper">
        <div>
            <form method="POST" action="newUserFormProcess.php">
        </div>
        <div>
            <label>Username:</label> <input type="text" name="userName" id="userNameId" value="Username" size="25" />
        </div>
        <div>
            <label>First Name:</label> <input type="text" name="fName" id="fNameId" value="First Name" size="25" />
        </div>
        <div>
            <label>Last Name:</label> <input type="text" name="lName" id="lNameId" value="Last Name" size="25" />
        </div>
        <div>
            <label>Email:</label><input type="text" name="email" id="emailId" value="someone@example.com" size="25">
         </div>
        <div>
            <label>Conf Email:</label> <input type="text" name="confEmail" id="confEmailId" value="someone@example.com" size="25">
        </div>
        <div>
            <label>Password:</label><input type="password" name="password" id="password" value="" size="25">
         </div>
        <div>
            <label>Conf Pass:</label> <input type="password" name="confPassword" id="confPassword" value="" size="25">
        </div>
        <div class="testdiv">
            <input type="submit" value="Submit">
            <input type="reset" value="Clear">
        </div>
        <div>
            </form>
        </div>
    </div>
</body>
 </html>";

<?php
ob_start();
session_start();

//require_once ("functions.php");

if (!isset($_SESSION['gdusername']) and !isset($_SESSION['gdpassword']))
    {
	//echo "<H1>You are not logged in - <A href = \" login.php \">login</A>";
      ?><h1>You are no logged in - <a href="<?php echo "login.php"?>">login</a> </h1>
    }else
    {	
?> 
<html>
<body>
<h1>ok does this really work?</h1>
<form NAME="login1" ACTION="login.php?do=login" METHOD="POST" ONSUBMIT="return aValidator();">
        <input TYPE="hidden" name="returnurl" value="<?//$returnurl?>">
    <table>
        <tr>
            <TD ALIGN="CENTER" COLSPAN="4"><input TYPE="SUBMIT" name="submit" value="Logout"></TD>
        </tr>
    </table>
        </form> 
</body>
</html>
<?php
    }
?>

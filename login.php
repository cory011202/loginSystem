<?php
//phpinfo();
session_start();
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);
ob_start();

require_once("includes/functions.php");
require_once("includes/db.php");

$returnurl = urlencode(isset($_GET["returnurl"])?$_GET["returnurl"]:"");

if($returnurl == "")
    $returnurl = urlencode(isset($_POST["returnurl"])?$_POST["returnurl"]:"");
//this get what is appended to the url example login.php?do= something in the switch statemnt below
$do = isset($_GET["do"])?$_GET["do"]:"";
//this takes the $do variabel and makes it all lowercase to ensure it fits in the switch statement below
$do = strtolower($do);

switch($do)
{
//check 1 if $do is null then check to see if they user is logged in or not.
case "":
    if (checkLoggedin()){
        //if a user is not  logged in then display the below information
        echo "<H1>You are already logged in - <A href = \"login.php?do=logout\">logout</A></h1>";
    }else{
        //if a user is not logged in then display the login form. this form will then use the $_GET and append the url
        // and reload the page then send it below to check the username and pw.
        ?>
        <form NAME="login1" ACTION="login.php?do=login" METHOD="POST" ONSUBMIT="return aValidator();">
        <input TYPE="hidden" name="returnurl" value="<?php $returnurl ?>">
        <TABLE cellspacing="3" align="center">
            <tr>
                <td colspan="4"><h1>Welcome to  my Login System.</h1></td>
            </tr>
            <TR>
                <TD>Username:</TD>
                <TD><input TYPE="TEXT" NAME="username"></TD>
                <TD>Password:</TD>
                <TD><input TYPE="PASSWORD" NAME="password"></TD>
            </TR>
            <TR>
                <TD colspan="4" ALIGN="center"><input TYPE="CHECKBOX" NAME="remme">&nbsp;Remember me for the next time I visit</TD>
            </TR>
            <TR>
                <TD colspan="4" ALIGN="center"><a href="newUserForm.php">Click here to request access.</a></TD>
            </TR>
            <TR>
                <TD ALIGN="CENTER" COLSPAN="4"><input TYPE="SUBMIT" name="submit" value="Login"><input TYPE="reset" name="reset" value="Reset"></TD>
            </TR>
        </form>
        </TABLE>
    <?php
    }
    break;
//check 2 This will check to see that a person has tried to login and the returnurl is appended
case "login":
    //if a user tries this then it will check to see if the username and password are set
    $username = isset($_POST["username"])?$_POST["username"]:"";
    $password = isset($_POST["password"])?$_POST["password"]:"";
    //if statement to check if the username or password is blank
    if ($username=="" or $password=="" ){
        echo "<h1>Username or password is blank</h1>";
        clearsessionscookies();
        header("location: login.php?returnurl=$returnurl");
    }else{
        if(confirmuser($username,saltPassword($password))){
            $access = getUserAccess($username);
            createsessions($username,$password,$access);
            if ($returnurl<>""){
                header("location: $returnurl");
            }else{
                header("Location: index.php");
            }
        }else{
            echo "<h1>Invalid Username and/Or password</h1>";
            clearsessionscookies();
            header("location: login.php?returnurl=$returnurl");
        }
    }

    break;
case "logout":
    clearsessionscookies();
    header("location: index.php");
    break;
}
?>

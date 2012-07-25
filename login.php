<?php
//phpinfo();
session_start();
/*ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL);*/
ob_start();
//get all the required files
require_once("includes/functions.php");
require_once("includes/db.php");
//seems to work without this line of code I am leaving it in here till I know for sure what it does
$returnurl = urlencode(isset($_GET["returnurl"])?$_GET["returnurl"]:"");

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Welcome CoryPowell.com</title>
    <link type="text/css" rel="stylesheet" href="includes/style/general.css">
</head>
<body>
<?php
if($returnurl == ""){
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
            //if a user is already logged in then display the index.php page
            header("Location: index.php");
        }else{
            //if a user is not logged in then display the login form. this form will then use the $_GET and append the url
            // and reload the page then send it below to check the username and pw.
            ?>
            <div id="stylized" class="myform">
                <form id="form" name="form" method="POST" action="login.php?do=login">
                    <h1>Restricted site please login below.</h1>

                    <label>
                        Username:
                    </label>
                    <input type="text" name="userName" id="userNameId" />
                    <!--Not sure if this is needed-->
                    <input TYPE="hidden" name="returnurl" value="<?php $returnurl ?>">

                    <label>
                        Password:
                    </label>
                    <input type="password" name="password" id="password" />

                    <button type="submit">Login</button>
                    <div class="spacer"></div>
                </form>
            </div>
            <?php
        }
        break;
    //check 2 This will check to see that a person has tried to login and the returnurl is appended
    case "login":
        //if a user tries this then it will check to see if the username and password are set
        $userName = isset($_POST["userName"])?$_POST["userName"]:"";
        $password = isset($_POST["password"])?$_POST["password"]:"";
        //if statement to check if the username or password is blank
        if ($userName=="" or $password=="" ){
            echo "<h1>Username or password is blank</h1>";
            clearsessionscookies();
            header("location: login.php?returnurl=$returnurl");
        }else{
            if(confirmuser($userName,saltPassword($password))){
                $access = getUserAccess($userName);
                createsessions($userName,$password,$access);
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
}//end if
?>

</body>
</html>
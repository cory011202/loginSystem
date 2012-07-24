<?php

function createsessions($username,$password,$access,$remme){
    //Add additional member to Session array as per requirement
    //session_register();

    $_SESSION["gdusername"] = $username;
    $_SESSION["gdpassword"] = md5($password);
    $_SESSION["gdaccess"] = $access;
    $_SESSION["remme"] = $remme;
}

function clearsessionscookies(){
    unset($_SESSION['gdusername']);
    unset($_SESSION['gdpassword']);
    
    session_unset();    
    session_destroy(); 

    setcookie ("gdusername", "",time()-60*60*24*100, "/");
    setcookie ("gdpassword", "",time()-60*60*24*100, "/");
}

function confirmUser($username,$password){
    //create new object for db connection
    $connection = new inc_dataBase();
    //connect to the db
    $connection->connect();
    $userQuery = mysql_query("SELECT userName, password, access, active  FROM users WHERE userName = '$username'")or die(mysql_error());
    mysql_query($userQuery);
    while($row = mysql_fetch_array($userQuery)){
        $regUser = $row['userName'];
        $regPassword = $row['password'];
        $access = $row['access'];
        $active = $row['active'];
    }

    /* Validate from the database but as for now just demo username and password */
    if($username == $regUser && $password == $regPassword && $active){
        return true;
    }else{
        return false;
    }
    //disconnect from the db
    $connection->disConnect();
}

function checkLoggedin(){
    //if statement to see if the user is logged in
    if(isset($_SESSION['gdusername']) AND isset($_SESSION['gdpassword'])){
        // if the users is already logged in the return true
        return true;
    //else if they are not logged in but are logging in then this else if will check that the username and pw are
    //correct and will create the session.
    }elseif(isset($_COOKIE['gdusername']) && isset($_COOKIE['gdpassword'])){
        //nested if statement that will be checked from the login page
        if(confirmUser($_COOKIE['gdusername'],$_COOKIE['gdpassword'])){
            //if the username and pw are correct then the session will be created and then will return true
            createsessions($_COOKIE['gdusername'],$_COOKIE['gdpassword']);
            return true;
        }else{
            //if they do not have a correct username and pw the statement will return false and will clear all sessions
            //and cookies
            clearsessionscookies();
            return false;
        }
    }else{
        //if it doesnt meet any of the criteria in this statement, then it will return false
        return false;
    }
}

function logout(){
    clearsessionscookies();
    header("location: music.php");
}

function saltPassword($password){
    //create a salt for the password
    $salt = sha1(md5($password));
    //md5 the salt and the password together
    $password = md5($salt.$password);
    //echo $password;
    return $password;
}

function getUserAccess($username){
    //create new object for db connection
        $connection = new inc_dataBase();
        //connect to the db
        $connection->connect();
        $userQuery = mysql_query("SELECT access FROM users WHERE userName = '$username'")or die(mysql_error());
        mysql_query($userQuery);
        while($row = mysql_fetch_array($userQuery)){
            $access = $row['access'];
        }
    return $access;
    //disconnect from the db
        $connection->disConnect();
}

function checkAccess($access){
    //echo "Test one";
    //build the array to see what they have access to
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
    //echo $access;
   //if statement to see if I understand for sure what this is going to do.
   if($access & $rights['readTV']){
       //echo "User can do what you asked";
       return true;
       //return false;
   }else {
      // echo "User can not do what you asked";
       //return true;
       return false;
   }//end if
}

function initialRecurseDir($dir) {
    //if the $dir is a dir then continue
    if(is_dir($dir)) {
        if($dh = opendir($dir)){
            while($file = readdir($dh)){
                if($file != '.' && $file != '..' && $file != "Thumbs.db"){
                    //This builds the complete file path
                    $filePath = $dir . "/" . $file;
                    //if statement to see if its a directory or file
                    if(is_dir($filePath)){
                        //This splits the file path and returns and array
                        $parentDirPath = explode("/",$filePath);
                        //this figures out what the parent directory is
                        $parentDir = count($parentDirPath) -2;
                        //This figures out waht the current directory is most like to be removed
                        //$curDir = count($parentDirPath) -2;
                        //This gets the last part of the file path and sets the name of the directory or file
                        $name = end($parentDirPath);
                        //This is test code to tell what the code is doing will be removed for actual db population
                        echo $name . " Is a Directory and its parent directory is " . $parentDirPath[$parentDir] . "<br / >";
                        //This escapes all characters for the db queries
                        $name = mysql_real_escape_string($name);
                        //This escapes the parent dir for the query below
                        $parentDir = mysql_real_escape_string($parentDirPath[$parentDir]);
                        //$parentDir = $parentDirPath[$parentDir];
                        $dir = mysql_real_escape_string($dir);
                        //Build the query to get the parent directory id
                        $getParentDirId = mysql_query("SELECT id FROM directories WHERE name = '$parentDir' ")
                                                        or die(mysql_error());
                        //While loop to set the parent id for use
                        while($row = mysql_fetch_array($getParentDirId)){
                            $parentDirId = $row[id];
                        }
                        echo "parent id " . $parentDirId;
                        //Build the query to check if the file already exists in the dg
                        $checkExists = mysql_query("SELECT COUNT(id) AS 'exists' FROM directories WHERE name = '$name' AND parent = '$parentDirId' AND path = '$dir'")
                            or die(mysql_error());
                        //While loop to set the exists variable
                        while($row = mysql_fetch_array($checkExists)){
                            $exists = $row[exists];
                            echo " This is the $exists";

                        //If statment that checks the exists variable to see if it needs to add the current information to the db
                        if($exists <1){
                            //Query to insert data into database
                            $result = mysql_query("INSERT INTO directories (id,path, name, parent) VALUES (NULL,'$dir', '$name', '$parentDirId') ")
                                or die(mysql_error());
                        }
                        }
                        //Since this is a directory this calls the function again to loop back through a subfolder
                        initialRecurseDir($filePath);

                    }elseif(is_file($filePath)){
                        //This splits the filepath and returns and array
                        $parentDirPath = explode("/",$filePath);
                        //This gets the parent dir to the file might not be needed
                        $parentDir = count($parentDirPath) -3;
                        //This gets the directory that the file is located
                        $curDir = count($parentDirPath) -2;
                        //This gets the last part of the file path and sets the name of the directory or file
                        $name = end($parentDirPath);
                        //This returns the filesize in MB need to write function to have it do gb & kb depending on size
                        $fileSize = round(filesize($filePath) /1048576);
                        //This splits the filename from the extension and returns and array
                        //**********************************************************************************************************
                        //*************************need to account for names like mrs. rita.mp3 ************************************
                        //**********************************************************************************************************
                        $getExtentsion = explode(".", $name);
                        //This sets the extension
                        $extenstion = $getExtentsion[1];
                        //This sets the filename
                        $fileName = $getExtentsion[0];
                        //This escapes all characters for the db queries
                        $name = mysql_real_escape_string($name);
                        $fileName = mysql_real_escape_string($fileName);
                        $curDirEsc = mysql_real_escape_string($parentDirPath[$curDir]);
                        //This escapes the parent dir for the query below
                        $parentDir = mysql_real_escape_string($parentDirPath[$parentDir]);
                        //$parentDir = $parentDirPath[$parentDir];
                        $dir = mysql_real_escape_string($dir);
                        //Build the query to get the parent directory id
                        $getParentDirId = mysql_query("SELECT id FROM directories WHERE name = '$curDirEsc' ")
                                                        or die(mysql_error());
                        //While loop to set the parent id for use
                        while($row = mysql_fetch_array($getParentDirId)){
                            $parentDirId = $row[id];
                        }
                        echo "parent id: " . $parentDirId;
                        //Build the query to check if the file already exists in the dg
                        $checkExists = mysql_query("SELECT COUNT(id) AS 'exists' FROM directories WHERE name = '$name' AND parent = '$parentDirId' AND path = '$dir'")
                            or die(mysql_error());
                        //While loop to set the exists variable
                        while($row = mysql_fetch_array($checkExists)){
                            $exists = $row[exists];
                            echo " This is the $exists";

                            //If statment that checks the exists variable to see if it needs to add the current information to the db
                            if($exists <1){
                                //Query to insert data into database
                                $result = mysql_query("INSERT INTO files (id,path, directory, name, size, type)
                                    VALUES (NULL,'$dir', '$parentDirId', '$fileName', '$fileSize', '$extension') ") or die(mysql_error());
                            }
                        }
                        //This is test code to tell what the code is doing will be removed for actual db population

                        echo "<br />\t\t" . $fileName . " Is Located in " . $dir . " current directory is " . $parentDirPath[$curDir] .
                            " size of " . $fileSize . " MB extenstion " . $extenstion . "<br />";

                    }else{
                        //echo $filePath . " WTF?<br />";
                    }

                }
            }//End while
        }
        closedir($dh);
    }
}

function recurseDir($dir) {
    //if the $dir is a dir then continue
    if(is_dir($dir)) {

        if($dh = opendir($dir)){

            while($file = readdir($dh)){

                if($file != '.' && $file != '..' && $file != "Thumbs.db"){
                    //This builds the complete file path
                    $filePath = $dir . "/" . $file;
                    //echo " **************This is the fucking file path $filePath ******************************<br />";

                    //if statement to see if its a directory or file
                    if (is_dir($filePath)) {

                        //This escapes all characters for the db queries
                        $file = mysql_real_escape_string($file);
                        $dir = mysql_real_escape_string($dir);

                        //Build the query to get the parent directory id
                        $getParentDirId = mysql_query("SELECT parent FROM directories WHERE name = '$file' AND path = '$dir'")
                            or die(mysql_error());

                        while($row = mysql_fetch_array($getParentDirId)){

                            $parentDirId = $row['0'];
                            echo " This is the parent id $parentDirId";

                        }

                        //echo "SELECT COUNT(id) AS 'exists' FROM directories WHERE name = '$file' AND parent = '$parentDirId' AND path = '$dir'";
                        //Build the query to check if the file already exists in the db
                        $checkExists = mysql_query("SELECT COUNT(id) AS 'exists' FROM directories WHERE name = '$file' AND parent = '$parentDirId' AND path = '$dir'")
                            or die(mysql_error());

                        //While loop to set the exists variable
                        while($row = mysql_fetch_array($checkExists)){

                            $exists = $row[exists];

                            //If statement that checks the exists variable to see if it needs to add the current information to the db
                            if($exists != 0){

                                echo $file . " I am in the DB<br />";
                                //Query to insert data into database
                                //$result = mysql_query("INSERT INTO directories (id, name, parent) VALUES (NULL, '$file', '$parentDirId]') ") or die(mysql_error());

                            }else {

                                echo $file . " " . $parentDirId .  " <b>I think I need to add</b><br />";
                                $result = mysql_query("INSERT INTO directories (id, name, parent) VALUES (NULL, '$file', '$parentDirId]') ") or die(mysql_error());

                            }
                        }

                        //Since this is a directory this calls the function again to loop back through a subfolder
                        recurseDir($filePath, $isFirstRun);

                    } elseif (is_file($filePath)){

                        //This returns the filesize in MB need to write function to have it do gb & kb depending on size
                        //$fileSize = round(filesize($filePath) /1048576);

                        //This splits the filename from the extension and returns and array
                        //$getExtentsion = explode(".", $file);

                        //This sets the extension
                        //$extenstion = $getExtentsion[1];

                        //This sets the filename
                        //$fileName = $getExtentsion[0];

                        //This is test code to tell what the code is doing will be removed for actual db population
                        //echo "<br />\t\t" . $fileName . " Is Located in " . $dir . " parent directory is " . $dir .
                        //    " size of " . $fileSize . " MB extenstion " . $extenstion . "<br />";

                    } else {

                        echo $filePath . " WTF?<br />";

                    }

                }
            }//End while
        }
        closedir($dh);
    }
}
?> 

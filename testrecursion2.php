<?php
require_once('includes/db.php');
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
?><pre><?php
//recurseDir("/mnt/web/phpstuff/indexproject");
$masterDir = "/mnt/media/Pictures/sarah";
    $dirRoot = explode("/", $masterDir);
    $dirRoot= end($dirRoot);
    echo $dirRoot;
//Build the query to check if the file already exists in the dg
$checkRootExists = mysql_query("SELECT COUNT(id) FROM
 directories WHERE name = '$dirRoot' AND parent = '0'")
                            or die(mysql_error());
//While loop to set the exists variable
while($row = mysql_fetch_array($checkRootExists)){
    $rootExists = $row[0];
}
if($rootExists < 1){
    echo " Im going in!";
    //Query to insert data into database
    $result = mysql_query("INSERT INTO directories (id, name, parent) VALUES (NULL, '$dirRoot','0') ") or die(mysql_error());
}
recurseDir($masterDir);

?></pre><?php
function recurseDir($dir) {
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
                            $result = mysql_query("INSERT INTO directories (id,path, name, parent) VALUES (NULL,'$dir', '$name', '$parentDirId]') ") or die(mysql_error());
                        }
                        }
                        //Since this is a directory this calls the function again to loop back through a subfolder
                        recurseDir($filePath);

                    }elseif(is_file($filePath)){
                        //This splits the filepath and returns and array
                        $parentDirPath = explode("/",$filePath);
                        //This gets the paretnt dir to the file might not be needed
                        $parentDir = count($parentDirPath) -3;
                        //This gets the directory that the file is located
                        $curDir = count($parentDirPath) -2;
                        //This gets the last part of the file path and sets the name of the directory or file
                        $name = end($parentDirPath);
                        //This returns the filesize in MB need to write function to have it do gb & kb depending on size
                        $fileSize = round(filesize($filePath) /1048576);
                        //This splits the filename from the extension and returns and array
                        $getExtentsion = explode(".", $name);
                        //This sets the extension
                        $extenstion = $getExtentsion[1];
                        //This sets the filename
                        $fileName = $getExtentsion[0];
                        //This is test code to tell what the code is doing will be removed for actual db population
                        /*                        echo "<br />\t\t" . $fileName . " Is a file Located in " . $parentDirPath[$curDir] . " The parent directory is " . $parentDirPath[$parentDir] .
   " and a file size of " . $fileSize . " MB and an extenstion of " . $extenstion . "<br />";*/
                        /*echo "<br />\t\t" . $fileName . " Is Located in " . $parentDirPath[$curDir] . " parent directory is " . $parentDirPath[$parentDir] .
                            " size of " . $fileSize . " MB extenstion " . $extenstion . "<br />";*/
                        //echo "this is what you are trying to echo " . $directory_tree_file['pDir'];

                    }else{
                        //echo $filePath . " WTF?<br />";
                    }

                }
            }//End while
        }
        closedir($dh);
    }
}
//disconnect from the db
$connection->disConnect();
?>
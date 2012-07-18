
<?php

//ini_set(“memory_limit”,”256M”);
// ------------ lixlpixel recursive PHP functions -------------
// scan_directory_recursively( directory to scan, filter )
// expects path to directory and optional an extension to filter
// of course PHP has to have the permissions to read the directory
// you specify and all files and folders inside this directory
// ------------------------------------------------------------

// to use this function to get all files and directories in an array, write:
$filestructure = scan_directory_recursively('/mnt/web/phpstuff/indexproject');
//$filestructure = scan_directory_recursively('/mnt/media/TV_Shows/Big Bang Theory, The');


// to use this function to scan a directory and filter the results, write:
// $fileselection = scan_directory_recursively('directory', 'extension');

function scan_directory_recursively($directory, $filter=FALSE)
{
	// if the path has a slash at the end we remove it here Mine doesn't so this will be skipped
	if(substr($directory,-1) == '/'){
		$directory = substr($directory,0,-1);
	}

	// if the path is not valid or is not a directory ...
	if(!file_exists($directory) || !is_dir($directory))	{
		// ... we return false and exit the function
		return FALSE;

	// ... else if the path is readable
	}elseif(is_readable($directory)){
		// we open the directory
		$directory_list = opendir($directory);

		// and scan through the items inside
		while (FALSE !== ($file = readdir($directory_list))){
			// if the filepointer is not the current directory
			// or the parent directory
			if($file != '.' && $file != '..'){
				// we build the new path to scan
				$path = $directory.'/'.$file;

				// if the path is readable
				if(is_readable($path)){
					// we split the new path by directories
					$subdirectories = explode('/',$path);

					// if the new path is a directory
					if(is_dir($path)){
                        $parentDirPath = explode("/",$path);
                        $number = count($parentDirPath) - 2;
                        //print_r($parentDirPath);

						// add the directory details to the file list
						$directory_tree[] = array(
                            'pDir'    => $parentDirPath[$number],
							'path'    => $path,
							'name'    => end($subdirectories),
							'kind'    => 'directory',
							// we scan the new path by calling this function
							'content' => scan_directory_recursively($path, $filter));
                           echo "<pre> directory tree";
                            print_r($directory_tree);
                            echo "</pre>";
                            //echo $path . "<br />";
					// if the new path is a file
					}elseif(is_file($path)){
						// get the file extension by taking everything after the last dot
						$extension = end(explode('.',end($subdirectories)));

						// if there is no filter set or the filter is set and matches
						if($filter === FALSE || $filter == $extension){
                            $parentDirPath = explode("/",$path);
                            $number = count($parentDirPath) - 2;
                            $path = explode("/",$path);
                            $curDir = count($path) -2;
							// add the file details to the file list
							$directory_tree_file[] = array(
                                'pDir' => $parentDirPath[$number],
                                'Dir'    => $path[$curDir],
								'path'      => $path,
								'name'      => end($subdirectories),
								'extension' => $extension,
								'size'      => round(filesize($path) /1048576),
								'kind'      => 'file');
                            echo "<pre>";
                             print_r($directory_tree_file);
                             echo "</pre>";
                                 //$path = mysql_real_escape_string($path);
                                 //echo $path . "\n";
                                 
                                // $path_parts = pathinfo($path);
                                 $dirPath = $path_parts['dirname'] . "/";
                                 //$fileName = $path_parts['basename'];
                                 //$fileName = explode("." ,$fileName);
                                // echo " directory is = " .$dirPath . " filename is = " . $fileName[0] . " extension = " . $fileName[1] . "\n<br />";
                                // echo "File " . $fileName{0} . " has the follow information<br />" . "Type = " . $fileName[1] . "<br /> It is located in " . $dirPath . "<br /><hr>";

						}
					}//End elseif is_file
				}//End If is_readable
			}//End If file is not = . or ..
		}//End While
		// close the directory
		closedir($directory_list); 

		// return file list
		return $directory_tree;

	// if the path is not readable ...
	}else{		// ... we return false
		return FALSE;	
	}
}
// ------------------------------------------------------------

?>

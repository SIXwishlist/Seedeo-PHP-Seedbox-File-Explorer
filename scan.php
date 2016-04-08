<?php

// Powered by Lord_Apo, a French 15 yo Developper 
// 
// Support me by making a donation --> https://www.paypal.me/lordapo
//
// [ENGLISH] Contact, Support & Pro:        lordapo-en@outlook.com
// [FRANCAIS] Contact, Support & Pro:       lordapo-fr@outlook.com
//
// https://github.com/LordApo/Seedeo-PHP-Seedbox-File-Explorer
// 
// Under The MIT License (MIT) --> https://github.com/LordApo/Seedeo-PHP-Seedbox-File-Explorer/blob/master/LICENSE
// Copyright (c) 2016 LordApo



$dir = "Seedbox"; // EDITABLE Your Files Directory (Edit at line 63 too)

// Run the recursive function 

$response = scan($dir);


// This function scans the files folder recursively, and builds a large array

function scan($dir){

	$files = array();

	// Is there actually such a folder/file?

	if(file_exists($dir)){
	
		foreach(scandir($dir) as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			}

			if(is_dir($dir . '/' . $f)) {

				// The path is a folder

				$files[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $dir . '/' . $f,
					"items" => scan($dir . '/' . $f) // Recursively get the contents of the folder
				);
			}
			
			else {

				// It is a file

				$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);
			}
		}
	
	}

	return $files;
}



// Output the directory listing as JSON

header('Content-type: application/json');

echo json_encode(array(
	"name" => "Seedbox",
	"type" => "folder",
	"path" => $dir,
	"items" => $response
));

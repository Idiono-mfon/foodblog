<?php

	// define('PROJECT_PATH', 'path/where/file/will/be/uploaded/to');
// Form upload functions

// Configuration
// finfo_open()


// finfo_file()

// Use MAX_FILE_SIZE in your form but don't trust it.
// Check it again in your application
// $max_file_size = 2048576; // 1 MB expressed in bytes

// $upload_path = PROJECT_PATH."/uploads";

$upload_path = "../uploads";

// Define allowed filetypes to check against during validations
$allowed_mime_types = ['image/png','image/jpg', 'image/jpeg'];
$allowed_extensions = ['png','jpg', 'jpeg'];

$check_is_image = true;
$check_for_php = true;

// Provides plain-text error messages for file upload errors.
function file_upload_error($error_integer) {
	$upload_errors = array(
		// http://php.net/manual/en/features.file-upload.errors.php
		UPLOAD_ERR_OK 				=> "No errors.",
		UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
	  UPLOAD_ERR_NO_FILE 		=> "No file.",
	  UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
	);
	return $upload_errors[$error_integer];

	/*
	
		UPLOAD_ERR_OK => 0

		UPLOAD_ERR_INI_SIZE = 1

		UPLOAD_ERR_FORM_SIZE = 2

		UPLOAD_ERR_PARTIAL = 3

		UPLOAD_ERR_NO_FILE = 4

		UPLOAD_ERR_NO_TMP_DIR = 5

		UPLOAD_ERR_NO_FILE = 6

		UPLOAD_ERR_CANT_REWRITE = 7

		UPLOAD_ERR_EXTENSION = 8
	
	
	*/





}

// Sanitizes a file name to ensure it is harmless
function sanitize_file_name($filename) {
	// Remove characters that could alter file path.
	// I disallowed spaces because they cause other headaches.
	// "." is allowed (e.g. "photo.jpg") but ".." is not.
	$filename = preg_replace("/([^A-Za-z0-9_\-\.]|[\.]{2})/", "", $filename);
	// https://www.w3schools.com/php/php_ref_regex.asp
	// basename() ensures a file name and not a path
	$file_url_name = uniqid('food_', true);

	$result = ["name"=> $filename,"file_url_name"=>$file_url_name];
	return $result;
}

// Returns the file permissions in octal format.
function file_permissions($file) {
	// fileperms returns a numeric value
	$numeric_perms = fileperms($file);
	// but we are used to seeing the octal value
	$octal_perms = sprintf('%o', $numeric_perms);
	return substr($octal_perms, -4);
}

// Returns the file extension of a file
function file_extension($file) {
	return pathinfo($file, PATHINFO_EXTENSION);
	//$path_parts = pathinfo($file);
	// pathinfo($path, $options = PATHINFO_DIRNAME | PATHINFO_BASENAME | PATHINFO_EXTENSION | PATHINFO_FILENAME)
	//return isset($path_parts['extension'])? $path_parts['extension']:"";
}

// Searches the contents of a file for a PHP embed tag
// The problem with this check is that file_get_contents() reads 
// the entire file into memory and then searches it (large, slow).
// Using fopen/fread might have better performance on large files.
function file_contains_php($file) {
	// $contents = file_get_contents($file);
	$contents = fread(fopen($file["tmp_name"], 'r'), $file["size"]);
	$position = strpos($contents, '<?php');
	return $position !== false;
}

// Resize Image to meet standard expected size

function resizeImage($resourceType,$image_width,$image_height,$resize_width=null,$resize_height= null) {
    $resizeWidth =  $resize_width === null ? 100 : $resize_width;
    $resizeHeight = $resize_height === null ? 100 : $resize_height;
    $imageLayer = imagecreatetruecolor($resizeWidth,$resizeHeight);
    imagecopyresampled($imageLayer,$resourceType,0,0,0,0,$resizeWidth,$resizeHeight, $image_width,$image_height);
    return $imageLayer;
}


// Runs file being uploaded through a series of validations.
// If file passes, it is moved to a permanent upload directory
// and its execute permissions are removed.
function upload_file($file) {
	global $upload_path, $max_file_size, $allowed_mime_types, $allowed_extensions, $check_is_image, $check_for_php;
	$errors = [];
	
	if(!empty($file)) {
		// Sanitize the provided file name.
		$result = sanitize_file_name($file['name']);
		$file_extension = file_extension($file["name"]);

		$file_type = $file['type'];
		$tmp_file = $file['tmp_name'];
		$error = $file['error'];
		$file_size = $file['size'];
		// Prepend the base upload path to prevent hacking the path
		// Example: $file_name = '/etc/passwd' becomes harmless
		
		// Even more secure to assign a new name of your choosing.
		// Example: 'file_536d88d9021cb.png'
		// $unique_id = uniqid('file_', true); 
		// $new_name = "{$unique_id}.{$file_extension}";
		$file_path = $upload_path . '/' . $result["file_url_name"].".".$file_extension;
		
		if($error > 0) {
			// Display errors caught by PHP
			$errors[] =  "Error: " . file_upload_error($error);
		} 
		
		if(!is_uploaded_file($tmp_file)) {
			$errors[] =  "Error: Does not reference a recently uploaded file.<br />";	

		// } elseif($file_size > $max_file_size) {
			// PHP already first checks php.ini upload_max_filesize, and 
			// then form MAX_FILE_SIZE if sent.
			// But MAX_FILE_SIZE can be spoofed; check it again yourself.
			// $errors[] = "Error: File size is too big.<br />";
		} 
		
		if(!in_array($file_type, $allowed_mime_types)) {
			$errors[] = "Not an allowed mime type.";

		} 
		
		if(!in_array($file_extension, $allowed_extensions)) {
			// Checking file extension prevents files like 'evil.jpg.php' 
			$errors[] = "Not an allowed file extension.";
		
		} 
		
		if($check_is_image && (getimagesize($tmp_file) === false)) {
			// getimagesize() returns image size details, but more importantly,
			// returns false if the file is not actually an image file.
			// You obviously would only run this check if expecting an image.
			$errors[] = "Not a valid image file.";
		} 
		
		if($check_for_php && file_contains_php($file)) {
			// A valid image can still contain embedded PHP.
			$errors[] = "File contains PHP code.";
	
		} 
		
		if(file_exists($file_path)) {
			// if destination file exists it will be over-written
			// by move_uploaded_file()
			$errors[] = "A file with that name already exists in target location";
			// Could rename or force user to rename file.
			// Even better to store in uniquely-named subdirectories to
			// prevent conflicts.
			// For example, if the database record ID for an image is 1045: 
			// "/uploads/profile_photos/1045/uploaded_image.png"
			// Because no other profile_photo has that ID, the path is unique.
		} 
		
		if(empty($errors)){
			// Upload the file
			if(move_uploaded_file($tmp_file, $file_path)) {
				$response["name"] = $result["name"];
				$response["path"] = $file_path;
				$response["type"] = $file_type;
				$response["mode"] = true;
				return $response;
			}

			// Success!
			// move_uploaded_file has is_uploaded_file() built-in
			// $sourceProperties = getimagesize($tmp_file);
			// $uploadImageType = $sourceProperties[2];
			// $sourceImageWidth = $sourceProperties[0];
			// $sourceImageHeight = $sourceProperties[1];

			// Expected resized image size
			// $resize_width = isset($file["resize_width"]) ? $file["resize_width"] : null;
			// $resize_height = isset($file["resize_height"]) ? $file["resize_height"] : null;

			//    switch ($uploadImageType) {

			// case IMAGETYPE_JPEG:
			// 	 $resourceType = imagecreatefromjpeg($tmp_file); 
			// 	 $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$resize_width,$resize_height);
			// 	 imagejpeg($imageLayer, $file_path);
			// 	 break;

			// case IMAGETYPE_PNG:
			// 	 $resourceType = imagecreatefrompng($tmp_file); 
			// 	 $imageLayer = resizeImage($resourceType,$sourceImageWidth,$sourceImageHeight,$resize_width,$resize_height);
			// 	 imagepng($imageLayer,$file_path);
			// 	 break;
	 
			// default:
			// 	$imageProcess = 0;
			// 	break;
			//  }
			 
			// $success["name"] = $result["name"];
			// $success["path"] = str_replace(PROJECT_PATH."/","",$file_path);
			// $success["type"] = $file_type;
			// $success["success"] = true;

			// return $success;
		}else{

		}
		
		
		
		else {
		

			// if(move_uploaded_file($tmp_file, $file_path)) {
			// 	// remove execute file permissions from the file
			// 	if(chmod($file_path, 0644)) {
			// 		$file_permissions = file_permissions($file_path);
			// 	} 
			// 	$success["name"] = $result["name"];
			// 	$success["path"] = $file_path;
			// 	$success["type"] = $file_type;


			// }

			
		}
		// Differentiate erorr from success array
		$errors["success"] = false;
		return $errors;
	}
	else{
		$errors[] = "File was not uploaded ";
		$errors["success"] = false;
		return $errors;
	}




}



?>

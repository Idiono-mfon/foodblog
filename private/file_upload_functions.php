<?php
// $upload_path = PROJECT_PATH."/uploads";
$upload_path = UPLOAD_PATH;

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
}

// Sanitizes a file name to ensure it is harmless
function sanitize_file_name($filename) {
	$filename = preg_replace("/([^A-Za-z0-9_\-\.]|[\.]{2})/", "", $filename);
	$file_url_name = uniqid('food_', true);

	$result = ["name"=> $filename,"file_url_name"=>$file_url_name];
	return $result;
}

// Returns the file permissions in octal format.
function file_permissions($file) {
	$numeric_perms = fileperms($file);
	$octal_perms = sprintf('%o', $numeric_perms);
	return substr($octal_perms, -4);
}

// Returns the file extension of a file
function file_extension($file) {
	return pathinfo($file, PATHINFO_EXTENSION);
}

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

function upload_file($file) {
	global $upload_path, $max_file_size, $allowed_mime_types, $allowed_extensions, $check_is_image, $check_for_php;
	$errors = [];
	
	if(!empty($file)) {
		$result = sanitize_file_name($file['name']);
		$file_extension = file_extension($file["name"]);
		$file_type = $file['type'];
		$tmp_file = $file['tmp_name'];
		$error = $file['error'];
		$file_size = $file['size'];
		$file_path = $upload_path . '/' . $result["file_url_name"].".".$file_extension;
				
		if($error > 0) {
			// Display errors caught by PHP
			$errors[] =  "Error: " . file_upload_error($error);
		} 
		
		if(!is_uploaded_file($tmp_file)) {
			$errors[] =  "Error: Does not reference a recently uploaded file.<br />";	
		} 
		
		if(!in_array($file_type, $allowed_mime_types)) {
			$errors[] = "Not an allowed mime type.";

		} 
		
		if(!in_array($file_extension, $allowed_extensions)) {
			$errors[] = "Not an allowed file extension.";
		
		} 
		
		if($check_is_image && (getimagesize($tmp_file) === false)) {
			$errors[] = "Not a valid image file.";
		} 
		
		if($check_for_php && file_contains_php($file)) {
			// A valid image can still contain embedded PHP.
			$errors[] = "File contains PHP code.";
	
		} 
		
		if(file_exists($file_path)) {
			$errors[] = "A file with that name already exists in target location";
			
		} 
		
		if(empty($errors)){
			// Upload the file
			if(move_uploaded_file($tmp_file, $file_path)) {
				$response["name"] = $result["name"];
				$response["path"] = $result["file_url_name"].".".$file_extension;
				$response["type"] = $file_type;
				$response["mode"] = true;
				return $response;
			}else{
				$errors[] = "Error occured While uploading File";
				$errors["mode"] = false; //differentiate the error array from success array
				return $errors;
			}
			// return $success;
		}else{
			$errors["mode"] = false; //differentiate the error array from success array
			return $errors;
		}
	}
	else{
		$errors[] = "File was not uploaded ";
		$errors["mode"] = false; //differentiate the error array from success array
		return $errors;
	}

}



?>

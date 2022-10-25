<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if (isset($_FILES)) {
	$successFile = "";
	$failedFile = "";
	$allowed = array("pdf" => "application/pdf");
	$countfiles = count($_FILES);
	for ($i = 0; $i < $countfiles; $i++) {
		$filename = $_FILES['file_' . $i]['name'];
		$filetype = $_FILES['file_' . $i]["type"];
		$filesize = $_FILES['file_' . $i]["size"];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		if (array_key_exists(strtolower($ext), $allowed)) {
			$maxsize = 5 * 1024 * 1024;
			if ($filesize <= $maxsize) {
				if (in_array($filetype, $allowed)) {
					$newFileName = clean($filename)  . "_" .rand(). date('m-d-Y_hia') . "." . $ext;
					if (file_exists("pdf/" . $newFileName)) {
						$failedFile = $failedFile . "," . $filename;
					} else {

						move_uploaded_file($_FILES['file_' . $i]['tmp_name'], 'pdf/' . $newFileName);
						$successFile = $successFile . "," . $newFileName;
					}
				} else {
					$failedFile = $failedFile . "," . $filename;
				}
			} else {
				$failedFile = $failedFile . "," . $filename;
			}
		} else {
			$failedFile = $failedFile . "," . $filename;
		}
	}
	http_response_code(200);
	echo json_encode(array("status" => "success", "code" => 1, "message" => "File uploaded", "document" => $successFile, "failed" => $failedFile));
} else {
	http_response_code(400);
	echo json_encode(array("status" => "error", "code" => 0, "message" => "File upload failed"));
}

function clean($string)
{
	$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}


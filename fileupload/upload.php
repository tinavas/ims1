<?php
if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_GET['folder'] . '/';
	$targetFile =  str_replace('//','/',$targetPath) . $_FILES['Filedata']['name'];
	
	// mkdir(str_replace('//','/',$targetPath), 0755, true);
	
	move_uploaded_file($tempFile,$targetFile);
}
	
echo '1';

?>
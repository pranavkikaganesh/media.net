<?php
if (!empty($_POST['url']) && filter_var($_POST['url'], FILTER_VALIDATE_URL)) {
	require_once('dbConnection.php');
	require_once('function.php');
	
	$details = crawlUrl($_POST['url']);
	
	if (!empty($details['title'])) {
		$sql = "INSERT INTO search (url, title, keywords, body) VALUES 
				('".addslashes($_POST['url'])."', '".addslashes($details['title'])."', '".addslashes($details['keywords'])."', '".addslashes($details['body'])."')";
		mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));
	
		echo 1;
		die;
	}
}

echo 0;
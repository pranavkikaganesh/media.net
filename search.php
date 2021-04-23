<?php
require_once('function.php');
$searchFor = removeStopWords($_POST['search_for']);

if (!empty($searchFor)) {
	require_once('dbConnection.php');

	$sql = "SELECT url, title
			FROM search
			WHERE MATCH (title, keywords, body) AGAINST ('".mysqli_real_escape_string($dbConnection, $searchFor)."' IN NATURAL LANGUAGE MODE)";
			
	$cursor = mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));
	$result = array();
	while ($row = mysqli_fetch_object($cursor)) {
		$result[] = array('url' => $row->url, 'title' => $row->title);
	}
	
	echo json_encode($result);
}
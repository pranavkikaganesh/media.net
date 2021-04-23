<?php
require_once('dbConnection.php');

$sql = 'SELECT COUNT(id) AS total from search';
$cursor = mysqli_query($dbConnection, $sql) or die(mysqli_error($dbConnection));
$row = mysqli_fetch_object($cursor);
$total = is_object($row)? $row->total : 0;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Search Engine</title>
</head>
<body>
	<div style='margin: 0 auto; width:1024px; min-height:600px; border: 1px solid #999;'>
		<center><h1>Search Engine</h1></center>
		<center id='no_pages_crawled' style='<?= !empty($total)? 'display:none;' : ''; ?>'>No pages crawled</center>
		<center id='search' style='<?= empty($total)? 'display:none;' : ''; ?>'>
			<br>
			<input type='text' id='search_for' style="width:300px" placeholder="Search" /><input type='button' value='Search' id='do_search'>
			<div id='result'></div>
		</center>
		
		<center id='add_page'><hr><a href='#'>Add page</a></center>
		
		<div id='page_form' style='margin: 0 auto; width:600px; display:none;'>
			<p>Configuration</p>
			<p id='urls'><textarea name='urls' cols='60' rows='10' placeholder='Enter list of URLs'></textarea></p>
			<p id='crawling_loader'style='display:none;'>
				<img src='loader.gif'>
				<br>
				<span></span>
			</p>
			<p>
				<input type='button' value='Start Crawling' id='crawling'>
				<input type='button' value='Cancel' id='cancel'>
			</p>
		</div>
	</div>
	<script src='script.js'></script>
</body>
</html>

<?php
	include_once('inc/database.php');
	include_once('inc/dbfunction.php');
	include_once('inc/display.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Music Stuffs</title>
			<meta charset="UTF-8">
			<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
<body>

	
<div id="menu">
	<?php displayMenu($pdo, $menu_table_name, $menu_tables); //Generate Menu ?>
</div>

<div id="search">
	<?php displaySearch($pdo, $menu_table_name, $menu_tables); //Display search function ?>
</div>

<div id="contenthead">
	<?php displayHead($tables); //Generate Table head ?>
</div>

<div id="content">
	<?php
		//Display a line to add a new entry	
		if(!isset($_POST["search"]) || $_POST["search"] == ""){ displayNewEntry($pdo, $table_name, $tables); }	
			
		//If the delete button was used, delete something
		if(isset($_GET["delete"]) && $_GET["delete"] != ""){ deleteEntry($pdo, $table_name, $tables); }
		//If the edit button was used, edit something
		if(isset($_POST["edit"]) && $_POST["edit"] != ""){ editEntry($pdo, $table_name, $tables); }
		//If the new button was used, add something
		if(isset($_POST["new"]) && $_POST["new"] != ""){ addEntry($pdo, $table_name, $tables); }
		
		//If the search was used, it should only show related entries
		if(isset($_POST["search"]) && $_POST["search"] != ""){ $statement = searchEntries($pdo, $table_name, $tables); }
		//No search -> Read everything
		else{ $statement = readAllEntries($pdo, $table_name, $tables); }
		//Read all relevant entries from the database
		displayEntries($pdo, $table_name, $tables, $statement);	
	?>
</div>


<!-- Javascript -->
<!-- Shows a message to confirm, before deleting an entry -->
<script language="javascript" type="text/javascript" src="js/deleteConfirm.js"></script>

</body>
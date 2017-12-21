<?php
	//Establish database connection 
	$db_host = "localhost";
	$db_name = "music";
	$db_user = "root";
	$db_pass = "";
	$table_name = "music";
	$menu_table_name = "menu";
	
	try {
	   $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	} catch (PDOException $e) {
	   print "Error!: " . $e->getMessage() . "<br/>";
	   die();
	}
	
	//Read all column names from database
	$statement = $pdo->prepare("DESCRIBE $table_name");
	$statement->execute();
	$tables = $statement->fetchAll(PDO::FETCH_COLUMN);
	
	$statement = $pdo->prepare("DESCRIBE $menu_table_name");
	$statement->execute();
	$menu_tables = $statement->fetchAll(PDO::FETCH_COLUMN);
?>
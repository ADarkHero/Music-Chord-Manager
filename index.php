<?php
	//Establish database connection 
	$db_host = "localhost";
	$db_name = "music";
	$db_user = "root";
	$db_pass = "";
	$table_name = "music";
	
	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
	
	//Read all column names from database
	$statement = $pdo->prepare("DESCRIBE $table_name");
	$statement->execute();
	$tables = $statement->fetchAll(PDO::FETCH_COLUMN);

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Music Stuffs</title>
			<meta charset="UTF-8">
			<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
<body>







<?php
	displaySearch();

	//Generate Table head
	displayHead($tables);
	
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
	
	
		
		

		
		
		
		
		
		
		function deleteEntry($pdo, $table_name, $tables){
			$sql = "DELETE FROM ".$table_name." WHERE ".$tables[0]." =".$_GET["delete"];
			$statement = $pdo->prepare($sql);
			$statement->execute();
		}
		
		function addEntry($pdo, $table_name, $tables){
			$sql = "INSERT INTO ".$table_name." (";
			for($i = 0; $i < sizeof($tables); $i++){
				$sql = $sql.$tables[$i].", ";
			}
			$sql = substr($sql, 0, -2);	//Cut last , 
			$sql = $sql.") VALUES (";
			for($i = 0; $i < sizeof($tables); $i++){
				$sql = $sql.'"'.$_POST["new".$tables[$i]].'", ';
			}
			$sql = substr($sql, 0, -2);	//Cut last , 
			$sql = $sql.")";
					
			$statement = $pdo->prepare($sql);
			
			$statement->execute();
		}
		
		function editEntry($pdo, $table_name, $tables){
			$sql = "UPDATE ".$table_name." SET ";
			for($i = 0; $i < sizeof($tables); $i++){
				$sql = $sql.$tables[$i].'="'.$_POST["edit".$tables[$i]].'", ';
			}
			$sql = substr($sql, 0, -2);	//Cut last , 
			$sql = $sql." WHERE ".$tables[0].'="'.$_POST["edit".$tables[0]].'"';
			
			$statement = $pdo->prepare($sql);

			$statement->execute();
		}
		
		function searchEntries($pdo, $table_name, $tables){
			$search = '%'.$_POST["search"].'%';	//Search term can be on the beginning, middle or end
			$sql = "SELECT * FROM ".$table_name." WHERE ";
			for($i = 0; $i < sizeof($tables); $i++){
				$sql = $sql.$tables[$i].' LIKE "'.$search.'" OR ';
			}
			$sql = substr($sql, 0, -3); //Cut last "OR"
			$statement = $pdo->prepare($sql);
			
			return $statement;
		}
		
		function readAllEntries($pdo, $table_name, $tables){
			//Base statement
			$sql = "SELECT * FROM ".$table_name." ORDER BY ";
			//Which order? If get sends an order, use it - else: sort by second table
			if(isset($_GET["order"]) && $_GET["order"] != ""){ 
				$sql = $sql.$_GET["order"];
			}
			else{
				$sql = $sql.$tables[1];
			}
			
			//Reverse sorting?
			if(isset($_GET["desc"]) && $_GET["desc"] != ""){ 
				$sql = $sql." DESC";
			}
						
			$statement = $pdo->prepare($sql);
			return $statement;
		}
		
		
		
		
		function displaySearch(){
			echo'<form action="index.php" method="post">';
				echo'<input type="text" class="search" name="search" placeholder="Search..." autofocus>';
			echo'</form>';
		}
		
		function displayHead($tables){
			echo '<table class="table"><tr>';
			for($i = 0; $i < sizeof($tables); $i++){
				echo '<th class="table'.$i.'">'.$tables[$i].' <a href="index.php?order='.$tables[$i].'">▼</a> <a href="index.php?order='.$tables[$i].'&desc=true">▲</a></th>';
			}
			echo '<th class="tableeditnew">Edit</th>';
			echo '<th class="tabledelete">Delete</th>';
			echo "</tr>";
		}
		
		function displayEntries($pdo, $table_name, $tables, $statement){
			$result = $statement->execute();
			for($i = 0; $row = $statement->fetch(); $i++) {
				echo '<form action="index.php" method="post">';
					echo "<tr>";
						for($i = 0; $i < sizeof($tables); $i++){
							echo '<td class="table'.$i.'"><textarea name="edit'.$tables[$i].'">'.$row[$i].'</textarea></td>';
						}
						echo '<td class="tableeditnew"><input type="submit" name="edit" value="EDIT"></button></td>'; 
						echo '<td class="tabledelete"><a href="#" onclick="confirmDeletion('.$row[0].')">DELETE</a></td>'; 
					echo "</tr>";
				echo "</form>";
			}
		}
		
		function displayNewEntry($pdo, $table_name, $tables){
			echo '<form action="index.php" method="post">';
				echo "<tr>";
					for($i = 0; $i < sizeof($tables); $i++){
						echo '<td class="table'.$i.'"><textarea name="new'.$tables[$i].'"></textarea></td>';
					}
					echo '<td class="tableeditnew"><input type="submit" name="new" value="NEW"></button></td>'; 
					echo '<td class="tabledelete"></td>'; 
				echo "</tr>";
			echo "</form>";
		}
?>

	<script>
	function confirmDeletion(id) {
		var r = confirm("Do you really want to delete this entry?");
		
		if(r == true){
			window.location = "index.php?delete="+id;
			header('Location: index.php');
		}
	}

	</script>

</body>
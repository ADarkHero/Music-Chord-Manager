<?php 
	//Deletes an entry from the database
	function deleteEntry($pdo, $table_name, $tables){
		$sql = "DELETE FROM ".$table_name." WHERE ".$tables[0]." =".$_GET["delete"];
		$statement = $pdo->prepare($sql);
		$statement->execute();
	}
	
	//Adds a new entry to the database
	function addEntry($pdo, $table_name, $tables){
		$sql = "INSERT INTO ".$table_name." (";
		for($i = 0; $i < sizeof($tables); $i++){
			$sql = $sql.$tables[$i].", ";
		}
		$sql = substr($sql, 0, -2);	//Cut last , 
		$sql = $sql.") VALUES (";
                error_reporting(0);
		for($i = 0; $i < sizeof($tables); $i++){
                    $sql = $sql.'"'.$_POST["new".$tables[$i]].'", ';
		}
                error_reporting(-1);
                
		$sql = substr($sql, 0, -2);	//Cut last , 
		$sql = $sql.")";
				
		$statement = $pdo->prepare($sql);
		
		$statement->execute();
	}
	
	//Edits an existing entry from the database
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
	
	//Searches specific entries from the database
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
	
	//Reads all entries from the database
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
	
	
	
?>
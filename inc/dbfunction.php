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
                    $sql = $sql.'"'.$_POST[$tables[$i]].'", ';
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
			$sql = $sql.$tables[$i].'="'.$_POST[$tables[$i]].'", ';
		}
		$sql = substr($sql, 0, -2);	//Cut last , 
		$sql = $sql." WHERE ".$tables[0].'="'.$_POST[$tables[0]].'"';
		                            
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
                //If the second tablename contains "date", reverse the order (newest entries first)
		if(isset($_GET["order"]) && $_GET["order"] != ""){ 
			$sql = $sql.$_GET["order"];
		}
                else if (strpos(strtolower($tables[1]), "date")){
			$sql = $sql.$tables[1]." DESC";
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
	
	function getNumberOfEntries($pdo, $table_name, $column){
            $sql = 'SELECT count('.$column.') FROM '.$table_name;
            $statement = $pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchColumn();
        }
        
	function getLatestID($pdo, $table_name, $column){
            $sql = 'SELECT '.$column.' FROM '.$table_name.' ORDER BY '.$column.' DESC LIMIT 0, 1';
            $statement = $pdo->prepare($sql);
            $statement->execute();
            return $statement->fetchColumn();
        }
        
        function getNewIDCell($pdo, $table_name, $column){
            $currentID = getLatestID($pdo, $table_name, $column)+1;
            return $currentID." | ".getNumberOfEntries($pdo, $table_name, $column);
        }
?>
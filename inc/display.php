<?php 
	//Displays the search engine
	function displaySearch(){
		echo'<form action="index.php" method="post">';
			echo'<input type="text" class="search" name="search" placeholder="Search..." autofocus>';
		echo'</form>';
	}
	
	//Displays the head of the database
	function displayHead($tables){
		echo '<table class="table"><tr>';
		for($i = 0; $i < sizeof($tables); $i++){
			echo '<th class="table'.$i.'">'.$tables[$i].' <a href="index.php?order='.$tables[$i].'">?</a> <a href="index.php?order='.$tables[$i].'&desc=true">?</a></th>';
		}
		echo '<th class="tableeditnew">Edit</th>';
		echo '<th class="tabledelete">Delete</th>';
		echo "</tr>";
	}
	
	//Displays the new entry column of the database
	function displayNewEntry($pdo, $table_name, $tables){
		echo '<form action="index.php" method="post">';
			echo "<tr>";
				for($i = 0; $i < sizeof($tables); $i++){
					
					echo '<td class="table'.$i.'"><textarea name="new'.$tables[$i].'"></textarea></td>';
					
				}
				echo '<td class="tableeditnew"><input type="submit" name="new" value="NEW"></button></td>'; 
				echo '<td class="tabledelete"><input type="submit" name="new" value="NEW"></button></td>'; 
			echo "</tr>";
		echo "</form>";
	}
	
	//Displays entries from the database (depending of the search was used or not)
	function displayEntries($pdo, $table_name, $tables, $statement){
		$result = $statement->execute();
		for($i = 0; $row = $statement->fetch(); $i++) {
			echo '<form action="index.php" method="post">';
				echo "<tr>";
					for($i = 0; $i < sizeof($tables); $i++){
						$containslink = strpos($row[$i], "http");	//Checks if the field contains a link -> If yes, it should be made clickable
						echo '<td class="table'.$i.'">';
							if($containslink !== false){ echo '<a href="'.$row[$i].'" target="_blank">'; }
								echo '<textarea name="edit'.$tables[$i].'">'.$row[$i].'</textarea>';
							if($containslink !== false){ echo '</a>'; }
						echo '</td>';
					}
					echo '<td class="tableeditnew"><input type="submit" name="edit" value="EDIT"></button></td>'; 
					echo '<td class="tabledelete"><a href="#" onclick="confirmDeletion('.$row[0].')">DELETE</a></td>'; 
				echo "</tr>";
			echo "</form>";
		}
	}
?>
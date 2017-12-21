<?php 
	//Generates the menu on top of the page
	function displayMenu($pdo, $menu_table_name, $menu_tables){
		$sql = "SELECT * FROM ".$menu_table_name." ORDER BY ".$menu_tables[1];
		$statement = $pdo->prepare($sql);
		$result = $statement->execute();
		
		for($i = 0; $row = $statement->fetch(); $i++) {
			echo '<a href="'.$row[2].'" target="_blank"><button class="menu'.$row[0].'">'.$row[1].'</button></a>';
		}	
	}

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
			echo '<th class="table'.$i.'">'.$tables[$i].' <a href="index.php?order='.$tables[$i].'">▼</a> <a href="index.php?order='.$tables[$i].'&desc=true">▲</a></th>';
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
						$containsspotify = strpos(strtolower($row[$i]), "spotify.com");	//Checks if the field contains a spotifylink -> If yes, display the spotify play thing
						$containsyoutube = strpos(strtolower($row[$i]), "youtube.com");	//Checks if the field contains a youtubelink -> If yes, display the spotify play thing
						if($containsspotify !== false || !$containsyoutube !== false){ $containslink = strpos(strtolower($row[$i]), "http"); /*Checks if the field contains a link -> If yes, it should be made clickable*/ }
						
						echo '<td class="table'.$i.'">';
							if($containslink !== false){ echo '<a href="'.$row[$i].'" target="_blank">'; }
								if($containsspotify !== false && $row[$i] !== "" && $row[$i] !== null){	//If there is a spotify link, display the embedded thing
									echo '<iframe src="https://open.spotify.com/embed?uri=spotify:track:'.$row[$i].'" width="80px" height="80px" frameborder="0" allowtransparency="true"></iframe>';
								}
								else if($containsyoutube !== false && $row[$i] !== "" && $row[$i] !== null){ //If there is a youtube link, display the embedded thing -> else display the normal textarea
									$ytid = substr($row[$i], strrpos($row[$i], '/') + 1); //Get the video id
									if(strpos(strtolower($ytid), "watch?v=") !== false){ $ytid = substr($ytid, 8, strlen($ytid)); } //If it's a normal YouTube link (not an embedded one) cut off the watch?v= thing
									echo '<iframe width="80" height="80" src="https://www.youtube.com/embed/'.$ytid.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
								}
								else{
									echo '<textarea name="edit'.$tables[$i].'">'.$row[$i].'</textarea>';
								}	
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
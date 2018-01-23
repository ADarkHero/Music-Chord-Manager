<?php 
	//Generates the menu on top of the page
	function displayMenu($pdo, $menu_table_name, $menu_tables){
		$sql = "SELECT * FROM ".$menu_table_name." ORDER BY ".$menu_tables[1];
		$statement = $pdo->prepare($sql);
		$result = $statement->execute();
		
		for($i = 0; $row = $statement->fetch(); $i++) {
			echo '<a href="'.$row[2].'" target="_blank"><button class="menu'.$row[0].'">'.$row[1].'</button></a>';
		}
		 
		$edit_menu = "false"; 
		if(isset($_COOKIE["edit_menu"])){
			$edit_menu = $_COOKIE["edit_menu"];
		}
		
		if($edit_menu === "true"){
			echo '<a href="index.php?edit_menu=false"><button class="menu_new">END menu EDIT</button></a>';
		}
		else{
			echo '<a href="index.php?edit_menu=true"><button class="menu_new">EDIT menu</button></a>';
		}			
		
	}

	//Displays the search engine
	function displaySearch(){
		echo'<form action="index.php" method="post">';
			echo'<input type="search" class="search" name="search" placeholder="Search..." autofocus>';
		echo'</form>';
	}
	
	//Displays the head of the database
	function displayHead($tables){
		echo '<table class="table"><tr>';
		for($i = 0; $i < sizeof($tables); $i++){
			echo '<th class="'.$tables[$i].'">'.$tables[$i].' <a href="index.php?order='.$tables[$i].'">▼</a> <a href="index.php?order='.$tables[$i].'&desc=true">▲</a></th>';
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
					echo '<td class="'.$tables[$i].'">';
                                        generateRow(null,$tables[$i]);
                                        echo '</td>';
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
						echo '<td class="'.$tables[$i].'">';
                                                generateRow($row[$i],$tables[$i]);
						echo '</td>';
					}
					echo '<td class="tableeditnew"><input type="submit" name="edit" value="EDIT"></button></td>'; 
					echo '<td class="tabledelete"><a href="#" onclick="confirmDeletion('.$row[0].')">DELETE</a></td>'; 
				echo "</tr>";
			echo "</form>";
		}
	}
        
        
        
        
        
        
        function generateRow($row, $tablename){
            error_reporting(0);                                                 //I'm a bad developer and want to make things easy for myself.
            
            $containsspotify = strpos(strtolower($row), "spotify.com");         //Checks if the field contains a spotifylink -> If yes, display the spotify play thing
            $containsyoutube = strpos(strtolower($row), "youtube.com");         //Checks if the field contains a youtubelink -> If yes, display the spotify play thing
            $containsid = strpos(strtolower($tablename), "id");                 //Checks if the fieldname contains "id" if yes: set the input inactive  
            $containsdate = strpos(strtolower($tablename), "date");            //Checks if the fieldname contains "date" if yes: display the current date and time
            if($containsspotify !== false || !$containsyoutube !== false){ $containslink = strpos(strtolower($row), "http"); /*Checks if the field contains a link -> If yes, it should be made clickable*/ }

            
            if($containslink !== false){ echo '<a href="'.$row.'" target="_blank">'; }
                if ($containsid !== false){
                    echo '<textarea disabled class="idtextarea"';
                    if($row === null){
                        echo ' placeholder="ID is managed by the server."';
                    }
                    echo '>'.$row.'</textarea>';
                    echo '<input type="hidden" name="edit'.$tablename.'" value="'.$row.'"'; //If the textarea is disabled, it doesn't transmit the id. This fixes it.
                }  
                else if ($containsdate !== false){
                    echo '<input type="datetime-local"  name="new'.$tablename.'" value="';
                    if($row === null){
                        echo date('Y-m-d\TH:i');
                    }
                    else {
                        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $row);
                        echo $dateTime->format('Y-m-d\TH:i');
                    }
                    echo '"></input>'; 
                }
                else if($containsspotify !== false){                            //If there is a spotify link, display the embedded thing
                        echo '<iframe src="https://open.spotify.com/embed?uri=spotify:track:'.$row.'" width="80px" height="80px" frameborder="0" allowtransparency="true"></iframe>';
                }
                else if($containsyoutube !== false){                            //If there is a youtube link, display the embedded thing -> else display the normal textarea
                        $ytid = substr($row, strrpos($row, '/') + 1);           //Get the video id
                        if(strpos(strtolower($ytid), "watch?v=") !== false){ $ytid = substr($ytid, 8, strlen($ytid)); } //If it's a normal YouTube link (not an embedded one) cut off the watch?v= thing
                        echo '<iframe width="80" height="80" src="https://www.youtube.com/embed/'.$ytid.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
                }
                else{
                    echo '<textarea name="edit'.$tablename.'">'.$row.'</textarea>';
                }	
            if($containslink !== false){ echo '</a>'; }
            
            error_reporting(-1);
        }
?>
<?php
	//Establish database connection 
	$db_host = "localhost";
	$db_name = "music";
	$db_user = "root";
	$db_pass = "";
	
	global $pdo;
	$pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Music Stuffs</title>
			<meta charset="UTF-8">
			<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
<body>

<form action="index.php" method="post">
	<input type="text" class="search" name="search" placeholder="Search..." autofocus>
</form>

<table class="table" style="width:100%">

<tr>
	<th class="id">ID</th>
	<th class="artist">Artist</th>
	<th class="title">Title</th>
	<th class="text">Text</th>
	<th class="notes">Notes</th>
	<th class="link">Link</th>
	<th class="editnew">Edit</th>
	<th class="delete">Delete</th>
</tr>

<?php
$statement = $pdo->prepare("DELETE FROM user WHERE UserID = :id");
	$statement->bindParam(':id', $_GET["id"], PDO::PARAM_INT);   
	$statement->execute();
		
	//If the delete button was used, delete something
	if(isset($_GET["delete"]) && $_GET["delete"] != ""){ 
		$statement = $pdo->prepare("DELETE FROM music WHERE MusicID = :id");
		$statement->bindParam(':id', $_GET["delete"], PDO::PARAM_INT); 
		$statement->execute();
	}
	//If the edit button was used, edit something
	if(isset($_POST["edit"]) && $_POST["edit"] != ""){ 
		$statement = $pdo->prepare("UPDATE music SET MusicID=:editId, MusicArtist=:editArtist, MusicTitle=:editTitle, MusicText=:editText, MusicNotes=:editNotes, MusicLink=:editLink WHERE MusicID=:editId");

		$statement->bindParam(':editId', $_POST["editId"]);  
		$statement->bindParam(':editArtist', $_POST["editArtist"]);     
		$statement->bindParam(':editTitle', $_POST["editTitle"]);     
		$statement->bindParam(':editText', $_POST["editText"]);     
		$statement->bindParam(':editNotes', $_POST["editNotes"]);     
		$statement->bindParam(':editLink', $_POST["editLink"]);   
		$statement->execute();
	}
	//If the new button was used, add something
	if(isset($_POST["new"]) && $_POST["new"] != ""){ 
		$statement = $pdo->prepare("INSERT INTO music (MusicArtist, MusicTitle, MusicText, MusicNotes, MusicLink) VALUES (?, ?, ?, ?, ?)");
		
		$statement->execute([$_POST["newArtist"], $_POST["newTitle"], $_POST["newText"], $_POST["newNotes"], $_POST["newLink"]]);
	}
	
	//If the search was used, it should only show related entries
	if(isset($_POST["search"]) && $_POST["search"] != ""){ 
		$search = '%'.$_POST["search"].'%';	//Search term can be on the beginning, middle or end
		$statement = $pdo->prepare("SELECT * FROM music WHERE MusicArtist LIKE :search OR MusicTitle LIKE :search OR MusicText LIKE :search OR MusicNotes LIKE :search ORDER BY MusicArtist");
		$statement->bindParam(':search', $search);
	}
	else{ 
	//No search -> Read everything
		$statement = $pdo->prepare("SELECT * FROM music ORDER BY MusicArtist");
	}
	
	//Read all relevant entries from the database
		$result = $statement->execute();
		for($i = 1; $row = $statement->fetch(); $i++) {
			echo '<form action="index.php" method="post">';
				echo "<tr>";
					echo '<td class="id"><textarea name="editId">'.$row['MusicID'].'</textarea></td>';
					echo '<td class="artist"><textarea name="editArtist">'.$row['MusicArtist'].'</textarea></td>';
					echo '<td class="title"><textarea name="editTitle">'.$row['MusicTitle'].'</textarea></td>';
					echo '<td class="text"><textarea name="editText">'.$row['MusicText'].'</textarea></td>';
					echo '<td class="notes" ><textarea name="editNotes">'.$row['MusicNotes'].'</textarea></td>';
					echo '<td class="link"><a href="'.$row['MusicLink'].'" target="_blank"><textarea name="editLink" class="linktext">'.$row['MusicLink'].'</textarea></a></td>';
					echo '<td class="editnew"><input type="submit" name="edit" value="EDIT"></button></td>'; 
					echo '<td class="delete"><a href="#" onclick="confirmDeletion('.$row['MusicID'].')">DELETE</a></td>'; 
				echo "</tr>";
			echo "</form>";
		}
		
		//Display a line to add a new entry
		echo '<form action="index.php" method="post">';
				echo "<tr>";
					echo '<td class="id"><textarea name="newId"></textarea></td>';
					echo '<td class="artist"><textarea name="newArtist"></textarea></td>';
					echo '<td class="title"><textarea name="newTitle"></textarea></td>';
					echo '<td class="text"><textarea name="newText"></textarea></td>';
					echo '<td class="notes"><textarea name="newNotes" value=""></textarea></td>';
					echo '<td class="link"><textarea name="newLink" value=""></textarea></td>';
					echo '<td class="editnew"><input type="submit" name="new" value="NEW"></button></td>'; 
					echo '<td class="delete"></td>'; 
				echo "</tr>";
			echo "</form>";
		
		echo '</table>';

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
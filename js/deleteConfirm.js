function confirmDeletion(id) {
	var r = confirm("Do you really want to delete this entry?");
	
	if(r == true){
		window.location = "index.php?delete="+id;
		header('Location: index.php');
	}
}

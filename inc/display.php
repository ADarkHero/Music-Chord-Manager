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
                                echo '<td class="'.$tables[$i].' '.$table_name.'row">';
                                generateRow($pdo, $table_name, null, $tables[$i]);
                                echo '</td>';
                        }
                        echo '<td class="tablenew '.$table_name.'row"><input type="submit" name="new" value="NEW"></button></td>'; 
                        echo '<td class="tablenew '.$table_name.'row"><input type="submit" name="new" value="NEW"></button></td>'; 
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
                                        echo '<td class="'.$tables[$i].' '.$table_name.'row">';
                                        generateRow($pdo, $table_name, $row[$i], $tables[$i]);
                                        echo '</td>';
                                }
                                echo '<td class="tableedit '.$table_name.'row"><input type="submit" name="edit" value="EDIT"></input></td>'; 
                                echo '<td class="tabledelete '.$table_name.'row"><a href="#" onclick="confirmDeletion('.$row[0].')"><input type="button" value="DELETE"></input></a></td>'; 
                        echo "</tr>";
                echo "</form>";
        }
    }





    //Generates a row to display
    function generateRow($pdo, $table_name, $row, $column){
        error_reporting(0);                                                 //I'm a bad developer and want to make things easy for myself.

        require_once 'displayGenerateRow.php';                              //Generates the various specific settings, if youtube/spotify/checkbox etc. are being used
        
        $containsid = strpos(strtolower($column), "id");                    //Checks if the fieldname contains "id" if yes: set the input inactive  
        $containsdate = strpos(strtolower($column), "date");                //Checks if the fieldname contains "date" if yes: display the current date and time
        $containscheckbox = strpos(strtolower($column), "checkbox");        //Checks if the fieldname contains "id" if yes: set the input inactive  
        $containsspotify = strpos(strtolower($row), "spotify.com");         //Checks if the field contains a spotifylink -> If yes, display the spotify play thing
        $containsyoutube = strpos(strtolower($row), "youtube.com");         //Checks if the field contains a youtubelink -> If yes, display the spotify play thing
        if($containsspotify !== false || !$containsyoutube !== false){ $containslink = strpos(strtolower($row), "http"); /*Checks if the field contains a link -> If yes, it should be made clickable*/ }


        if($containslink !== false){ echo '<a href="'.$row.'" target="_blank">'; }
            if ($containsid !== false){
                containsID($pdo, $table_name, $row, $column);
            }  
            else if ($containsdate !== false){
                containsDate($column, $row);
            }
            else if ($containscheckbox !== false){                          //Should a checkbox be displayed?
                containsCheckbox($column, $row);
            }
            else if($containsspotify !== false){                            //If there is a spotify link, display the embedded thing
                containsSpotify($row);
            }
            else if($containsyoutube !== false){                            //If there is a youtube link, display the embedded thing -> else display the normal textarea
                containsYoutube($row);
            }
            else{
                containsNothing($column, $row);
            }	
        if($containslink !== false){ echo '</a>'; }

        error_reporting(-1);
    }
?>
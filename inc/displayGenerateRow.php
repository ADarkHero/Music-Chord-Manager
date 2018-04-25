<?php

    function containsID($pdo, $table_name, $row, $column){
        echo '<input disabled type="text" class="idtextarea" value="';
        if($row === null){
            echo getNewIDCell($pdo, $table_name, $column);
        }
        else{
            echo $row;
        }
        echo '"></input>';
        echo '<input type="hidden" name="'.$column.'" value="'.$row.'"'; //If the textarea is disabled, it doesn't transmit the id. This fixes it.
    }

    function containsDate($column, $row){
        echo '<input type="datetime-local"  name="'.$column.'" value="';
        if($row === null){
            date_default_timezone_set('Europe/Berlin');
            echo date('Y-m-d\TH:i');
        }
        else {
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $row);
            echo $dateTime->format('Y-m-d\TH:i');
        }
        echo '"></input>'; 
    }

    function containsCheckbox($column, $row){
        echo '<input class="textbox" type="checkbox" name="'.$column.'" value="true"';
        if($row !== "" && $row !== null){
            echo " checked";
        }
        echo '>';
    }

    function containsSpotify($row){
        echo '<iframe class="spotify" src="https://open.spotify.com/embed?uri=spotify:track:'.$row.'" frameborder="0" allowtransparency="true"></iframe>';
    }

    function containsYoutube($row){
        $ytid = substr($row, strrpos($row, '/') + 1);           //Get the video id
        if(strpos(strtolower($ytid), "watch?v=") !== false){ $ytid = substr($ytid, 8, strlen($ytid)); } //If it's a normal YouTube link (not an embedded one) cut off the watch?v= thing
        echo '<iframe class="youtube" src="https://www.youtube.com/embed/'.$ytid.'" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>';
    }

    function containsNothing($column, $row){
        echo '<textarea name="'.$column.'">'.$row.'</textarea>';
    }

?>
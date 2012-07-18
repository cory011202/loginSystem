<?php
class Form {
    //Sets the variables for the class to use
    var $type;
    var $name;
    var $id;
    var $value;
    var $size;

    function addText($label,$name,$id,$value,$size){
        echo "<label>" . $label . "</label><input type=\"text\" name =\"" . $name . "\" id=\"" .
         $id . "\" value=\"" . $value . "\" size=\"" . $size . "\"/><br />";      
    }
    
    function addSelectTeam($label,$team){
        echo "<label>" . $label . "</label>";
        echo "<select name=\"" . $team . "\" >\n";
        echo "\t\t\t\t<option value=\"\">Choose Team</option>\n";
                    //list teams name querery    
                        $cur_teams = mysql_query("SELECT ID,team_name
                                                  FROM teams")
                        or die(mysql_error());
                    $i=0;
                    // loop to display info from db                    
                        while ( $row = mysql_fetch_array($cur_teams)) {                             
                             //build the drop down menus with the appropriate team id
                             echo "\t\t\t\t<option class=\"" . $bgColor . "\" value=\"" . $row['0'] . "\">" . $row['team_name'] . "</option>\n";
                    //end loop    
                    }
                    //end the drop down
                    echo "</select><br />";                 
    }
    
    function displayForm(){
        echo $this->type;
        echo $this->name;
        echo $this->id;
        echo $this->value;
    }
    
    function addSubmitButton($buttonValue) {
        echo "<input type=\"submit\" value=\"" . $buttonValue . "\" />";
        //echo "<br /></form>";

    }
    function addClearButton($buttonValue) {
        echo "<input type=\"reset\" value=\"" . $buttonValue . "\" />";
        //echo "<br /></form>";
    }
}

?>
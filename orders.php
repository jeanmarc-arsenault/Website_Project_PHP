<?php
    define("FOLDER_PHPFUNCTIONS", "common/");
    define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");
    require_once FILE_PHPFUNCTIONS;
    pageTop("Orders");
?>




<?php
        // put your code here
        
//        phpinfo();
        
        
        $products = array ("Federation Constitution class heavy cruiser", "Imperial class star destroyer type I", "Martian Corvette-class light frigate");

        echo "<div >"
        . "<ol>";
                
        for($i=0 ; $i<3 ;$i++ )
        {
            echo "<li>" . $products[$i] . "</li>\n";
        }
        
        
        echo "</ol>";
        
        ## combo box       
        
        echo "<select>";

        
                for($i=0 ; $i<3 ;$i++ )
        {
            echo "<option>" . $products[$i] . "</option>\n";
        }
        
        
        echo "</select>";
        
        //generate bombobox
        
        
        function generateCombobox($array){
            
            echo "<select>";


            for($i=0 ; $i<3 ;$i++ )
            {
                echo "<option>" . $array[$i] . "</option>\n";
            }

            echo "</select>";

        }
      
         $state = array ("Used", "Damaged", "Wreckage");
         
        generateCombobox($state);
        
        
        
        
?>

<?php
                pageBottom();
?>


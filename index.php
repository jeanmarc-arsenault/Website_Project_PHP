<!--#Revision history:
DEVELOPER DATE COMMENTS
Jean-Marc Arsenault (2210969) 2022-11-25 Modified NetBeans project, and added log erro files.
Jean-Marc Arsenault (2210969) 2022-11-29 added few new class files and organizing file dependencies.
Jean-Marc Arsenault (2210969) 2022-12-03 worked on login .
Jean-Marc Arsenault (2210969) 2022-12-10 added missing objects.
Jean-Marc Arsenault (2210969) 2022-12-10 worked on register and update account info.
-->
<?php
define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");
require_once FILE_PHPFUNCTIONS;

define("FOLDER_PICTURES", "media/");
define("FILE_SS1", FOLDER_PICTURES . "spaceship1.jpg");
define("FILE_SS2", FOLDER_PICTURES . "spaceship2.jpg");
define("FILE_SS3", FOLDER_PICTURES . "spaceship3.jpg");
define("FILE_SS4", FOLDER_PICTURES . "spaceship4.jpg");
define("FILE_SS5", FOLDER_PICTURES . "spaceship5.jpg");
global $loggedcustomer;


//echo "new hash is" . password_hash('enterprise', PASSWORD_DEFAULT);

$pictures = array(FILE_SS1, FILE_SS2, FILE_SS3, FILE_SS4, FILE_SS5);
shuffle($pictures);

pageTop("Home Page",'class="spaceback"',"logoshow");
    

?>

<div class="description">
    <p>We are a spaceship salvage company based around the outer rim world of Tatooine. We have recently opened another salvage yard near Ferenginar. We have expert starship repair crews revamping old classic spaceships to top condition for our clients.</p>
<div class="<?php
    if($pictures[0] == FILE_SS3)
        {
            echo 'special';
        }
    else
        {
           echo 'title';
        }
?>">
<?php
    if($pictures[0] == FILE_SS1)
        {
            echo 'Heliades-class space exploration vehicle by Weyland Corp : 15 067 879$';
        }
    elseif ($pictures[0] == FILE_SS2)
        {
           echo 'Lucrehulk class battleship : 23 000 000$'; 
        }
    elseif ($pictures[0] == FILE_SS3)
        {
           echo '**Super Special!!!** MCRN (Martian Congressional Republic Navy) Corvette-class frigate ONLY! : 28 067 879$!!!'; 
        }
    elseif ($pictures[0] == FILE_SS4)
        {
           echo 'Discovery One space exploration vehicle : 54 358 987$'; 
        }
    elseif ($pictures[0] == FILE_SS5)
        {
           echo 'YT-1300 Correlian light freighter  : 4 358 987$';
        }
?>
</div>
            <a href="https://www.amazon.com/Starship-Miniatures/s?k=Starship+Miniatures"><img class="
<?php
    if($pictures[0] == FILE_SS3)
    {
        echo "imageshowspecial";
    }
    else{
        echo "imageshow";
    }
            
?>
            " src="<?php echo $pictures[0]; ?>" alt="nice space trash"/></a>
<div/>
<?php
                pageBottom();


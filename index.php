
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

    $pictures = array(FILE_SS1, FILE_SS2, FILE_SS3, FILE_SS4, FILE_SS5);
    shuffle($pictures);
    if($pictures == FILE_SS3)
    {
        
    }
    
    
    pageTop("Home Page");
    
    

    
    
    
?>
<div>
    <p class="title">We are a small salvage company based around the outer rim world of tatooine. We sell great starships at very low prices!!</p>
            <a href="https://www.amazon.com/Starship-Miniatures/s?k=Starship+Miniatures"><img class="imageshow" src="<?php echo $pictures[0]; ?>" alt="space trash"/></a>
<div/>




<?php
                pageBottom();
?>

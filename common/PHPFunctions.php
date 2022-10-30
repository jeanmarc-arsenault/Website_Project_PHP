<?php

error_reporting(E_ALL);
set_error_handler("manageError");
set_exception_handler("manageException");


header("...UTF-8");
//w3c
header("Expires:tue, 29 novd");
header("Cache-Control:no-cache");
header("Pragma:no-cache");
//constants
define("DEBUGGING", false);

function manageError($errorNumber, $errorString, $errorFile, $errorLineNumber)
{
    if(DEBUGGING)
    {
    echo "errorNumber : $errorNumber \n errorString : $errorString\n errorFile : $errorFile\n errorLineNumber : $errorLineNumber\n";
            #save detailed error into file
    die();
    }
    else{
      echo "an error has occured contact your administrator";
    }

}

function manageException($errorObject)
{
    if(DEBUGGING)
    {
    echo $errorObject-> getLine() . " of the file " . $errorObject-> getFile() . " : "  . $errorObject-> getCode() . ")" ;
            #save detailed error into file
    die();
    }
    else{
      echo "an exception has occured contact your administrator";
    }
}

//trigger_error("custom error" ,E_USER_ERROR);
//throw new Exception("custom esception");

##extra functions
function is_decimal($n) {
    if (is_numeric($n) && floor($n) != $n){
        return true;
    }
    else{
        return false;
    }
    
}




define("FOLDER_CSS", "css/");
define("FILE_CSS", FOLDER_CSS. "style.css");
define("FOLDER_MEDIA", "media/");

define("IMAGE_LOGO", FOLDER_MEDIA . "trashspaceship.jpg");
define("IMAGE_SPACE_BACKGROUND", FOLDER_MEDIA . "space.jpg");
function pageTop($Title, $body, $logo){?>
<!DOCTYPE html>
    <html>
        <head>
                <link rel="stylesheet" href= 
<?php echo FILE_CSS;?>                                              />
                <meta charset="UTF-8">
<title><?= $Title ?></title>
        </head>
            <body <?php echo $body  ?> >
                <header>
                    <img class="<?php echo $logo;?>" src="<?php echo IMAGE_LOGO; ?>" alt="Usedspaceship Emporium logo of a racoon in trash spaceship"/>
                    <nav class="menu-options">
                        <ul>
                            <li><a href="index.php">Homepage</a></li>
                            <li><a href="buying.php">Buying</a></li>
                            <li><a href="orders.php">Orders</a></li>
                        </ul>
                    </nav>
                 </header>
                <div>
                    <p class="title">Welcome to the Tatooine Used Spaceships Emporium</p>
                </div>
<?php
}

function pageBottom()
{
?>
                </div>
                <footer>Copyright Jean-Marc Arsenault (202210969) 
<?=
                    date("Y");
?>. </footer>
            </body>
    </html>
<?php
}

?>
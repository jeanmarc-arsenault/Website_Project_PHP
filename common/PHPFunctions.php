<!--#Revision history:
DEVELOPER DATE COMMENTS
Jean-Marc Arsenault (2210969) 2022-11-25 Modified NetBeans project, and added log erro files..
Jean-Marc Arsenault (2210969) 2022-12-03 worked on login .
-->



<?php
define("FOLDER_ORDERS", "data/");
const OBJECTS_FOLDER = "objects/";
const OBJECT_CONNECTION = OBJECTS_FOLDER . "DBconnection.php";
error_reporting(E_ALL);
set_error_handler("manageError");
set_exception_handler("manageException");


header('Content-type: text/html; charset=utf-8');
//w3c
header("Expires: Sat, 26 Jul 2024 05:00:00 GMT");
header("Cache-Control:no-cache");
header("Pragma:no-cache");
//constants
define("DEBUGGING", true);

function manageError($errorNumber, $errorString, $errorFile, $errorLineNumber)
{
    if(DEBUGGING)
    {
    echo "errorNumber : $errorNumber \n errorString : $errorString\n errorFile : $errorFile\n errorLineNumber : $errorLineNumber\n";
    
        

    }
    else{
      echo "an error has occured contact your administrator";
    }

            //creating errorlog file
        
$myFile = fopen(FOLDER_PHPFUNCTIONS ."ErrorLogs.txt", "a") or die("Unable to create the file\n");

fwrite($myFile, date("Y-m-d h:i:sa"). " --  errorNumber : $errorNumber \n errorString : $errorString\n errorFile : $errorFile\n errorLineNumber : $errorLineNumber\n");


fclose($myFile); 
die();
}

function manageException($errorObject)
{
    if(DEBUGGING)
    {
        echo $errorObject-> getLine() . " of the file " . $errorObject-> getFile() . " : "  . $errorObject-> getCode() . ")\n\n" ;

        
    }
    else{
      echo "an exception has occured contact your administrator";
    }
    
        //creating exceptionlog file

        $myFile = fopen(FOLDER_PHPFUNCTIONS . "ErrorLogs.txt", "a") or die("Unable to create the file\n");

        fwrite($myFile, date("Y-m-d h:i:sa") . " --  Exeption: " . $errorObject-> getLine() . " of the file " . $errorObject-> getFile() . " : "  . $errorObject-> getCode() . ")\n\n");
        
        fclose($myFile); 
    
    die();
    
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

function securepage()
{
        if(  ! isset($_SERVER["HTTPS"]) || $_SERVER["HTTPS"] != "on"){
        
        HEADER("Location: https://" . str_replace("8000","4433", $_SERVER ["HTTP_HOST"]) . $_SERVER["REQUEST_URI"]);
        exit();
        }
}

#global variable
$loggedUser = "";
session_cache_expire(time() + 60*10);
session_start();#use session variable


function login($username, $password)
    { 
        global $connection;
        $dbpassword = password_hash($password, PASSWORD_DEFAULT);
        $SQLquery = "CALL `customer_login`($dbpassword, $username);";
        
        $rows = $connection->prepare($SQLquery);
        
        if($rows->execute()){
            
            if($rows != ""){
                return true;
            }
            else{
                  return false;
            }
        }

    }

function readCookie()
{ global $loggedUser;

        if(isset($_SESSION["loggedUser"]))
        {
            $loggedUser = $_COOKIE["loggedUser"];
        }
}

function createCookie($page)
{ //time() + 60 * 60 *24 .... a year               path, domain, secure,http, only
    setcookie("loggedUser", $_POST["user"], time() + 60*10,"" , "", false, true);
    header('location: ' . $page);
    $_SESSION["loggedUser"] = $_POST["user"];
    exit();
}

function deleteCookie($page)
{ 
    setcookie("loggedUser", "", time() - 60 * 10 ,"" , "", false, true);
    header('location: ' . $page);
    session_destroy();
    exit();
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
<?php
    if($Title == "Buying" || $Title == "Orders"){
       echo '<li><a href="account.php">Account</a></li>';
    }
?>
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
                <footer>Copyright Jean-Marc Arsenault (2210969) 
<?=
                    date("Y");
?>. </footer>
            </body>
    </html>
<?php
}

?>
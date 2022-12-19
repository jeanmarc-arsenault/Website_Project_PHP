<!--#Revision history:
DEVELOPER DATE COMMENTS
Jean-Marc Arsenault (2210969) 2022-11-25 Modified NetBeans project, and added log erro files..
Jean-Marc Arsenault (2210969) 2022-12-03 worked on login .
-->



<?php
define("FOLDER_ORDERS", "data/");
define("HOME_PAGE", "index.php");
define("ORDERS_PAGE", "orders_page.php");
define("BUYING_PAGE", "buying.php");

const OBJECTS_FOLDER = "objects/";
const OBJECT_COLLECTION = OBJECTS_FOLDER . "collection.php";
const OBJECT_CUSTOMER = OBJECTS_FOLDER . "customer.php";
const OBJECT_CONNECTION = OBJECTS_FOLDER . "DBconnection.php";
const OBJECT_ORDER = OBJECTS_FOLDER . "order.php";
const OBJECT_ORDERS = OBJECTS_FOLDER . "orders.php";
const OBJECT_CUSTOMERS = OBJECTS_FOLDER . "customers.php";
const OBJECT_PRODUCT = OBJECTS_FOLDER . "product.php";
const OBJECT_PRODUCTS = OBJECTS_FOLDER . "products.php";
const TAX = 0.137;
require_once OBJECT_CONNECTION;
require_once OBJECT_CUSTOMER;
require_once OBJECT_COLLECTION;
require_once OBJECT_CUSTOMERS;
require_once OBJECT_ORDER;
require_once OBJECT_ORDERS;
require_once OBJECT_PRODUCT;
require_once OBJECT_PRODUCTS;

error_reporting(E_ALL);
set_error_handler("manageError");
set_exception_handler("manageException");



header('Content-type: text/html; charset=utf-8');
//w3c
header("Expires: Sat, 26 Jul 2024 05:00:00 GMT");
header("Cache-Control:no-cache");
header("Pragma:no-cache");
//constants
define("DEBUGGING", false);

$globalCID = "";

function manageError($errorNumber, $errorString, $errorFile, $errorLineNumber)
{
    if(DEBUGGING)
    {
    echo "errorNumber : $errorNumber \n errorString : $errorString\n errorFile : $errorFile\n errorLineNumber : $errorLineNumber\n";

    }
    else{
      echo "An error has occured contact your administrator";
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
        echo "Exeption: At Line :" . $errorObject-> getLine() . " of the file " . $errorObject-> getFile() . " : "  . $errorObject-> getCode() . $errorObject-> getMessage() . ")\n\n" ;

    }
    else{
      echo "An exception has occured contact your administrator";
    }
    
        //creating exceptionlog file

        $myFile = fopen(FOLDER_PHPFUNCTIONS . "ErrorLogs.txt", "a") or die("Unable to create the file\r\n");

        fwrite($myFile, date("Y-m-d h:i:sa") . " --  Exeption: " . $errorObject-> getLine() . " of the file " . $errorObject-> getFile() . " : "  . $errorObject-> getCode() .  $errorObject-> getMessage() .")\r\n\r\n");
        
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
///////////////////////////////
#global variable
$loggedUser = null;
$loggedcustomer = null;
session_cache_expire(time() + 60*10);
session_start();#use session variable
$cid= "";
$password= "";


function login($username, $pass,)
{ 
    global $connection;
    $SQLquery = "CALL customer_login(:username)";
    $rows=$connection->prepare($SQLquery);
    $rows->bindParam(":username",$username, PDO::PARAM_STR);
    if($rows->execute())
    {
        while ($row = $rows->fetch())
        {   
            if(password_verify($pass, $row["pass"]))
            {
                //create cookie 
                $_SESSION["loggedUser"] = $row["cid"];
                $page = $_SERVER['SCRIPT_NAME'];
                header('location: ' . $page);
                return true;
            }
            else{
                   return false;
            }
        }
    }
}

function readCookie()
{ 
    global $loggedUser;
    global $loggedcustomer;
    if(isset($_SESSION["loggedUser"]))
    {
         
        $loggedUser = $_SESSION["loggedUser"];
        $loggedcustomer = new Customer();
        $loggedcustomer->load($_SESSION["loggedUser"]);
    }
}

function deleteCookie()
{ 
    global $loggedUser;
    global $loggedcustomer;
    $_SESSION["loggedUser"] = null;
    $loggedcustomer = null;
    $page = $_SERVER['SCRIPT_NAME'];
    header('location: ' . $page);
    session_destroy();
    exit();
}




///////////////////////////////

define("FOLDER_CSS", "css/");
define("FILE_CSS", FOLDER_CSS . "style.css");
define("FOLDER_MEDIA", "media/");
define("IMAGE_LOGO", FOLDER_MEDIA . "trashspaceship.jpg");
define("IMAGE_SPACE_BACKGROUND", FOLDER_MEDIA . "space.jpg");

function pageTop($Title, $body, $logo){
    
    
//secure https and cookie
securepage();
?>
<!DOCTYPE html>
    <html>
        <head>
                <link rel="stylesheet" href= <?php echo FILE_CSS; ?>>
                <meta charset="UTF-8">
                <script language="javascript" type="text/javascript" src="js/ajax.js"></script>
<title><?= $Title ?></title>
        </head>
            <body <?php echo $body  ?> >
                <header>
                    <img class="<?php echo $logo;?>" src="<?php echo IMAGE_LOGO; ?>" alt="Usedspaceship Emporium logo of a racoon in trash spaceship"/>
                    <nav class="menu-options">
                        <ul>
                            <li><a href="index.php">Homepage</a></li>
                            <li><a href="buying.php">Buying</a></li>
                            <li><a href="orders_page.php">Orders</a></li>
<?php
if(isset($_POST["user"])) {
        $username=$_POST["user"];
        $pass=$_POST["password"];  
        if(login($username, $pass)){
            
            exit();
        }
        else{
            echo "Invalid login";
            $loggedUser = null;
            $loggedcustomer = null;
        }         
}
else {
        if(isset($_POST["logout"])){
            deleteCookie();
        }
        else
        {
            readCookie();
        }
}



global $loggedcustomer;
    if($loggedcustomer == null){
       echo '<li><a href="account.php">Register</a></li>';
    }
    else{
        echo '<li><a href="account.php">Account</a></li>';
    }
?>
                        </ul>
                    </nav>
                 </header>
<?php
global $loggedUser;
    if($loggedUser != ""){

        echo "Welcome " . $loggedcustomer->getFirstName() . " " . $loggedcustomer->getLastName();
        echo '<img class="customerportraitshow" src=" data:image;base64,' . base64_encode($loggedcustomer->getPicture()).'"/>';
        $page = $_SERVER['PHP_SELF'];
    ?>
                
            <form action="<?php echo $page; ?>" method="POST">
    <?php   

    ?>
                <input type="submit" name="logout" value="Logout">
           </form>



    <?php
    }
    if($loggedcustomer == null){
?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            Username:
            <input type="text" name="user">
            Password:
            <input type="password" name="password">
            <input type="submit" name="login" value="Login">
        </form>
<?php
    }
?>
                <div>
                    <p class="title">Tatooine Used Spaceships Emporium</p>
                </div>
<?php
}

function pageBottom(){
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


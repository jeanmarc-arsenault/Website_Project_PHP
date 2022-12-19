

<?php
#declare variables

#search 2022/12/1

$prdcode = "";
$fname = "";
$lname = "";
$city = "";
$com = "";
$price = "";
$qty = "";
$subtotal= "";
$taxes= "";
$grandtotal= "";
$ordernum=0;
$print='class="spaceback"';
$printlogo="logoshow";
$color="";
global $loggedcustomer;
//secure https and cookie

       if(isset($_GET["action"]) && strtoupper($_GET["action"]) == strtoupper("print"))
        {
            $print ='class="print"';
            $printlogo ="logoshowprint";
        }


define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");
require_once FILE_PHPFUNCTIONS;

$orders = new orders();
$order = new order();
$product = new product();

pageTop("Orders_page",$print, $printlogo);

global $loggedcustomer;
?>
<a href="data/cheatsheet.txt">Cheat sheet Link</a>

<?php
 
?>

        <input type="text" id="searchedTime">
        <button onclick="searchOrders()"; ">Search by Date</button>
<div id="SearchResults">
  no result.
</div>
<?php        


                pageBottom();



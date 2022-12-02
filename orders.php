<?php
#declare variables
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

       if(isset($_GET["action"]) && strtoupper($_GET["action"]) == strtoupper("print"))
        {
            $print ='class="print"';
            $printlogo ="logoshowprint";
        }


define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");
require_once FILE_PHPFUNCTIONS;
//object and DB

const OBJECT_CUSTOMERS = OBJECTS_FOLDER . "customers.php";


require_once OBJECT_CUSTOMERS;

if(isset($_POST["user"]))
{
    createCookie();
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



    pageTop("Orders",$print, $printlogo);
?>
<a href="data/cheatsheet.txt">Cheat sheet Link</a>
<?php





    $orderFile = fopen(FILE_ORDERS, "r") or die("Unable to open the file\n");
    
    while( !feof($orderFile))
    {
        $fileLine = fgets($orderFile);
        $currentorder = json_decode($fileLine);
        if(!$currentorder==null){
            $prdcode = $currentorder[0]; 
            $fname = $currentorder[1];
            $lname= $currentorder[2];
            $city= $currentorder[3];
            $com= $currentorder[4];
            $price = $currentorder[5];
            $qty= $currentorder[6];
            $subtotal= $currentorder[7];
            $taxes= $currentorder[8];
            $grandtotal= $currentorder[9];
            //increasing order number for next order
            $ordernum++;

            if(isset($_GET["action"]) && strtoupper($_GET["action"]) == strtoupper("color"))
            {
                if ($subtotal<1000000){
                    $color = "color:red";
                }
                elseif ($subtotal>=1000000 && $subtotal<10000000 ){
                    $color = "color:#ffbf00 ";//choose this kind of ornage fitted most closelly to light ornage form the pdf
                }
                elseif ($subtotal>10000000 ){
                    $color = "color:green";
                }
            }
?>
                    <table>
        <caption>Order number : <?php echo $ordernum ?></caption>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>City</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Taxes amount</th>
                <th>Grand total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <!-- data row -->
                <td><?php echo $prdcode ?></td>
                <td><?php echo $fname ?></td>
                <td><?php echo $lname ?></td>
                <td><?php echo $city ?></td>
                <td><?php echo $price."$" ?></td>
                <td><?php echo $qty ?></td>
                <td style="<?php echo $color ?>"><?php echo $subtotal."$" ?></td>
                <td><?php echo $taxes."$" ?></td>
                <td><?php echo $grandtotal."$" ?></td>
            </tr>

            <tr>
                <!-- data row -->
                
                <td colspan="1">Comments</td>
                <td colspan="8"><?php echo $com ?></td>
            </tr>
        </tbody>
    </table>
    <br />
<?php        
            }
        }
        fclose($orderFile);

?>

 
<?php
        // put your code here
        
      
?>

<?php
                pageBottom();
?>


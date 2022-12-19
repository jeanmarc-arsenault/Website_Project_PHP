<!--#Revision history:

DEVELOPER DATE COMMENTS

Jean-Marc Arsenault (2210969) 2022-11-25 Modified NetBeans project.
Jean-Marc Arsenault (2210969) 2022-12-01 started implementing login on buying and orders plus added blank account page.
Jean-Marc Arsenault (2210969) 2022-12-03 worked on login .


-->
<?php

define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");

require_once FILE_PHPFUNCTIONS;


#declare variables


$prdinfo = "";
$com = "";
$price = "";
$qty = "";
$subtotal= "";
$taxes= "";
$grandtotal= "";
$validationErrorCom = "";
$validationErrorQty = "";
$errorOccured = false;
$orderConfirmation = "";
$baughtproduct = new product();

//////////////////////////////////////////


$products = new products();
$product = new product();



pageTop("Buying",'class="spaceback"',"logoshow");

global $loggedcustomer;




#validation
if(isset($_POST["buy"]))  #strlen > 20
{
    global $loggedcustomer;
    global $baughtproduct;
    $baughtproduct->load($_POST["products"]);
    
    $fname = $loggedcustomer->getFirstName();
    $lname = $loggedcustomer->getLastName();
    $city = $loggedcustomer->getCity();
    $com = htmlspecialchars($_POST["com"]);
    $qty = htmlspecialchars($_POST["qty"]);
    $price = $baughtproduct->getPrice();

    if(strlen($com) >= 200){
        $validationErrorCom = "Maximum comment lenght is 200 characters!";
        $errorOccured = true;
    }

    if ($qty == "" || is_decimal($qty)){
        $validationErrorQty = "The quantity cannot be Null or a decimal! You need a quantity in integer value!";
        $errorOccured = true;
    }

    #if no erro occured
    if($errorOccured == false){
        
        $subtotal   = round($qty*$price, 2);
        $taxes      = round(TAX*$subtotal, 2);
        $grandtotal =   round($subtotal+ $taxes, 2);

        
        #save data in database
        
        

        $thisOrder = new order( $_POST["products"], $loggedcustomer->getCustomerId() , $qty, $com, $price);
        $thisOrder->save();
        
        $orderConfirmation = "Your order has be recorded!"."---> Subtotal: ".$subtotal."Credits---> taxes amount : ".$taxes. "Credits---> Grand total: ".$grandtotal."Credits \n";
        

        #clear the fields
        $com = "";
        $qty = "";
        
        echo "<script> location.href='". ORDERS_PAGE ."'; </script>";
        exit;

        

    }
}



if(isset($_SESSION["loggedUser"]))
    {
        $fname = $loggedcustomer->getFirstName();
        $lname = $loggedcustomer->getLastName();
        $city = $loggedcustomer->getCity();

?>
<!--
login
-->

<div class="description">
    <h2>Emporium Used Spaceship Acquisition Form:</h2>
    <span style="color:green">
<?php

var_dump($connection);

                    echo $orderConfirmation;
?>
    </span>
        <form action="buying.php" method="post">
            <p>
                    <label for="products">Product:</label>
                    <select name="products">
<?php
    foreach( $products->items as $product ) {
        echo '<option name="" value="' . $product->getProductId() . '">' . $product->getPrdCode(). " : " .  $product->getPrice(). " Credits " . '</option>"';
        echo '<option disabled style="font-style:italic">&nbsp;&nbsp;&nbsp;'. $product->getINFO() .'</option>';
    }
?>
                    </select>
            </p>
            <p>
                <label>First Name:</label>
                <label><?php echo $fname; ?></label>
            </p>
            <p>
                <label>Last Name:</label>
                <label><?php echo $lname; ?></label>
            </p>
            <p>
                <label>City:</label>
                <label><?php echo $city; ?></label>
            </p>
            <p>
                <label>Comments:</label>
                    <textarea rows="2" cols="30" name="com" value="
                        
<?php
echo $com;
?>
" maxlength="200"></textarea>
            </p>
            <p>
                <label>Quantity:</label>
                <input type="text" name="qty"  value="
<?php
echo $qty;
?>
">
                <span style="color:red">
<?php
                    echo $validationErrorQty;
?>
                </span>
            </p>
            <p>
                <input type="submit" value="Save my data"  name="buy">
            </p>
            
        </form>

    </div>

<?php
    }
    else{
?>
    <div class="description">
    <h2>Please Login to Access the Buy feature</h2>
    </div>
<?php
    }
pageBottom();

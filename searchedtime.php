<?php


define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");
require_once FILE_PHPFUNCTIONS;

readCookie();
global $loggedcustomer;
global $connection;
$prdcode = "";
$fname = "";
$lname= "";
$city= "";
$com= "";
$price = "";
$qty= "";
$product= new product();
$products= new products();
$orders = new orders();
$order = new order();



                
if(isset($_POST["order_id"]))
{

     global $connection;
        
    $SQLquery = "CALL delete_order(:OID)";

    $rows = $connection->prepare($SQLquery);

    $rows->bindParam(":OID",$_POST["order_id"], PDO::PARAM_STR);                         //opional param

        if($rows->execute())
       {

       }
}



if(isset($_POST["searchedTime"])){

            echo '    <table>';
     
    foreach( $orders->items as $order ){
        if($order->getCID() == $loggedcustomer->getCustomerId() && $order->getDate() >= $_POST["searchedTime"] ){

                $product->load($order->getPID());
                $subtotal = round($order->getQty()*$order->getSoldPrice(), 2);
                $taxes = round(TAX*$subtotal, 2);
                $grandtotal= round($subtotal+ $taxes, 2);
                
    ?>   
        
            <thead>
                <caption>Order date : <?php echo $order->getDate() ?></caption>
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
                    <td><?php echo $product->getPrdCode() ; ?></td>
                    <td><?php echo $loggedcustomer->getFirstName(); ?></td>
                    <td><?php echo $loggedcustomer->getLastName(); ?></td>
                    <td><?php echo $loggedcustomer->getCity(); ?></td>
                    <td><?php echo $order->getSoldPrice() ."Credits"; ?></td>
                    <td><?php echo $order->getQty(); ?></td>
                    <td><?php echo $subtotal ."Credits"; ?></td>
                    <td><?php echo $taxes."Credits"; ?></td>
                    <td><?php echo $grandtotal."Credits"; ?></td>
                </tr>
                <tr>
                    <!-- data row -->
                    <td colspan="1">Comments</td>
                    <td colspan="7"><?php echo $order->getCOM(); ?></td>
                    <td colspan="1">
                    <form method="POST">
                    <input  type="hidden" name="order_id" value="<?php echo $order->getOrderId() ?>">
                    <input  type="submit" name="delete_order" value="Cancel this Order">
                    </form>
                    </td>
                </tr>
            </tbody>
            <?php 

            ?>

    <?php         
        }
            }
                echo "</table><br>";
        }


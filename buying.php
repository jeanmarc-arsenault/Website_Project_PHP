<!--#Revision history:

DEVELOPER DATE COMMENTS

Jean-Marc Arsenault (2210969) 2022-11-25 Modified NetBeans project.
Jean-Marc Arsenault (2210969) 2022-12-01 started implementing login on buying and orders plus added blank account page.
Jean-Marc Arsenault (2210969) 2022-12-03 worked on login .


-->
<?php
//secure https and cookie


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
$validationErrorPrdcode = "";
$validationErrorFname = "";
$validationErrorLname = "";
$validationErrorCity = "";
$validationErrorCom = "";
$validationErrorPrice = "";
$validationErrorQty = "";
$errorOccured = false;
$orderConfirmation = "";

//////////////////////////////////////////
define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");

require_once FILE_PHPFUNCTIONS;
//object and DB


///////////////////

    pageTop("Buying",'class="spaceback"',"logoshow");

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

#validation
if(isset($_POST["buy"]))  #strlen > 20
{
    $prdcode = htmlspecialchars($_POST["prdcode"]);
    $fname = htmlspecialchars($_POST["fname"]);
    $lname = htmlspecialchars($_POST["lname"]);
    $city = htmlspecialchars($_POST["city"]);
    $com = htmlspecialchars($_POST["com"]);
    $price = htmlspecialchars($_POST["price"]);
    $qty = htmlspecialchars($_POST["qty"]);
    
    if($prdcode == ""){
        $validationErrorPrdcode = "The product code cannot be Null!";
        $errorOccured = true;
    }
    elseif(!str_contains(mb_strtoupper($prdcode), "PRD")){
        $validationErrorPrdcode = "This is not a valid product number! Consult our catalogs for a proper code";
        $errorOccured = true;
    }
    elseif(strlen($prdcode) >= 25){
        $validationErrorPrdcode = "Maximum product code lenght is 25 characters!";
        $errorOccured = true;
    }
    if($fname == ""){
        $validationErrorFname = "The first name cannot be Null!";
        $errorOccured = true;
    }
    elseif(strlen($fname) >= 20){
        $validationErrorFname = "Maximum First Name lenght is 20 characters!";
        $errorOccured = true;
    }
    elseif ($lname == ""){
        $validationErrorLname = "The last name cannot be Null!";
        $errorOccured = true;
    }
    elseif(strlen($lname) >= 20){
        $validationErrorFname = "Maximum Last Name lenght is 20 characters!";
        $errorOccured = true;
    }
    if ($city == ""){
        $validationErrorCity = "The City cannot be Null!";
        $errorOccured = true;
    }
    elseif(strlen($city) >= 30){
        $validationErrorFname = "Maximum City lenght is 30 characters!";
        $errorOccured = true;
    }
    if(strlen($com) >= 200){
        $validationErrorCom = "Maximum comment lenght is 200 characters!";
        $errorOccured = true;
    }
    if ($price == ""){
        $validationErrorPrice = "The price cannot be Null!";
        $errorOccured = true;
    }
    elseif(str_contains($price, "$")){
        $validationErrorPrice = "only insert the number no dollar signs!";
        $errorOccured = true;
    }
    elseif ($price > 100000000.00 || $price <= 0){//since I went with a sci fi setting Im changing the max to 100 million from 10,000.00
        $validationErrorPrice = "The price has to be more than 0 and no more than 100,000,000.01!";
        $errorOccured = true;
    }
    if ($qty == "" || is_decimal($qty)){
        $validationErrorQty = "The quantity cannot be Null or a decimal! You need a quantity in integer value!";
        $errorOccured = true;
    }

    #if no erro occured
    if($errorOccured == false){
        
        $subtotal   = round($qty*$price, 2);
        $taxes      = round(0.161*$subtotal, 2);
        $grandtotal =   round($subtotal+ $taxes, 2);
        $orderConfirmation = "Your order has be recorded!"."---> Subtotal: ".$subtotal."$---> taxes amount : ".$taxes. "$---> Grand total: ".$grandtotal."$";
        
        #save data in database
        
//        $order = array($prdcode, $fname, $lname, $city, $com, $price, $qty, $subtotal,$taxes,$grandtotal);
//        file_put_contents(FILE_ORDERS, json_encode($order)."\r\n", FILE_APPEND);

        #clear the fields
        $prdcode = "";
        $fname = "";
        $lname = "";
        $city = "";
        $com = "";
        $price = "";
        $qty = "";
    }
}

?>
<!--
login
-->
<?php
if($loggedUser != ""){

    echo "Welcome " . $loggedcustomer->getFirstName() . " " . $loggedcustomer->getLastName();

?>
        <form action="buying.php" method="POST">
<?php   
        
?>
            <input type="submit" name="logout" value="Logout">
        </form>

<div class="description">
    <h1>Emporium Used Spaceship Acquisition Form:</h1>
        <form action="buying.php" method="post">
            <p>
                    <label>Product Number:</label>
                    <input type="text" name="prdcode" value="<?php echo $prdcode;?>"> 
                    <span style="color:red">
<?php
                    echo $validationErrorPrdcode;
?>
                                         </span>
            </p>
            <p>
                <label>First Name:</label>
                <input type="text" name="fname"  value="
<?php
echo $fname;
?>
">
                <span style="color:red">
<?php
                    echo $validationErrorFname;           
?>
                                         </span>
                
            </p>
            <p>
                <label>Last Name:</label>
                <input type="text" name="lname"  value="
<?php
echo $lname;
?>
">
                <span style="color:red">
<?php
                    echo $validationErrorLname;           
?>
                                         </span>
                
            </p>
            <p>
                <label>City:</label>
                <input type="text" name="city"  value="
<?php
echo $city;
?>
">
                <span style="color:red">
<?php
                    echo $validationErrorCity;           
?>
                                         </span>
                
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
                <label>Price:</label>
                <input type="text" name="price"  value="
<?php
echo $price;
?>
">
                <span style="color:red">
<?php
                    echo $validationErrorPrice;           
?>
                                         </span>
                
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
        
<span style="color:green">
<?php
                    echo $orderConfirmation;
?>
                                         </span>
    </div>



<?php
}
    else{
?>

        <form action="buying.php" method="POST">
            Username:
            <input type="text" name="user">
            Password:
            <input type="text" name="password">
            <input type="submit" name="login" value="Login">
        </form>
<?php
    }

                pageBottom();

<?php
define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");
require_once FILE_PHPFUNCTIONS;

$accounttype="";
global $loggedcustomer;
//secure https and cookie
securepage();

readCookie();

if(isset($_POST["main"]))
    {
        header('location: index.php');
    }


if($loggedcustomer == null){
    $accounttype="Registration Information";
    if(isset($_POST["register"]))
    {
        
        //insert new customer
        global $connection;
        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $address = htmlspecialchars($_POST["address"]);
        $city = htmlspecialchars($_POST["city"]);
        $postalcode = htmlspecialchars($_POST["postalcode"]);
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["pass"]);

        $picture = null;
        
        if($_FILES["picture"]["error"] == UPLOAD_ERR_OK && is_uploaded_file($_FILES["picture"]["tmp_name"]))
        {
            $picture = file_get_contents($_FILES["picture"]["tmp_name"]);
        }
        else{
            //debug to remove
            echo "file not on disk";
        }
        
        $thisCustomer = new customer($firstname, $lastname, $address, $city, $postalcode, $username, $password, $picture);
        $thisCustomer->save();
        
        
        if($picture != null)
        {
            echo '<img class="customerportraitshow" src=" data:image;base64,' . base64_encode($picture).'"/>';
        }
        else
        {
            echo "picture not loaded!";

        }

        echo "<script> location.href='". HOME_PAGE ."'; </script>";

        exit;
        
    }
}
else{
    //update customer
    global $loggedcustomer;
    $accounttype="Account Information";

    //$thisCustomer = $loggedcustomer->load($loggedcustomer->getCustomerId());
    $picture = $loggedcustomer->getPicture();
        if($picture != null)//show customer picture
        {
            echo '<img class="customerportraitshow" src=" data:image;base64,' . base64_encode($picture).'"/>';
        }
        else
        {
            echo "picture not loaded!";
        }
    
    
    if(isset($_POST["update"]))
    {
        
        global $connection;
        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $address = htmlspecialchars($_POST["address"]);
        $city = htmlspecialchars($_POST["city"]);
        $postalcode = htmlspecialchars($_POST["postalcode"]);
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["pass"]);
        $picture = $loggedcustomer->getPicture();

        //load picture
        if($_FILES["picture"]["error"] == UPLOAD_ERR_OK && is_uploaded_file($_FILES["picture"]["tmp_name"]))
        {
            $picture = file_get_contents($_FILES["picture"]["tmp_name"]);
        }
        else{
            echo $_FILES["picture"]["error"];
        }
        
        if($picture != null)//show customer picture
        {
            echo '<img class="customerportraitshow" src=" data:image;base64,' . base64_encode($picture).'"/>';
        }
        else
        {
            echo "picture not loaded!";
        }
        
        $loggedcustomer->setFirstName($firstname);
        $loggedcustomer->setLastName($lastname);
        $loggedcustomer->setAddress($address);
        $loggedcustomer->setCity($city);
        $loggedcustomer->setPostalcode($postalcode);
        $loggedcustomer->setUsername($username);
        $loggedcustomer->setPassword($password);
        $loggedcustomer->setPicture($picture);
        $loggedcustomer->save();
    }
    
}

?>
<!DOCTYPE html>
    <html>
        <head>
                <link rel="stylesheet" href= <?php echo FILE_CSS; ?>>
                <meta charset="UTF-8">
        </head>
            <body class="spaceback" >
<div class="description">
    <form method="POST" enctype="multipart/form-data">
        
        <h1 class="title"><strong><?php echo $accounttype; ?></strong></h1>
        <br>
        <br>First name: <input type="txt" name="firstname" <?php 
        if($accounttype=="Account Information"){
            echo 'value="' . $loggedcustomer->getFirstName() . '"';
        }
                    ?> >
        <br>Last name: <input type="txt" name="lastname" <?php 
        if($accounttype=="Account Information"){
        echo 'value="' . $loggedcustomer->getLastName() . '"';
        }
                    ?> >
        <br>Address: <input type="txt" name="address" <?php 
        if($accounttype=="Account Information"){
        echo 'value="' . $loggedcustomer->getAddress() . '"';
        }
                    ?> >
        <br>City: <input type="txt" name="city" <?php 
        if($accounttype=="Account Information"){
        echo 'value="' . $loggedcustomer->getCity() . '"';
        }
                    ?> >
        <br>Postal Code: <input type="txt" name="postalcode" <?php 
        if($accounttype=="Account Information"){
        echo 'value="' . $loggedcustomer->getPostalcode() . '"';
        }
                    ?> >
        <br>Username: <input type="txt" name="username">
        <br>Password: <input type="password" name="pass">
        <br>Picture:<input type="file" name="picture">
<?php
if($accounttype=="Registration Information"){
    echo '<br><input type="submit" name="register" value="register">';
}
else{
    echo '<br><input type="submit" name="update" value="update">';
}
?>
        <br><input type="submit" name="main" value="Return to Home Page">
    </form>
</div>
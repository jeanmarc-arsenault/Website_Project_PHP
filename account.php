<?php
define("FOLDER_PHPFUNCTIONS", "common/");
define("FILE_PHPFUNCTIONS", FOLDER_PHPFUNCTIONS."PHPFunctions.php");
require_once FILE_PHPFUNCTIONS;

$accounttype="";
global $loggedcustomer;
//secure https and cookie
securepage();

readCookie();

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
        $password = htmlspecialchars($_POST["password"]);

        $picture = null;

        $thisCustomer = new customer($firstname, $lastname, $address, $city, $postalcode, $username, $password, $picture);
        $thisCustomer->save();
            
        if($picture != null)
        {
            echo '<img src=" data:image;base64,' . base64_encode($row["picture"]).'"/>';
        }
        else
        {
            echo "picture not loaded!";

        }
    }
}
else{
    //update customer
    $accounttype="Account Information";
    
    if(isset($_POST["Update"]))
    {

        
        global $connection;
        $firstname = htmlspecialchars($_POST["firstname"]);
        $lastname = htmlspecialchars($_POST["lastname"]);
        $address = htmlspecialchars($_POST["address"]);
        $city = htmlspecialchars($_POST["city"]);
        $postalcode = htmlspecialchars($_POST["postalcode"]);
        $username = htmlspecialchars($_POST["username"]);
        $password = htmlspecialchars($_POST["password"]);

        $picture = null;
        
        if($_FILE["picture"]["error"] == UPLOAD_ERR_OK && is_uploaded_file($_FILES["picture"]["error"]))
        {
            $pictureFile = file_get_contents($_FILES["picture"]["tmp_name"]);
        }
        else{
            echo "file not on disk";
        }

        $thisCustomer = load($loggedcustomer);
        $thisCustomer->setFirstName($firstname);
        $thisCustomer->setLastName($lastname);
        $thisCustomer->setAddress($address);
        $thisCustomer->setCity($city);
        $thisCustomer->setPostalcode($postalcode);
        $thisCustomer->setUsername($username);
        $thisCustomer->setPassword($password);
        $thisCustomer->setPicture($picture);
        $thisCustomer->save();
        
        if($_FILES["picture"]["error"] == UPLOAD_ERR_OK && is_uploaded_file($_FILES["picture"]["error"]))
        {
            $newPicture = file_get_contents($_FILES["picture"]["tmp_name"]);
            
        }
        else{
            //error
            echo "there is an error geting the image file!";
        }
        
        if($picture != null)
        {
            echo '<img src=" data:image;base64,' . base64_encode($row["picture"]) . '"/>';
        }
        else
        {
            echo "picture not loaded!";

        }
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
        <br>First name: <input type="txt" name="firstname">
        <br>Last name: <input type="txt" name="lastname">
        <br>Address: <input type="txt" name="address">
        <br>City: <input type="txt" name="city">
        <br>Postal Code: <input type="txt" name="postalcode">
        <br>Username: <input type="txt" name="username">
        <br>Password: <input type="txt" name="password">
        <br>Picture:<input type="file" name="picture">
<?php
if($accounttype=="Registration Information"){
    echo '<br><input type="submit" name="register" value="register">';
}
else{
    echo '<br><input type="submit" name="update" value="update">';
}
?>
        
    </form>
</div>
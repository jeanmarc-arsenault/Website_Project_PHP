<?php



//
const OBJECT_COLLECTION = OBJECTS_FOLDER . "collection.php";
const OBJECT_CUSTOMER = OBJECTS_FOLDER . "customer.php";
require_once OBJECT_CONNECTION;
require_once OBJECT_CUSTOMER;
require_once OBJECT_COLLECTION;


class customers extends collection
{
   
    
    function __construct()
    {
        global $connection;
        $SQLquery = "CALL `select_all_customers`()";
        
        $rows = $connection->prepare($SQLquery);
        
          if($rows->execute()){
                
                while($row = $rows->fetch())
                {
                    $customer = new customer($row["cid"], $row["firstname"], $row["lastname"], $row["adress"], $row["city"], $row["postalcode"], $row["picture"]);
                    
                    $this->add($row["cid"],$customer);
                }
          }
        
    }
}

    


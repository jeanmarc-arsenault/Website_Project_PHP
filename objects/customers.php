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
        $SQLquery = "Select * From customers order by firstname";
        
        $rows = $connection->prepare($SQLquery);
        
          if($rows->execute()){
                
                while($row = $rows->fetch())
                {
                    $customer = new customer($row["cid"], $row["firstname"]);
                    
                    $this->add($row["cid"],$customer);
                }
          }
        
    }
}

    


<?php


class customers extends collection
{
   
    function __construct()
    {
        global $connection;
        $SQLquery = "CALL select_all_customers()";
        
        $rows = $connection->prepare($SQLquery);
        
          if($rows->execute()){
                
                while($row = $rows->fetch())
                {
                    $customer = new customer( $row["firstname"], $row["lastname"], $row["city"], $row["address"], $row["postalcode"], $row["username"], $row["password"], $row["picture"], $row["CID"]);
                    
                    $this->add($row["CID"],$customer);
                }
          }
        
    }
}

    


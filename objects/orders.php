<?php


class orders extends collection
{
   
    function __construct()
    {
        global $connection;
        $SQLquery = "CALL select_all_orders()";
        
        $rows = $connection->prepare($SQLquery);
        
          if($rows->execute()){
                
                while($row = $rows->fetch())
                {
                    $order = new order( $row["PID"],$row["CID"],$row["qty"],$row["com"],$row["soldprice"],$row["orderdate"], $row["OID"]);
                    
                    $this->add($row["OID"],$order);
                }
          }
        
    }
}

    


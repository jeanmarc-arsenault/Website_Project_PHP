<?php


class orders extends collection
{
   
    function __construct()
    {
        global $connection;
        $SQLquery = "CALL select_all_orderss()";
        
        $rows = $connection->prepare($SQLquery);
        
          if($rows->execute()){
                
                while($row = $rows->fetch())
                {
                    $order = new order($row["OID"], $row["PID"],$row["CID"],$row["qty"],$row["com"],$row["soldprice"],$row["orderdate"]);
                    
                    $this->add($row["OID"],$order);
                }
          }
        
    }
}

    


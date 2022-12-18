<?php


class products extends collection
{
   
    function __construct()
    {
        global $connection;
        $SQLquery = "CALL select_all_products()";
        
        $rows = $connection->prepare($SQLquery);
        
          if($rows->execute()){
                
                while($row = $rows->fetch())
                {
                    $product = new product( $row["prdcode"], $row["price"], $row["costprice"], $row["info"],$row["PID"]);
                    
                    $this->add($row["PID"],$product);
                }
          }
        
    }
}

    


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
                        $this->pid= $row["PID"];
                        $this->prcode= $row["prcode"];
                        $this->price= $row["price"];
                        $this->costprice= $row["costprice"];
                        $this->info= $row["info"];
                    
                    $product = new product($row["PID"], $row["prcode"], $row["price"], $row["costprice"], $row["info"]);
                    
                    $this->add($row["pid"],$product);
                }
          }
        
    }
}

    


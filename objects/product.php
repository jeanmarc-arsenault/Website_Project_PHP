<?php

 class product {
    const PRCODE_MAX_LENGHT =25;
    const QTY_MAX_LENGHT =5;
    const INFO_MAX_LENGHT =100;
//variables

    private $pid ="";
    private $prdcode ="";
    private $price ="";
    private $costprice ="";
    private $info ="";

    
    public function __construct( $newPrdcode ="",$newPrice ="",$newCostPrice ="", $newInfo ="",$newProductId ="" )
    {

        $this->setPrCode($newPrdcode);
        $this->setPrice($newPrice);
        $this->setSoldPrice($newCostPrice);
        $this->setINFO($newInfo);
        $this->pid = $newProductId;
    }
    
    public function getProductId()
    {
            return $this->pid;
    }
   
    public function getPrice()
    {
        return $this->price;
    }
    
    public function setPrice($newPrice)
    {
        if($newPrice == "")
        {
            return "PID canot be empty";
        }
        else
        {
            if($newPrice > 100000000000.00)
            {
                return "Sold price has to be lower than  100000000000.00 $";
            }
            else
            {
                $this->price = $newPrice;
                return true;
            }
            
        }
    }

    public function getCostPrice()
    {
        return $this->costprice;
    }
    

    
    public function getPrdCode()
    {
        return $this->prdcode;
    }
    
    public function setPrCode($newPrdcode)
    {
        if($newPrdcode == "")
        {
            return "prdcode canot be empty";
        }
        else
        {
            if((mb_strlen($newPrdcode) > self::PRCODE_MAX_LENGHT) )
            {
                return "Prdcode can go to maximum  " . self::PRCODE_MAX_LENGHT . " characters";
            }
            else
            {
                $this->prdcode = $newPrdcode;
                return true;
            }
            
        }
    }

    public function getINFO()
    {
        return $this->info;
    }
    
    public function setINFO($newInfo)
    {

            if((mb_strlen($newInfo) > self::INFO_MAX_LENGHT) )
            {
                return "Info can go to maximum  " . self::INFO_MAX_LENGHT . " characters";
            }
            else
            {
                $this->info = $newInfo;
                return true;
            }
            

    }
    
    public function setCostPrice($newCostPrice)
    {
        if($newCostPrice == "")
        {
            return "PID canot be empty";
        }
        else
        {
            if($newCostPrice > 100000000000.00)
            {
                return "Sold price has to be lower than  100000000000.00 $";
            }
            else
            {
                $this->costprice = $newCostPrice;
                return true;
            }
            
        }
    }

        
    public function getSoldPrice()
    {
        return $this->price;
    }
    
    public function setSoldPrice($newSoldPrice)
    {
        if($newSoldPrice == "")
        {
            return "PID canot be empty";
        }
        else
        {
            if($newSoldPrice > 100000000000.00)
            {
                return "Sold price has to be lower than  100000000000.00 $";
            }
            else
            {
                $this->price = $newSoldPrice;
                return true;
            }
            
        }
    }
    
    //Methods
    
    function load($pid)
    {
        
        global $connection;
        
        ##use procedures
        $SQLquery = "CALL select_one_product(:PID)";
        
        
        $rows = $connection->prepare($SQLquery);
        
        $rows->bindParam(":PID",$pid, PDO::PARAM_STR);
            
            if($rows->execute())
           {
               while($row = $rows->fetch())
                   {
                        $this->pid= $row["PID"];
                        $this->prdcode =$row["prdcode"] ;
                        $this->price= $row["price"];
                        $this->costprice= $row["costprice"];
                        $this->info= $row["info"];

                       return true;
                   }
           }

    }
    
      function save()
    {
        global $connection;
        
        if($this->oid==""){//insert
            $SQLquery = "call insert_new_product(:prdcode, :price,:costprice,:info);";


            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":prdcode", $this->prdcode);
            $rows->bindParam(":price", $this->price);
            $rows->bindParam(":costprice", $this->price);
            $rows->bindParam(":info", $this->info);

                 if($rows->execute())
                {
                    return $rows->rowcount() . "product was added";
                }
        }
        else{//update
         ##use procedeures
         $SQLquery = "call 'update_product(:PID,:prdcode,:price,:costprice,:info)';";

         
         

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":PID", $this->pid);
            $rows->bindParam(":prdcode", $this->prdcode);
            $rows->bindParam(":price", $this->price);
            $rows->bindParam(":costprice", $this->price);
            $rows->bindParam(":info", $this->info);

                 if($rows->execute())
                {
                    return $rows->rowcount() . "product was updated";
                }
        }
    }
    
      function delete($pid)
    {
        global $connection;
        ##use procedeures
     $SQLquery = 'call "delete_product(:PID);"';


            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":PID", $this->$pid);        
            //opional param

                 if($rows->execute())
                {
                    return $rows->rowcount() . "product was deleted";
                }
    }

}

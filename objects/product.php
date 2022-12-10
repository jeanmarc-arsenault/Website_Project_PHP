<?php

 class product {
    const PRCODE_MAX_LENGHT =25;
    const QTY_MAX_LENGHT =5;
    const INFO_MAX_LENGHT =100;
//variables

    private $pid ="";
    private $prcode ="";
    private $price ="";
    private $costprice ="";
    private $info ="";

    
    public function __construct( $newProductId ="", $newPrcode ="",$newPrice ="",$newCostPrice ="", $newInfo ="" )
    {

        $this->setQty($newPrcode);
        $this->setCom($newPrice);
        $this->setSoldPrice($newCostPrice);
        $this->setSoldPrice($newInfo);
        
    }
    
    public function getProductId($newProductId)
    {
            if($newProductId== ""){
                return "..canot be empty";
            }
            else{
                $this->pid = $newProductId;
            }
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
    
    public function getPrCode()
    {
        return $this->prcode;
    }
    
    public function setPrCode($newPrcode)
    {
        if($newPrcode == "")
        {
            return "prcode canot be empty";
        }
        else
        {
            if((mb_strlen($newPrcode) > self::PRCODE_MAX_LENGHT) )
            {
                return "Prcode can go to maximum  " . self::PRCODE_MAX_LENGHT . " characters";
            }
            else
            {
                $this->prcode = $newPrcode;
                return true;
            }
            
        }
    }

    public function getINFO()
    {
        return $this->com;
    }
    
    public function setINFO($newInfo)
    {

            if((mb_strlen($newInfo) > self::INFO_MAX_LENGHT) )
            {
                return "Info can go to maximum  " . self::INFO_MAX_LENGHT . " characters";
            }
            else
            {
                $this->com = $newInfo;
                return true;
            }
            

    }


        
    public function getSoldPrice()
    {
        return $this->cid;
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
                $this->cid = $newSoldPrice;
                return true;
            }
            
        }
    }
    

    //Methhods
    
    function load($pid)
    {
        
        global $connection;
        
        ##use procedures
        $SQLquery = "CALL select_one_product(:PID)";
        
        echo $SQLquery. "<br><br>" ;
        
        $rows = $connection->prepare($SQLquery);
        
        $rows->bindParam(":PID",$pid, PDO::PARAM_STR);
            
            if($rows->execute())
           {
               while($row = $rows->fetch())
                   {
                        $this->pid= $row["PID"];
                        $this->prcode= $row["prcode"];
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
            $SQLquery = "call insert_new_product(:prcode, :price,:costprice,:info);";

            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":prcode", $this->prcode);
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
         $SQLquery = "call 'update_product(:PID,:prcode,:price,:costprice,:info)';";

         
         
            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":PID", $this->pid);
            $rows->bindParam(":prcode", $this->prcode);
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

         
         
            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":PID", $this->$pid);        
            //opional param

                 if($rows->execute())
                {
                    return $rows->rowcount() . "product was deleted";
                }
    }

}

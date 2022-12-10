<?php

 class order {
    //define dont work in object
    const ID_MAX_MIN_LENGHT =36;
    const QTY_MAX_LENGHT =5;
    const COM_MAX_LENGHT =200;
//variables
    private $oid = "";
    private $pid ="";
    private $cid ="";
    private $qty ="";
    private $com ="";
    private $soldprice ="";
    private $orderdate ="";

    
    public function __construct( $newOrderId ="", $newproductId ="", $newcustomerId ="", $newQty ="",$newCom ="",$newSoldPrice ="" )
    {
        $this->setPID($newproductId);
        $this->setCID($newcustomerId);
        $this->setQty($newQty);
        $this->setCom($newCom);
        $this->setSoldPrice($newSoldPrice);
        
    }
    
    public function getOrderId($newOrderId)
    {
            if($newOrderId== ""){
                return "..canot be empty";
            }
            else{
                $this->oid = $newOrderId;
            }
    }
    
        public function getPID()
    {
        return $this->pid;
    }
    
    public function setPID($newproductId)
    {
        if($newproductId == "")
        {
            return "PID canot be empty";
        }
        else
        {
            if((mb_strlen($newproductId) > self::ID_MAX_MIN_LENGHT) && ( mb_strlen($newproductId) < self::ID_MAX_MIN_LENGHT))
            {
                return "PID has to be exactly " . self::ID_MAX_MIN_LENGHT . " characters";
            }
            else
            {
                $this->pid = $newproductId;
                return true;
            }
            
        }
    }


    public function getQty()
    {
        return $this->qty;
    }
    
    public function setQty($newQty)
    {
        if($newQty == "")
        {
            return "quantity canot be empty";
        }
        else
        {
            if($newQty > 100000)
            {
                return "Quatity has to be lower than 100000";
            }
            else
            {
                $this->qty = $newQty;
                return true;
            }
            
        }
    }

    public function getCOM()
    {
        return $this->com;
    }
    
    public function setCOM($newCom)
    {

            if((mb_strlen($newCom) > self::COM_MAX_LENGHT) )
            {
                return "Comment can go to maximum  " . self::COM_MAX_LENGHT . " characters";
            }
            else
            {
                $this->com = $newCom;
                return true;
            }
            
    }


        
    public function getSoldPrice()
    {
        return $this->soldprice;
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
                $this->soldprice = $newSoldPrice;
                return true;
            }
            
        }
    }
    

    //Methhods
    
    function load($oid)
    {
        
        global $connection;
        
        ##use procedures
        $SQLquery = "CALL select_one_order(:oid)";
        
        echo $SQLquery. "<br><br>" ;
        
        $rows = $connection->prepare($SQLquery);
        
        $rows->bindParam(":oid",$oid, PDO::PARAM_STR);                         //opional param
            
            if($rows->execute())
           {
               while($row = $rows->fetch())
                   {
                        $this->oid= $row["OID"];
                        $this->pid= $row["PID"];
                        $this->cid= $row["CID"];
                        $this->qty= $row["qty"];
                        $this->com= $row["com"];
                        $this->soldprice= $row["soldprice"];

                       return true;
                   }
           }

    }
    
      function save()
    {
        global $connection;
        
        if($this->oid==""){//insert
            $SQLquery = "call insert_new_order(:pid, :cid,:qty,:com,:soldprice);";

            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            
            $rows->bindParam(":pid", $this->pid);
            $rows->bindParam(":cid", $this->cid);  
            $rows->bindParam(":qty", $this->qty);
            $rows->bindParam(":com", $this->com);
            $rows->bindParam(":soldprice", $this->soldprice);

            
                 if($rows->execute())
                {
                    return $rows->rowcount() . "customer was added";
                }
        }
        else{//update
         ##use procedeures
         $SQLquery = "call 'update_order(:OID, :PID, :cid,:qty,:com,:soldprice)';";

         
         
            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":OID", $this->oid);
            $rows->bindParam(":PID", $this->pid);
            $rows->bindParam(":CID", $this->cid);  
            $rows->bindParam(":qty", $this->qty);
            $rows->bindParam(":com", $this->com);
            $rows->bindParam(":soldprice", $this->soldprice);

                 if($rows->execute())
                {
                    return $rows->rowcount() . "customer was updated";
                }
        }
    }
    
    
    
      function delete($oid)
    {
        global $connection;
        ##use procedeures
     $SQLquery = 'call "delete_order(:OID);"';

         
         
            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":OID", $this->$oid);        
            //opional param

                 if($rows->execute())
                {
                    return $rows->rowcount() . "order was deleted";
                }
    }

    
    
    
}

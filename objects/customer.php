<?php


 
require_once OBJECT_CONNECTION;


 class customer {


    
    //define dont work in object
    
    const NAME_MAX_LENGHT =20;

//variables
    private $firstname = "";
    private $cid = "";
    public function __construct($newCustomerId ="", $newName = "")
    {
        $this->setPlayerId($newCustomerId);
        $this->setName($newName);
        
    }
    public function setCustomerId()
    {
        return $this->cid;
    }
    
    public function getCustomerId($newCustomerId)
    {
            if($newCustomerId== ""){
                return "..canot be empty";
            }
            else{
                
                $this->cid = $newCustomerId;
            }
         
    }
    
    public function getFirstName()
    {
        return $this->firstname;
    }
    public function setFirstName($newName)
    {
        if($newName == "")
        {
            return "firstname canot be empty";
        }
        else
        {
            if(mb_strlen($newName) > self::NAME_MAX_LENGHT)
            {
                return "first name canot be longer than " . self::NAME_MAX_LENGHT . " characters";
            }
            else
            {
                $this->firstname = $newName;
                return true;
            }
            
        }
    }
    
    public function getLastName()
    {
        return $this->lasttname;
    }
    public function setLastName($newName)
    {
        if($newName == "")
        {
            return "lastname canot be empty";
        }
        else
        {
            if(mb_strlen($newName) > self::NAME_MAX_LENGHT)
            {
                return "lastname canot be longer than " . self::NAME_MAX_LENGHT . " characters";
            }
            else
            {
                $this->lastname = $newName;
                return true;
            }
            
        }
    }    
    
    
    //Methhods
    
    function load($cid)
    {
        global $connection;
        ##use procedeures
        $SQLquery =     "call 'select_all_customers()';";

        echo $SQLquery. "<br><br>" ;
        
        $rows = $connection->prepare($SQLquery);
        $rows->bindParam(":cid", $cid);                                      //opional param
            
             
             
             if($rows->execute())
            {
                while($row = $rows->fetch())
                    {
                       
                        $this-> cid = $row["cid"];
                        $this-> firstname = $row["firstname"];
                        return true;
                    }
            }

    }
    
      function save()
    {
        global $connection;
        
        if($this->cid==""){//insert
            $SQLquery = "call 'insert_new_customer(:firstname,:lastname,:address,:city,:postalcode,:username,:password,:picture)';";

            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":firstname", $this->firstname);                                  //opional param
            $rows->bindParam(":lastname", $this->lastname);
            $rows->bindParam(":address", $this->address);      
            $rows->bindParam(":city", $this->city);      
            $rows->bindParam(":postalcode", $this->postalcode);
            $rows->bindParam(":username", $this->username);
            $rows->bindParam(":password", $this->password);
            $rows->bindParam(":picture", $this->picture);
            
                 if($rows->execute())
                {
                    return $rows->rowcount() . "customer was added";
                }
        }
        else{//update
         ##use procedeures
         $SQLquery = "call 'update_customer(:cid,:firstname,:lastname,:address,:city,:postalcode,:username,:password,:picture)';";

         
         
            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":cid", $this->cid);        
            $rows->bindParam(":firstname", $this->firstname);       //opional param

                 if($rows->execute())
                {
                    return $rows->rowcount() . "customer was updated";
                }
        }
    }
    
    
    
      function delete($cid)
    {
        global $connection;
        ##use procedeures
     $SQLquery = 'call "delete_customer(:CID);"';

         
         
            echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":cid", $this->cid);        
            //opional param

                 if($rows->execute())
                {
                    return $rows->rowcount() . "customer was deleted";
                }
    }

    
    
    
}

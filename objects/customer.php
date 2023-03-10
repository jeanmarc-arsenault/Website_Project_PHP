<?php
class customer {
    //define dont work in object
    
    const NAME_MAX_LENGHT =20;
    const USERNAME_MAX_LENGHT =15;
    const ADDRESSCITY_MAX_LENGHT=25;
    const POSTALCODE_MAX_LENGHT =7;
//variables
    private $firstname = "";
    private $cid = "";
    private $lastname ="";
    private $address ="";
    private $city ="";
    private $postalcode ="";
    private $picture ="";
    private $username ="";
    private $password ="";
    
    public function __construct( $newFName = "", $newLName = "", $newCity = "", $newAddress = "", $newPostalCode = "",$newUsername = "", $newPassword = "", $newPicture = "", $newCID = "" )
    {
        $this->setFirstName($newFName);
        $this->setLastName($newLName);
        $this->setCity($newCity);
        $this->setAddress($newAddress);
        $this->setPostalCode($newPostalCode);
        $this->setUsername($newUsername);
        $this->setPassword($newPassword);
        $this->setPicture($newPicture);
        $this->cid = $newCID;
    }
    
    public function getCustomerId()
    {
        return $this->cid;
    }
    
    public function getFirstName()
    {
        return $this->firstname;
    }
    
    public function setFirstName($newFName)
    {
        if($newFName == "")
        {
            return "firstname canot be empty";
        }
        else
        {
            if(mb_strlen($newFName) > self::NAME_MAX_LENGHT)
            {
                return "first name canot be longer than " . self::NAME_MAX_LENGHT . " characters";
            }
            else
            {
                $this->firstname = $newFName;
                return true;
            }
            
        }
    }
    
    
    public function getLastName()
    {
        return $this->lastname;
    }
    
    public function setLastName($newLName)
    {
        if($newLName == "")
        {
            return "last name canot be empty";
        }
        else
        {
            if(mb_strlen($newLName) > self::NAME_MAX_LENGHT)
            {
                return "last name canot be longer than " . self::NAME_MAX_LENGHT . " characters";
            }
            else
            {
                $this->lastname = $newLName;
                return true;
            }
            
        }
    }    
    
    public function getAddress()
    {
        return $this->address;
    }
    
    public function setAddress($newAddress)
    {
        if($newAddress == "")
        {
            return "address canot be empty";
        }
        else
        {
            if(mb_strlen($newAddress) > self::ADDRESSCITY_MAX_LENGHT)
            {
                return "address canot be longer than " . self::ADDRESSCITY_MAX_LENGHT . " characters";
            }
            else
            {
                $this->address = $newAddress;
                return true;
            }
            
        }
    } 

    public function getCity()
    {
        return $this->city;
    }
    
    public function setCity($newCity)
    {
        if($newCity == "")
        {
            return "city canot be empty";
        }
        else
        {
            if(mb_strlen($newCity) > self::ADDRESSCITY_MAX_LENGHT)
            {
                return "city canot be longer than " . self::ADDRESSCITY_MAX_LENGHT . " characters";
            }
            else
            {
                $this->city = $newCity;
                return true;
            }
            
        }
    } 
    
    
     public function getPostalcode()
    {
        return $this->postalcode;
    }
    
    public function setPostalcode($newPostalCode)
    {
        if($newPostalCode == "")
        {
            return "Postal Code canot be empty";
        }
        else
        {
            if(mb_strlen($newPostalCode) > self::POSTALCODE_MAX_LENGHT)
            {
                return "Postal Code canot be longer than " . self::POSTALCODE_MAX_LENGHT . " characters";
            }
            else
            {
                $this->postalcode = $newPostalCode;
                return true;
            }
            
        }
    } 
    
    public function getPicture()
    {
        return $this->picture;
    }
    
    public function setPicture($newPicture)
    {   

        $this->picture = $newPicture;

    } 

    public function getUsername()
    {
        return $this->username;
    }
    
    public function setUsername($newUsername)
    {
        if($newUsername == "")
        {
            return "username canot be empty";
        }
        else
        {
            if(mb_strlen($newUsername) > self::USERNAME_MAX_LENGHT)
            {
                return "username canot be longer than " . self::USERNAME_MAX_LENGHT . " characters";
            }
            else
            {
                $this->username = $newUsername;
                return true;
            }
            
        }
    } 
    
    public function setPassword($newPassword)
    {
        if($newPassword == "")
        {
            return "Password error";
        }
        else
        {
            $encrytedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->pass = $encrytedPassword;
            return true;
        }
    }
    
    //Methods
    
    function load($cid)
    {
        
        global $connection;
        
        ##use procedures
        $SQLquery = "CALL select_one_customer(:cid)";
        
        //echo $SQLquery. "<br><br>" ;
        
        $rows = $connection->prepare($SQLquery);
        
        $rows->bindParam(":cid",$cid, PDO::PARAM_STR);                         //opional param
            
            if($rows->execute())
           {
               while($row = $rows->fetch())
                   {

                       $this->cid = $row["CID"];
                       $this->firstname = $row["firstname"];
                       $this->lastname = $row["lastname"];
                       $this->address = $row["address"];
                       $this->city = $row["city"];
                       $this->postalcode = $row["postalcode"];
                       $this->picture = $row["picture"];
                       return true;
                   }
           }

    }
    
    function save()
    {
        global $connection;
        
        if($this->cid==""){//insert
            $SQLquery = "call insert_new_customer(:firstname,:lastname,:address,:city,:postalcode,:username,:pass,:picture);";

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":firstname", $this->firstname);                                  //opional param
            $rows->bindParam(":lastname", $this->lastname);
            $rows->bindParam(":address", $this->address);  
            $rows->bindParam(":city", $this->city);    
            $rows->bindParam(":postalcode", $this->postalcode);
            $rows->bindParam(":username", $this->username);
            $rows->bindParam(":pass", $this->pass);
            $rows->bindParam(":picture", $this->picture);
            
                 if($rows->execute())
                {
                    return $rows->rowcount() . "customer was added";
                }
        }
        else{//update

         $SQLquery = "call update_customer(:cid,:firstname,:lastname,:address,:city,:postalcode,:username,:pass,:picture);";

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":cid", $this->cid);
            $rows->bindParam(":firstname", $this->firstname);                                  //opional param
            $rows->bindParam(":lastname", $this->lastname);
            $rows->bindParam(":address", $this->address);      
            $rows->bindParam(":city", $this->city);      
            $rows->bindParam(":postalcode", $this->postalcode);
            $rows->bindParam(":username", $this->username);
            $rows->bindParam(":pass", $this->pass);
            $rows->bindParam(":picture", $this->picture);    //opional param

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
     $SQLquery = 'call delete_customer(:CID);';

         
         
            //echo $SQLquery. "<br><br>" ;

            $rows = $connection->prepare($SQLquery);
            $rows->bindParam(":CID", $this->$cid);        
            //opional param

                 if($rows->execute())
                {
                    return $rows->rowcount() . "customer was deleted";
                }
    }
    
}

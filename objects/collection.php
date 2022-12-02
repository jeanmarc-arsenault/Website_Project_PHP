<?php

class collection
{
   public $items = array(); 
    
    //theya re done in momory and not in database
    // player-id, player, product customer etc...
    public function add($primary_key, $item){
        $this->items[$primary_key] = $item;
    }
    
    public function remove($primary_key, $item){
        if(isset($this->items[$primary_key])){
            unset($this->items[$primary_key]);
        }
    }
    
    public function get($primary_key, $item){
        if(isset($this->items[$primary_key])){
            return ($this->items[$primary_key]);
        }
    }
    
    public function count(){
        
            return count($this->items);
    }
}




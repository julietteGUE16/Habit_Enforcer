<?php

class Group
{

//id of the user
//todo : !!!

public function __construct( int $idGroup)
 {

     $this->idGroup = $idGroup;
     
 }

//todo : ...

public function getIdGroup (): string {
    return $idGroup;
}


//todo : voir si utile


public function addGroupToDataBase () {
    //todo
}

public function RemoveGroupToDataBase () {
    //todo
}

}//todo : delete : group
//todo : add score 
//todo : remove score
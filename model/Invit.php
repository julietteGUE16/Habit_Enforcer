<?php

class Invit
{

//id of the user
private int $idInvit;
//user who send the invitation
private int $idUser;
//id user invited
private int $idUserInvited;
//id group
private int $idGroup;
//pseudo of user who send the invitation
private string $host_pseudo;




 
 public function __construct(int $idUser, string $pseudo, int $idGroup, int $email)
 {
     $this->$idUser = $idUser;
     $this->$pseudo = $pseudo;
     $this->idGroup = $idGroup;
     $this->$email = $email;
 }

 
 public function GetIdUser (): int{
     return $idUser;
 }
 public function getPseudo (): string {
     return $pseudo;
 }

 public function getEmail (): string {
    return $email;
}

public function getIdGroup (): string {
    return $idGroup;
}


//todo : voir si utile


public function addUserToDataBase () {
    //todo
}

public function RemoveUserToDataBase () {
    //todo
}

}//todo : delete : invit
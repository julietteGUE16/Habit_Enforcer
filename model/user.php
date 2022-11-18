<?php

class user
{

 //id of the user
 private int $idUser;
 //name of the user
 private string $pseudo;
 //id group
 private int $idGroup;
 //email
 private string $email;
 //last date task 
 private date $lastTaskCreat;

 private date $lastConnexion;

 
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

}
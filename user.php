<?php

class user
{

 //id of the user
 private int $id;
 //name of the user
 private string $pseudo;
 //id group
 private int $idGroup;
 //email
 private string $email;
 //last date task 
 private string $lastTask;


 //TODO : créer une tâche toute les 24h
 public function __construct(int $id, string $pseudo, int $idGroup)
 {
     $this->$id = $id;
     $this->$pseudo = $pseudo;
 }

 
 public function getId (): int{
     return $id;
 }
 public function getPseudo (): string {
     return $pseudo;
 }

}
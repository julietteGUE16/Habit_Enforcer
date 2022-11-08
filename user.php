<?php

class user
{

 //id of the user
 private int $id;
 //name of the user
 private string $pseudo;
 //
 //private string $password;


 //TODO : créer une tâche toute les 24h
 public function __construct(int $id, string $pseudo)
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
<?php

class User
{

    //id of the user
    private int $idUser;
    //name of the user
    private string $pseudo;
    //id group
    private ?int $idGroup;
    //email
    private string $email;
    //password
    private string $password;

    private ?date $lastTaskCreat;

    private ?date $lastConnexion;

 
    public function __construct(int $idUser, string $pseudo, ?int $idGroup, string $email, string $password, ?date $lastTaskCreat, ?date $lastConnexion)
    {
        $this->idUser = $idUser;
        $this->pseudo = $pseudo;
        $this->idGroup = $idGroup;
        $this->email = $email;
        $this->password = $password;
        $this->lastTaskCreat = $lastTaskCreat;
        $this->lastConnexion = $lastConnexion;
    }

 
    public function GetIdUser (): int{
        return $this->idUser;
    }
    public function getPseudo (): string {
        return $this->pseudo;
    }

    public function getEmail (): string {
        return $this->email;
    }

    public function getIdGroup (): ?int {
        return $this->idGroup;
    }

    public function getPassword (): string {
        return $this->password;
    }

    public function getLastTaskCreat (): ?date {
        return $this->lastTaskCreat;
    }

    public function getLastConnexion (): ?date {
        return $this->idGroup;
    }
}
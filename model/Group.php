<?php

class Group
{

    //id of the user
//todo : !!!

    private int $idGroup;
    //name of the group
    private string $nameGroup;
    //description of the group
    private string $description;

    private int $last_score = 0;

    private int $previous_score = 0;

    public function __construct(?int $idGroup, string $nameGroup, int $last_score, string $description, int $previous_score)
    {

        $this->idGroup = $idGroup;
        $this->nameGroup = $nameGroup;
        $this->last_score = $last_score;
        $this->description = $description;
        $this->previous_score = $previous_score;


    }

    //todo : ...

    public function getIdGroup(): string
    {
        return $idGroup;
    }


    //todo : voir si utile


    public function addGroupToDataBase()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $insertGroup = $bdd->prepare('INSERT INTO groups(name_group,description)VALUES(?,?)');
        $insertGroup->execute(array($this->nameGroup,$this->description)); 
    }

    public function RemoveGroupToDataBase()
    {
        //todo
    }

    public function addScore()
    {
        //todo
    }

} //todo : delete : group
//todo : add score 
//todo : remove score

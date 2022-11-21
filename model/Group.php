<?php

class Group
{

    

    private ?int $idGroup;
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

    public function getPreviousScore(): int
    {
        return $previous_score;
    }

   
   

     public function setOnSession()
     {
        session_start();
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $recupGroup = $bdd->prepare('SELECT * FROM groupes WHERE name_group = ? AND description = ?');
        $recupGroup->execute(array($this->nameGroup,$this->description));
        $fetch = $recupGroup->fetch();
        if ($recupGroup->rowCount() > 0) { 
            $_SESSION['id_group'] = $fetch['id_group'];
            $_SESSION['last_score'] =  0;
            $_SESSION['previous_score'] =  0;
            $_SESSION['name_group'] = $nom;
            $_SESSION['description'] = $description;
            $UpdateUser = $bdd->prepare('UPDATE users SET id_group = ?  WHERE id_user = ? ');
            $UpdateUser->execute(array($_SESSION['id_group'], $_SESSION['id_user']));
        }


     }

    //todo : voir si utile


    public function addGroupToDataBase()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $insertGroup = $bdd->prepare('INSERT INTO groupes(name_group,description)VALUES(?,?)');
        $insertGroup->execute(array($this->nameGroup,$this->description)); 
    }

    public function RemoveGroupToDataBase()
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $deleteGroup = $bdd->prepare('DELETE FROM groupes WHERE id_group = ?');
        $deleteGroup->execute(array($this->idGroup));
    }

    public function addScore($value)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $total = $this->last_score + $value;
        $updateScore = $bdd->prepare('UPDATE groupes SET last_score = ? WHERE id_group = ?');
        $updateScore->execute(array($total,$this->idGroup));
    }

} //todo : delete : group
//todo : add score 
//todo : remove score

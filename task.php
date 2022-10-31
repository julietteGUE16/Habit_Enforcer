<?php


class task
{
    //task permet de définir la couleur par rapport au type de task selectionné
    private type_task $task;
    //text qui défini la tâche
    private  string $name;
    //level de difficulté de la tâche
    private int $level;
    //si true alors c'est quotidien sinon si false c'est hebdomadaire (weekly)
    private bool $isDaily;

    //si c'est hebdomadaire il faut choisir le jour de la semaine qui va revenir
    private string $day;
    //id user qui à créé la tâche
    private int $idUser;
    

    //TODO : id task ????
    public function __construct(type_task $task, string $name, int $level, bool $isDaily, string $day, int $idUser)
    {
        $this->$task = $task;
        $this->$name = $name;
        $this->$level = $level;
        $this->$isDaily = $isDaily;     
        $this->$day = $day;
        $this->$idUser = $idUser;
    }

    public function getTask (): type_task{
        return $task;
    }

    /*public function setTask (type_task $t){
        $task = $t;
    }*/

    public function getName (): string{
        return $name;
    }

    public function getLevel (): int{
        return $level;
    }

    public function getIsDaily (): bool{
        return $isDaily;
    }
    public function getDay (): string{
        return $day;
    }
    public function getIdUser (): int {
        return $idUser;
    }
}

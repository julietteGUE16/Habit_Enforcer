<?php 
require '../model/Group.php';

class Task
{
   
    //task permet de définir la couleur par rapport au type de task selectionné
    private string $category;
    //text qui défini la tâche
    private  string $nameTask;
    //level de difficulté de la tâche
    private string $difficulty;
    //si true alors c'est quotidien sinon si false c'est hebdomadaire (weekly)
    private bool $isDaily;
    //si c'est hebdomadaire il faut choisir le jour de la semaine qui va revenir
    private ?string $day;
    //id user qui à créé la tâche
    private int $idUser;
    //bool qui permet de valider ou non le task
    private bool $isValid;
    //id task (?int permet d'initialiser à null)
    private ?int $idTask;
    //date de la dernière validité
    private ?date $LastvalidDate;

    
    public function __construct(?int $idTask, bool $isValid, string $nameTask,string $category,string $difficulty, int $idUser, bool $isDaily, ?string $day, ?date $LastvalidDate)
    {  
        //Attention a ne pas mettre de $ après le $this->
        $this->isValid = $isValid;
        $this->nameTask = $nameTask;
        $this->category = $category;
        $this->difficulty = $difficulty;
        $this->isDaily = $isDaily;
        $this->day = $day;
        $this->idUser = $idUser;  
        $this->idTask = $idTask;  
        $this->LastvalidDate = $LastvalidDate;      
      
    }

    public function getCategory (): string{
        return $this->category;
    }

    public function getIdTask () : ?int{
        return $this->idTask;
    }

    public function getNameTask (): string{
        return $this->nameTask;
    }

    public function getDifficulty (): int{
        return $this->difficulty;
    }

    public function getIsDaily (): bool{
        return $this->isDaily;
    }
    public function getDay (): ?string{
        return $this->day;
    }
    public function getIdUser (): int {
        return $this->idUser;
    }

    public function getIsValid () : bool {
        return $this->isValid;
    }

    public function getValidDate () : ?date {
        return $this->lastValidDate;
    }


    //todo : pour les set possible faire un set de la velur et un set dans la database  ici par exemple pour is valid
    public function setIsValid ($b)  {
        $this->isValid = $b;
        //todo : bien?
        setIsValidInDatabase();
    }

    public function setIsValidInDatabase ()  {
        //TODO
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', ''); 
        $updateValid = $bdd->prepare('UPDATE tasks SET isvalid=? WHERE id_task = ?');
        $updateValid->execute(array($this->isValid?1:0,$this->idTask));
    }

    public function addTaskToDataBase () { 
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $insertTask = $bdd->prepare('INSERT INTO tasks(isvalid,name_task,category,difficulty,isdaily,chosen_day,id_user)VALUES(?,?,?,?,?,?,?)');
        $insertTask->execute(array($this->isvalid?1:0,$this->nameTask,$this->category,$this->difficulty,$this->isdaily?1:0,$this->day,$this->idUser));
    }

    public function setIdTaskFromDatabase ()  {
        //TODO
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');    
        $getTask = $bdd->prepare('SELECT id_task WHERE isvalid=? AND name_task=? AND category=? AND difficulty=? AND isdaily=? AND chosen_day=? AND id_user =?');
        $getTask->execute(array($this->isvalid?1:0,$this->nameTask,$this->category,$this->difficulty,$this->isdaily?1:0,$this->day,$this->id_user));
        $fetch = $getTask->fetch();
     
        if ($getTask->rowCount() > 0) {
            $this->idTask = $fetch['id_task'];
        }
     
    }



    public static function setvalidtask($listid, $listdif){ //valid/retire validation une fois submit et met à jour le last_score
    $i = 0;
    $calcul = 0;
    foreach ($listid as $value) 
    { 
        $bdd = new PDO('mysql:host=localhost;dbname=bdd_tarootyn;charset=utf8;','root', '');
        $updateValid = $bdd->prepare('UPDATE tasks SET isvalid=? WHERE id_task = ?');
      if (isset($_POST["$value"])) 
      { 
        $valid = 1;
        $updateValid->execute(array(1,$value));
        $calcul += $listdif[$i];
      } 
      else {
        $valid = 0;
        $updateValid->execute(array(0,$value));
      }
      ++$i;
    }
    $_SESSION['group'] = new Group($_SESSION['id_group'], $_SESSION['name_group'], $_SESSION['last_score'], $_SESSION['description'], $_SESSION['previous_score']);
    $_SESSION['group']->addScore($calcul);
    } 

}

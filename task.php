<?php


class task
 {
      /** Declaration of attributes */
      public type_task $task;
      public int $doorsNumber;

      
    
      public function __construct(type_task $task)
      {
           // ↙ $this means the current context
           $this->fuelLevel = 45.4; // <- the default value
           //         ↖ Attribute
           $this->doorsNumber = 3;
           $this->wheelNumber = 4;
      }
 }

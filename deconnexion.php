<!DOCTYPE html>
<html>
<html lang="en-US">
<head>
    <title>Connexion</title>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Habit_Enforcer/Assets/style.css" crossorigin="anonymous">
</head>
<img class="logo" src="https://zupimages.net/up/22/44/pbyf.png">

<body class="login">


  <div class="container">

    <div class="login-wrapo flex">

      <div class="login-box">

        <h2>DECONNEXION</h2>
        <?php 
session_start();
session_destroy();
echo "Vous avez été déconnécté";
?>
<br/><br/>
<p class="flex"> <a href="../Habit_Enforcer/connexion.php"> Se connecter à nouveau ? </a> </p>
      </div>

    </div>

  </div>

</body>
</html>

<?php

  session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body class="loginBody">
    <div class="div_form mt-5">
        <form action="pages/scriptlogin.php" method="post">
            <h1 class="titolo">Effettua il login</h1>
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username" required >
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-light">Invia</button>
          </form>
          <br>
          <?php
            if(isset($_SESSION["messaggio_di_errore_login"])){
              echo "<div class='alert alert-danger' role='alert'>".$_SESSION['messaggio_di_errore_login']."</div>";
              unset($_SESSION['messaggio_di_errore_login']);

            }
              

          ?>
          <br>
          <a href="./pages/paginaSignUp.php">Non hai un account ? Registrati</a>
    </div>
    
</body>
</html>
<?php

  session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="loginBody">
    <div class="div_form mt-5">
        <form action="scriptSignUp.php" method="post">
            <h1 class="titolo">Registrati</h1>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="nome" required >
              </div>
              <div class="mb-3">
                <label for="cognome" class="form-label">Cognome</label>
                <input type="text" class="form-control" name="cognome" id="cognome" required >
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" required >
              </div>
            <div class="mb-3">
              <label for="newusername" class="form-label">Username</label>
              <input type="text" class="form-control" name="newusername" id="newusername" required >
            </div>
            <div class="mb-3">
              <label for="newpassword" class="form-label">Password</label>
              <input type="password" class="form-control" name="newpassword" id="newpassword" required>
            </div>
            <div class="mb-3">
                <label for="repeatpassword" class="form-label">Ripeti Password</label>
                <input type="password" class="form-control" name="repeatpassword" id="repeatpassword" required>
              </div>
            <button type="submit" id="pulsanteRegistrazione" class="btn btn-light">Invia</button>
          </form>
          <br>
          <?php
            if(isset($_SESSION["messaggio_di_errore_reg"])){
              echo "<div class='alert alert-danger' role='alert'>".$_SESSION['messaggio_di_errore_reg']."</div>";
              unset($_SESSION['messaggio_di_errore_reg']);

            }
              

          ?>
          <br>
          <a href="../paginalogin.php">Hai gia un account ? Accedi</a>
    </div>
    
    <script src="../js/script.js"></script>
</body>
</html>
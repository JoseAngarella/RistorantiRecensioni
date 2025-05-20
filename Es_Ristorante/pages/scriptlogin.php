<?php
    session_start();
    $_SESSION['accesso']=false;
    include("connessione.php");
    //controllo dati
    if(!isset($_POST['username']) or !isset($_POST['password'])){
        header("Location: ../paginalogin.php");
        exit;
    }else{

        $username = $_POST['username'];
        $password = $_POST['password'];
        $passwordHash = hash("sha256",$password);
    }

    $result=$conn->query("SELECT * FROM utente as u Where u.username='".$username."'");
    if($result->num_rows==0){
        $_SESSION['messaggio_di_errore_login']="Errore: Username non valido";
        header("Location: ../paginalogin.php");
        exit;

    }else{
        $row= $result -> fetch_assoc();
        if($row['password']==$passwordHash){
            $_SESSION['accesso']=true;
            $_SESSION['nome']=$row['nome'];
            $_SESSION['cognome']=$row['cognome'];
            $_SESSION['email']=$row['email'];
            $_SESSION['username']=$row['username'];
            $_SESSION['id_utente']=$row['id'];
            $_SESSION['dataregistrazione']=$row['dataregistrazione'];
            $_SESSION['admin']=$row['admin'];

            unset($_SESSION['messaggio_di_errore_login']);
            if($_SESSION['admin']==1){
                header("Location: pannelloAdmin.php");

            }else{
                header("Location: benvenuto.php");
            }
        }else{
            $_SESSION['messaggio_di_errore_login']="Errore: password errata";
            header("Location: ../paginalogin.php");
        }

    }






?>

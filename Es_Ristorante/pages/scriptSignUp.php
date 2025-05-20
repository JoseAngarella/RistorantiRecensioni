<?php

    session_start();
    include("connessione.php");
    //controllo dati
    if(!isset($_POST['nome']) or !isset($_POST['cognome']) or  !isset($_POST['email']) or  !isset($_POST['newusername'])  or !isset($_POST['newpassword']) or !isset($_POST['repeatpassword']) ){
        header("Location: ./paginaSignUp.php");
        exit;
    }else if($_POST['newpassword']!=$_POST['repeatpassword']){
        $_SESSION['messaggio_di_errore_reg']="Password non coincidono";
        header("Location: ./paginaSignUp.php");
        exit;
    }else{
        $nome=$_POST['nome'];
        $cognome=$_POST['cognome'];
        $email=$_POST['email'];
        $username=$_POST['newusername'];
        $password=$_POST['newpassword'];
        $passwordHash = hash("sha256",$password);
    }

    $result=$conn->query("SELECT * FROM utente WHERE utente.email='".$email."'");
    if($result->num_rows>0){
        $_SESSION['messaggio_di_errore_reg']="Email gia in uso";
        header("Location: ./paginaSignUp.php");
        exit;
    }else{
        $result=$conn->query("SELECT * FROM utente WHERE utente.username='".$username."'");
        if($result->num_rows>0){
            $_SESSION['messaggio_di_errore_reg']="Username gia in uso";
            header("Location: ./paginaSignUp.php");
            exit;
        }else{
            $row=$result->fetch_assoc();
            $addUtente=$conn->query("INSERT INTO utente (username, password, nome,cognome,email ) VALUES ('$username','$passwordHash','$nome','$cognome','$email') ");
            if($addUtente){
                $_SESSION['id_utente']=$row['id']
                $_SESSION['dataregistrazione']=$row['dataregistrazione'];
                $_SESSION['accesso']=true;
                $_SESSION['nome']=$nome;
                $_SESSION['cognome']=$cognome;
                $_SESSION['email']=$email;
                $_SESSION['username']=$username;
                unset($_SESSION['messaggio_di_errore_reg']);
                header('Location: benvenuto.php');
                exit;
            }else{
                $_SESSION['messaggio_di_errore_reg']="Errore sconosciuto, Registrazione fallita";
                header("Location: ./paginaSignUp.php");
            }
        }
    }





?>
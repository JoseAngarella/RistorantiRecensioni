<?php
    include "connessione.php";
    include "controlloAcesso.php";

    if(!isset($_POST['voto']) or !isset($_POST['codice_ristorante'])){
        $_SESSION['messaggio_errore_recensione']="variabili mancanti ";
        header('Location: benvenuto.php');

        exit;
    }elseif($_POST['voto']<1 or $_POST['voto']>5){
        $_SESSION['messaggio_errore_recensione']="il voto deve essere tra 1 e 5";
        header('Location: benvenuto.php');
        exit;


    }else{
        $voto=$_POST['voto'];
        $codice=$_POST['codice_ristorante'];
        $id_utente=$_SESSION['id_utente'];
        $controlloCodice=$conn->query("Select * from ristorante where codice=$codice");
        if($controlloCodice -> num_rows == 1){
            $controlloRecensioneGiaInserita= $conn-> query("Select * from recensione where id_utente=$id_utente and codice_ristorante=$codice");
            if($controlloRecensioneGiaInserita-> num_rows>0){
                $_SESSION['messaggio_errore_recensione']="puoi inserire solo una recensione per ristorante";

            }else{
                $result=$conn->query("Insert into recensione (voto, codice_ristorante, id_utente) Values ($voto, '$codice', $id_utente)");
                if($result){
                    $_SESSION['messaggio_inserimento_recensione']="Recensione inserita";

                }else{
                    $_SESSION['messaggio_errore_recensione']="query finita male";

                }
            }
            

        }else{
            $_SESSION['messaggio_errore_recensione']="il ristorante non esiste";


        }
        header('Location: benvenuto.php');


    }


?>
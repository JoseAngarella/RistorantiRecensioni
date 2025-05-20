<?php
    include "connessione.php";
    include "controlloAcessoAdmin.php";

    if(!isset($_POST['codice']) or !isset($_POST['nome']) or !isset($_POST['indirizzo']) or !isset($_POST['citta']) or !isset($_POST['latitudine']) or !isset($_POST['longitudine'])){
        $_SESSION['messaggio_errore_ristorante']="variabili mancanti ";
        header('Location: pannelloAdmin.php');
        exit;
    
    }else{
        $nome=$_POST['nome'];
        $citta=$_POST['citta'];
        $indirizzo=$_POST['indirizzo'];
        $codice=$_POST['codice'];
        $latitudine=$_POST['latitudine'];
        $longitudine=$_POST['longitudine'];
        $controlloCodice=$conn->query("SELECT * FROM ristorante where codice=$codice");
        if($controlloCodice -> num_rows <1){
                $result=$conn->query("Insert into ristorante (codice, nome, citta, indirizzo, latitudine, longitudine) Values ('$codice', '$nome', '$citta', '$indirizzo', '$latitudine', '$longitudine')");
                if($result){
                    $_SESSION['messaggio_inserimento_ristorante']="Ristorante inserito";

                }else{
                    $_SESSION['messaggio_errore_ristorante']="query finita male";

                }
            

        }else{
            $_SESSION['messaggio_errore_ristorante']="il codice e gia stato utilizzato";


        }
        header('Location: pannelloAdmin.php');

    }


?>
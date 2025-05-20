<?php 

    session_start();
    if(isset($_SESSION['accesso'])){
        if($_SESSION['accesso']==false){
            header("Location: ../paginalogin.php");
            exit;
        }
    }else{
        header("Location: ../paginalogin.php");
        exit;
    }

?>
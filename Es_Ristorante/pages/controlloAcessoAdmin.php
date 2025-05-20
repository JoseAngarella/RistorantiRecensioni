<?php 

    session_start();
    if(isset($_SESSION['accesso']) and $_SESSION['admin']==1){
        if($_SESSION['accesso']==false){
            header("Location: ../paginalogin.php");
            exit;
        }
    }else{
        header("Location: ../paginalogin.php");
        exit;
    }

?>
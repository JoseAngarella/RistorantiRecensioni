<?php
    include("controlloAcessoAdmin.php");
    include("connessione.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvenuto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="messaggio_benvenuto">
      Benvenuto <?php echo $_SESSION['nome']." "; echo $_SESSION['cognome']?>
    </div>
    <!--<br><br>
   <ul>
        <li>Nome: <?php echo $_SESSION['nome']?></li>
        <li>Cognome: <?php echo $_SESSION['cognome']?></li>
        <li>Username: <?php echo $_SESSION['username']?></li>
        <li>Email:<?php echo $_SESSION['email']?></li>
    </ul> -->
    <div class="div_ristoranti">
        <?php

            $result= $conn -> query("SELECT *, count(r.id) as numr
                                    FROM ristorante rc LEFT JOIN recensione r on r.codice_ristorante=rc.codice 
                                    GROUP BY rc.codice ORDER BY codice");
            if(!$result){

                echo "<h1>Errore Query</h1>";

            }else if($result->num_rows<=0){
                echo "<h1>Nessun ristorante trovato</h1>";

            }else{

                echo "<h1>Numero ristoranti: ". $result->num_rows ." </h1>";
                
                $stampa= "<table><tr>
                            <th>Codice</th>
                            <th>Nome</th>
                            <th>Indirizzo</th>
                            <th>citta</th>
                            <th>Recensioni</th></tr>";
                while($row=$result-> fetch_assoc()){
                    $stampa.="<tr>
                    <td>".$row['codice']."</td>
                    <td>".$row['nome']."</td>
                    <td>".$row['indirizzo']."</td>
                    <td>".$row['citta']."</td>
                    <td>".$row['numr']."</td></tr>";
                }

                $stampa.="</table>";
                echo $stampa;

            }
        ?>
       
    </div>
    <br><br>
    <div class="form_inserimento">
            <form action="inserimentoRistorante.php" method="post">
                <h1>Inserisci un ristorante</h1>
                <div class="mb-3">
                    <label for="codice" class="form-label">Codice</label>
                    <input type="text" class="form-control" name="codice" id="codice" required >
                </div>
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" name="nome" id="nome" required >
                </div>
                <div class="mb-3">
                    <label for="indirizzo" class="form-label">Indirizzo</label>
                    <input type="text" class="form-control" name="indirizzo" id="indirizzo" required>
                </div>                   
                <div class="mb-3">
                    <label for="citta" class="form-label">Citta</label>
                    <input type="text" class="form-control" name="citta" id="citta" required>
                </div>
                <br> 
                <?php
                        if(isset($_SESSION["messaggio_inserimento_ristorante"])){
                            echo "<p style='color:green'>".$_SESSION['messaggio_inserimento_ristorante']."<p>";
                            unset($_SESSION['messaggio_inserimento_ristorante']);
              
                          }
                          if(isset($_SESSION["messaggio_errore_ristorante"])){
                            echo "<p style='color:red'>".$_SESSION['messaggio_errore_ristorante']."<p>";
                            unset($_SESSION['messaggio_errore_ristorante']);
              
                          }

                ?>
                <button type="submit" class="btn btn-light">Invia</button>
          </form>        

    </div>
    <br><br>

    <!-- chatbot ai che usa la mia chiave api personale di openai-->
    <!-- <div class = "div_chatbot">
        <h2 >Chiedi come dare una giusta valutazione all'assistente AI</h2>
        <textarea  id="message" placeholder="Scrivi un messaggio..." rows="2" cols="50"></textarea>
        <button onclick="sendMessage()">Invia</button>
        <div id="response"></div>

        <script>
            function sendMessage() {
                const message = document.getElementById('message').value;

                fetch('../chatbot/chatbot.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'message=' + encodeURIComponent(message)
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('response').innerText = data.reply || data.error;
                });
            }
        </script>
    </div>-->
    <br>
    <br>
    <a  href="logout.php">Logout</a>


    
</body>
</html>

<!-- Nella stessa pagina, dopo l'eventuale tabella, deve essere presente una form che permette di inserire una nuova recensione ad un ristorante.
Per semplicità, inizialmente i ristoranti sono creati direttamente da PhpMyAdmin.
La form deve contenere i seguenti campi:
- un menù a tendina all'interno del quale sono presenti tutti i nomi dei ristoranti presenti nel database.
- un gruppo di radio button per scegliere il voto della recensione da 1 a 5
- la data e l'ID saranno gestite internamente dal database -->
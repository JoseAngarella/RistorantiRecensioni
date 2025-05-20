<?php
    include("controlloAcesso.php");
    include("connessione.php");
    if(!isset($_POST['codice_ristorante_da_visualizzare'])){
        header('Location: benvenuto.php');
        exit;
    }else{
        $codice_ristorante = $_POST['codice_ristorante_da_visualizzare'];
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvenuto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
     <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
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
                                    FROM ristorante rc LEFT JOIN recensione r on r.codice_ristorante=rc.codice WHERE rc.codice = ".$codice_ristorante."
                                    GROUP BY rc.codice ORDER BY codice");
            if(!$result){

                echo "<h1>Errore Query</h1>";

            }else if($result->num_rows<=0){
                echo "<h1>Nessun ristorante trovato</h1>";

            }else{
                $row=$result-> fetch_assoc();
                echo "<h1>Informazioni ristorante </h1>";
                
                $stampa= "<table><tr>
                            <th>Codice</th>
                            <th>Nome</th>
                            <th>Indirizzo</th>
                            <th>citta</th>
                            <th>Recensioni</th></tr>";
                $stampa.="<tr>
                        <td>".$row['codice']."</td>
                        <td>".$row['nome']."</td>
                        <td>".$row['indirizzo']."</td>
                        <td>".$row['citta']."</td>
                        <td>".$row['numr']."</td></tr>";
                

                $stampa.="</table>";
                echo $stampa;



                echo "<script> window.onload = (event) => { var mappa = L.map('mappa').setView([".$row['latitudine'].",".$row['longitudine']"], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© OpenStreetMap contributors'
                }).addTo(mappa);
                var marker = L.marker([".$row['latitudine'].", ".$row['longitudine']."]).addTo(mappa);

                marker.bindPopup('<b>".$row['nome']."</b><br>".$row['indirizzo']."').openPopup();  }; </script>";

            }
        ?>
        
        <br>
        <div class="mappa" id="mappa" ></div>        <br>
        <a href="benvenuto.php">Torna indietro</a>
       
    </div>
    <br><br>

    <div class="div_recensioni">
        <?php

            $result= $conn -> query("SELECT rc.id_utente as id, rc.voto as v, rc.data as d 
                                    FROM recensione rc JOIN ristorante rs ON rc.codice_ristorante=rs.codice 
                                    WHERE rs.codice=".$codice_ristorante);
            if(!$result){

                echo "<h1>Errore Query</h1>";

            }else if($result->num_rows<=0){
                echo "<h1>Nessuna recensione effettutata</h1>";

            }else{
                echo "<h1>Recensioni ristorante: ". $result->num_rows ." </h1>";
                
                $stampa= "<table><tr>
                            <th>ID Utente</th>
                            <th>Voto</th>
                            <th>Data</th></tr>";
                while($row=$result-> fetch_assoc()){
                    $stampa.="<tr>
                    <td>".$row['id']."</td>
                    <td>".$row['v']."</td>
                    <td>".$row['d']."</td></tr>";
                }

                $stampa.="</table>";
                echo $stampa;

            }
        ?>
       
    </div>
  

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


    <script src="../js/script.js"></script>
</body>
</html>

<!-- Nella stessa pagina, dopo l'eventuale tabella, deve essere presente una form che permette di inserire una nuova recensione ad un ristorante.
Per semplicità, inizialmente i ristoranti sono creati direttamente da PhpMyAdmin.
La form deve contenere i seguenti campi:
- un menù a tendina all'interno del quale sono presenti tutti i nomi dei ristoranti presenti nel database.
- un gruppo di radio button per scegliere il voto della recensione da 1 a 5
- la data e l'ID saranno gestite internamente dal database -->
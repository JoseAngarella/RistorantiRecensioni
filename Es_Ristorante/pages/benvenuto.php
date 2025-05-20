<?php
    include("controlloAcesso.php");
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
    <div class="div_recensioni">
        <?php

            $result= $conn -> query("SELECT rs.nome as n, rs.indirizzo as i, rc.voto as v, rc.data as d 
                                    FROM recensione rc JOIN ristorante rs ON rc.codice_ristorante=rs.codice 
                                    WHERE rc.id_utente=".$_SESSION['id_utente']);
            if(!$result){

                echo "<h1>Errore Query</h1>";

            }else if($result->num_rows<=0){
                echo "<h1>Nessuna recensione effettutate</h1>";

            }else{
                echo "<h1>Numero recensioni che hai inserito: ". $result->num_rows ." </h1>";
                
                $stampa= "<table><tr>
                            <th>Ristorante</th>
                            <th>Indirizzo</th>
                            <th>Voto</th>
                            <th>Data</th></tr>";
                while($row=$result-> fetch_assoc()){
                    $stampa.="<tr>
                    <td>".$row['n']."</td>
                    <td>".$row['i']."</td>
                    <td>".$row['v']."</td>
                    <td>".$row['d']."</td></tr>";
                }

                $stampa.="</table>";
                echo $stampa;

            }
        ?>
       
    </div>
    <br><br>
    <div class="form_inserimento">
        <h1>Visualizza Ristoranti</h1>
            <br>
            
            

            <form action="info_ristorante.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="codice_ristorante_da_visualizzare">Ristorante</label>
                    <select  name="codice_ristorante_da_visualizzare" id="codice_ristorante_da_visualizzare">
                        <?php

                            $result=$conn->query("SELECT * FROM ristorante");
                            if(!$result){
                                //messaggio di errore
                            }else if($result->num_rows<=0){
                                //si puo anche lasciare vuoto
                            }else{
                                $stampa="";
                                while($row=$result->fetch_assoc()){
                                    $stampa.="<option value='".$row['codice']."'>".$row['nome']."</option>";
                                    
                                }
                                echo $stampa;

                            }
                        
                        ?>
                    </select>
                    <button type="submit" class="btn btn-light">Visualizza</button>

                </div>
          </form>        

    </div>
    <br><br>









    <div class="form_inserimento">
        <h1>Inserisci una recensione</h1>
            <br>
            
            

            <form action="inserimentoRecensione.php" method="post">
                <div class="mb-3">
                    <label class="form-label" for="codice_ristorante">Ristorante</label>
                    <select  name="codice_ristorante" id="codice_ristorante">
                        <?php

                            $result=$conn->query("SELECT * FROM ristorante");
                            if(!$result){
                                //messaggio di errore
                            }else if($result->num_rows<=0){
                                //si puo anche lasciare vuoto
                            }else{
                                $stampa="";
                                while($row=$result->fetch_assoc()){
                                    $stampa.="<option value='".$row['codice']."'>".$row['nome']."</option>";
                                    
                                }
                                echo $stampa;

                            }
                        
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <h3>Voto</h3>
                    <label class="form-label" for="voto1">1</label>
                    <input   type="radio" name="voto" id="voto1" value="1">

                    <label class="form-label" for="voto2">2</label>
                    <input  type="radio" name="voto" id="voto2" value="2" >

                    <label class="form-label" for="voto3">3</label>
                    <input  type="radio" name="voto" id="voto3" value="3">

                    <label class="form-label" for="voto4">4</label>
                    <input  type="radio" name="voto" id="voto4" value="4">

                    <label class="form-label" for="voto5">5</label>
                    <input  type="radio" name="voto" id="voto5" value="5" checked>
                    <br>
                    <?php
                        if(isset($_SESSION["messaggio_inserimento_recensione"])){
                            echo "<p style='color:green'>".$_SESSION['messaggio_inserimento_recensione']."<p>";
                            unset($_SESSION['messaggio_inserimento_recensione']);
              
                          }
                          if(isset($_SESSION["messaggio_errore_recensione"])){
                            echo "<p style='color:red'>".$_SESSION['messaggio_errore_recensione']."<p>";
                            unset($_SESSION['messaggio_errore_recensione']);
              
                          }

                    ?>
                </div>
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
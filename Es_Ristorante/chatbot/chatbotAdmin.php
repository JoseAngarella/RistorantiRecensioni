<?php
$api_key = 'api key';
//ho testato con la mia e funziona

// Recupera il messaggio dell'utente da una richiesta POST
$user_message = $_POST['message'] ?? '';

if (!$user_message) {
    echo json_encode(['error' => 'Messaggio non fornito']);
    exit;
}

// Configura la richiesta API
$endpoint = 'https://api.openai.com/v1/chat/completions';
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $api_key,
];

$data = [
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        ['role' => 'system', 'content' => 'Sei un assistente AI esperto di ristoranti e aiuti l admin a inserire nuovi ristoranti nel database. quando ti chiedono di inserire un ristorante devi sempre fornire queste informazioni: 
             Nome, Indirizzo, Citta, latitudine e longitudine'],
        ['role' => 'user', 'content' => $user_message]
    ],
    'temperature' => 0.7,
];

// Invia la richiesta usando cURL
$ch = curl_init($endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
curl_close($ch);

// Elabora la risposta
$response_data = json_decode($response, true);

if (isset($response_data['choices'][0]['message']['content'])) {
    $reply = $response_data['choices'][0]['message']['content'];
    echo json_encode(['reply' => trim($reply)]);
} else {
    echo json_encode(['error' => 'chiave api mancante o non corretta o non funzionante']);
}
?>

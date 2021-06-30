<?php

//on prepare les headers
header('Content-Type: text/event-stream');
header("Cache-Control: no-cache");

//on instancie le message précédent à vide
$previous_meesage = "";

//tant que la connection est établie
while(!connection_aborted()) {
    //on recupere le fichier "chat"
    $data = file_get_contents("chat.txt");
    
    //on enleve le dernier retour à la ligne
    $trimmed = rtrim($data, "\n");
    
    //on le transforme en tableau
    $data_array = explode("\n", $trimmed);
    
    //on prend la dernière ligne
    $last_message = end($data_array);
    
    //on transforme en tableau (pour récupérer séparemment le message de l'auteur)
    $last_message = explode(":", $last_message);
    
    //par défaut je les mets à false
    $author = false;
    $message = false;
    
    //je set l'auteur et le message
    if(count($last_message) == 2) {
        $author = $last_message[0];
        $message = $last_message[1];
        
    }

    //si on a un message, un auteur et que le message est un "nouveau" message
    if($message && $author && $message != $previous_message){
        //on crée notre SSE avec comme clefs author et message
         echo "data: ". json_encode(array('author' => $author, 'message' => $message)) ."\n\n";
        
        //on mets à jour le last message
        $previous_message = $message;
        
    } 
    
    //vidage du buffer
    ob_end_flush();
    flush();
    
    //on attends 500ms
    usleep(500);
}
?>
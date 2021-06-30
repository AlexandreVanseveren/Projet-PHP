<?php
session_start();

//on mets à vide le message par défaut
$text = "";
echo'hello';
//si on a du post et une session
if(isset($_POST['text']) && isset($_SESSION['uname'])) {
    //ICI QU ON ENREGISTRE LE MSG
	$messageDAO = new MessageDAO;
	$messageDAO->save($_POST['text'],$_COOKIE['session_token']);
    //on prépare le "message" au format user:text
    $text = $_SESSION['uname'].":".$_POST['text']."\n";
    $handle = fopen("../chat.txt", "a");
    fwrite($handle, $text);
    
    //on ferme le fichier et on exit le script
    echo "success";
    fclose($handle);
    exit();
}

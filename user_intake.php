<?php
session_start();
//on enregistre le time actuel
$_SESSION['new'] = time();


//si le délai entre 2 requêtes est trop rapide, on abandonne le script
if(isset($_SESSION['old']) && $_SESSION['old'] > $_SESSION['new'] - 1) {
    echo "too fast";
    exit();
}

//sinon on mets à jour la new req
$_SESSION['old'] = $_SESSION['new'];


//vient vià l'intervalle de keepAlive
if(isset($_POST['alive'])) {
    $data_array = get_as_array("users.txt");
    $users = generate_user_list($data_array, $_POST['alive']);
    $userlist = $users['userlist'];
    put_content($userlist, "users.txt");
    
    //on renvoie les utilisateurs au format json
    echo json_encode($userlist);
    exit();
}
//est une nouvelle connection    
if (isset($_POST['new'])) {
    $_SESSION['uname'] = $_POST['new'];
    
    $data_array = get_as_array("users.txt");
    $reconnected = false;
    $users = generate_user_list($data_array, $_POST['new']);
    $userlist = $users['userlist'];
    if(!$userlist['reconnected']) {
        $time = time();
        $newline = array('name'=>$_POST['new'], 'ts' => $time);
        $newline['stream'] = $newline['name'].','.$newline['ts']."\n";
        array_push($userlist, $newline);
    }
    put_content($userlist, "users.txt");
    echo json_encode($userlist);
    exit();
}

//s'occupe d'écrire dans le fichiers les utilisateurs
function put_content($array, $file) {
    $text = '';
    foreach($array as $a) {
        if(isset($a) && isset($a['stream'])) {
             $text .= $a['stream'];
        }
    }
    $handle = fopen("users.txt", "w");
    fwrite($handle, $text);
    fclose($handle);
}


//récupérer les infos du fichier sous forme de tableau
function get_as_array($file) {
    $data = file_get_contents($file);
    $trimmed = rtrim($data, "\n");
    return explode("\n", $trimmed);
}

//genere la liste des users ainsi qu'un booléen reconnected si jamais l'utilisateur existait déjà mais arrive quand meme via la route new
function generate_user_list($data_array, $current) {
    $userlist = array();
    $reconnected = false;
    
    
    foreach($data_array as $data) {
        $line = explode(',', $data);
        if(count($line) == 2 ) {
            $newline = array('name'=>$line[0], 'ts' => $line[1]);
            if ($newline['name'] == $current) {
                //c'est celui qui a émi la requete, on update son TS
                $newline['ts'] = time();
                
                //le champ stream facilite l'enregistrement dans le fichier txt
                $newline['stream'] = $newline['name'].','.$newline['ts']."\n";
                array_push($userlist, $newline);
                $reconnected = true;
            } else if((time() - 5) < intval($newline['ts'])) {
                //on le garde car pas encore trop vieux ( < 5sec depuis son dernier alive)
                $newline['stream'] = $newline['name'].','.$newline['ts']."\n";
                array_push($userlist, $newline);
            } 
        }
    }
    return array('userlist' => $userlist, 'reconnected' => $reconnected);
}



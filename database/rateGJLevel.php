<?php
include "lib/connection.php";
require "lib/lib.php";
include "../prefs.php";
$lib = new GDPSLib();
if(isset($_POST["secret"]) AND isset($_POST["levelID"]) AND isset($_POST["rating"])){
    if($_POST["secret"] != "Wmfd2893gb7"){
        exit("-1");
    }
    $query = $db->prepare("SELECT count(*) FROM rate_log WHERE ip = :ip AND levelID = :levelid");
    $query->execute([
        ":ip" => $lib->getIP(), 
        ":levelid" => $_POST["levelID"]
    ]);
    $count = $query->fetchColumn();

    if($count == 0){
        $query = $db->prepare("INSERT INTO rate_log (levelID, rating, IP) VALUES (:levelid, :rating, :ip)");
        $query->execute([
            ":levelid" => $_POST["levelID"],
            ":rating" => $_POST["rating"],
            ':ip' => $lib->getIP()
        ]);
        echo 1;
    }else{
        echo -1;
    }
    if($enable_player_rates){
        $query = $db->prepare("SELECT rating, COUNT(rating) FROM rate_log WHERE levelID = :levelid GROUP BY rating");
        $query->execute([
            ":levelid" => $_POST["levelID"]
        ]);
        $easy = 0; $normal = 0; $hard = 0; $harder = 0; $insane = 0;
        $count = $query->fetchAll();
        for ($i = 0; $i < 5; $i++){
            if (isset($count[$i])){
                switch ($count[$i]["rating"]){
                    case 1:
                        $easy = $count[$i][1];
                    break;
                    case 2:
                        $normal = $count[$i][1];
                    break;
                    case 3:
                        $hard = $count[$i][1];
                    break;
                    case 4:
                        $harder = $count[$i][1];
                    break;
                    case 5:
                        $insane = $count[$i][1];
                    break;
                }
            }
        }
        $array = [
            "10" => $easy,
            "20" => $normal,
            "30" => $hard,
            "40" => $harder,
            "50" => $insane ];
        $max = max($array);
        foreach($array as $key => $val) {    
            if($val === $max) $b[] = $key;
        }
        if($b[0] > $rating){
            $query = $db->prepare("UPDATE levels SET difficultyDenominator = 10, difficultyNumerator = :diff WHERE levelID = :levelID");
            $query->execute([
                ":diff" => $b[0],
                ":levelID" => $_POST["levelID"]
            ]);
        }
    }
}
?>
<?php
include "lib/connection.php";
if(isset($_POST["levelID"]) AND isset($_POST["secret"])){
    $levelID = $_POST["levelID"];
    $secret = $_POST["secret"];
    if($secret != "Wmfd2893gb7"){
        exit("-1");
    }
    $query = $db->prepare("SELECT * FROM levels WHERE levelID = :levelID");
    $query->execute([":levelID" => $levelID]);
    $levelinfo = $query->fetchAll();
    //print_r($levelinfo);
    echo "1:".$levelID.":2:".$levelinfo[0]["levelName"].":3:".$levelinfo[0]["levelDesc"].":4:".$levelinfo[0]["levelString"].":5:".$levelinfo[0]["levelVersion"].":6:".$levelinfo[0]["userID"].":8:".$levelinfo[0]["difficultyDenominator"].":9:".$levelinfo[0]["difficultyNumerator"].":10:".$levelinfo[0]["downloads"].":11:0:12:".$levelinfo[0]["audioTrack"].":13:".$levelinfo[0]["gameVersion"].":14:".$levelinfo[0]["likes"].":15:".$levelinfo[0]["levelLength"];
}
?>

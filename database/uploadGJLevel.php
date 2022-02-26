<?php
include "lib/connection.php";
require "lib/lib.php";
$lib = new GDPSLib();
if(isset($_POST["udid"]) AND isset($_POST["userName"]) AND isset($_POST["levelName"]) AND isset($_POST["levelDesc"]) AND isset($_POST["levelString"]) AND isset($_POST["levelVersion"]) AND isset($_POST["levelLength"]) AND isset($_POST["audioTrack"]) AND isset($_POST["gameVersion"])){

    $udid = $_POST["udid"];
    $userName = $_POST["userName"];
    $secret = $_POST["secret"];
    $levelID = $_POST["levelID"];
    $levelName = $_POST["levelName"];
    $levelDesc = $_POST["levelDesc"];
    $levelString = $_POST["levelString"];
    $levelVersion = $_POST["levelVersion"];
    $levelLength = $_POST["levelLength"];
    $audioTrack = $_POST["audioTrack"];
    $gameVersion = $_POST["gameVersion"];
    if($secret != 'Wmfd2893gb7'){
        exit("-1");
    }


$query = $db->prepare("SELECT count(*) FROM users WHERE udid = :udid");
$query->execute([':udid' => $udid]);
$count = $query->fetchColumn();
if($count == 0){
    $query = $db->prepare("INSERT INTO users (udid, userName, ip) VALUES (:udid, :userName, :ip)");
    $query->execute([":udid" => $udid, ":userName" => $userName, ":ip" => $lib->getIP()]);
}

$query = $db->prepare("SELECT userID FROM users WHERE udid = :udid");
$query->execute([':udid' => $udid]);
$userID = $query->fetchColumn();

$query = $db->prepare("INSERT INTO levels (userID, levelName, levelDesc, levelString, levelVersion, levelLength, audioTrack, gameVersion, timestamp) VALUES (:userID, :levelName, :levelDesc, :levelString, :levelVersion, :levelLength, :audioTrack, :gameVersion, :timestamp)");
$query->execute([":userID" => $userID, ":levelName" => $levelName, ":levelDesc" => $levelDesc, ":levelString" => $levelString, ":levelVersion" => $levelVersion, ":levelLength" => $levelLength, ":audioTrack" => $audioTrack, ":gameVersion" => $gameVersion, ":timestamp" => time()]);
echo $db->lastInsertId();
}else{
    echo "-1";
}
?>
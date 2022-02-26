<?php
include "lib/connection.php";
require "lib/lib.php";
$lib = new GDPSLib();
if(isset($_POST["secret"]) AND isset($_POST["levelID"])){
    if($_POST["secret"] != "Wmfd2893gb7"){
        exit("-1");
    }
    $query = $db->prepare("SELECT count(*) FROM likes_log WHERE ip = :ip AND levelID = :levelid");
    $query->execute([
        ":ip" => $lib, 
        ":levelid" => $_POST["levelID"]
    ]);
    $count = $query->fetchColumn();

    if($count == 0){
        $query = $db->prepare("UPDATE levels SET likes = likes+1 WHERE levelID = :levelid");
        $query->execute([
            ':levelID' => $_POST["levelID"]
        ]);
        $query = $db->prepare("INSERT ip, levelID INTO likes_log VALUES (:ip, :levelid)");
        $query->execute([
            ':ip' => $lib->getIP(), 
            ':levelID' => $_POST["levelID"]
        ]);
    }else{
        echo -1;
    }
}
?>
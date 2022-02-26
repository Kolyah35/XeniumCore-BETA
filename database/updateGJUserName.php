<?php
include "lib/connection.php";

if(isset($_POST["udid"]) AND isset($_POST["userName"]) AND isset($_POST["secret"])){
    if($_POST["secret"] != "Wmfd2893gb7"){
        exit("-1");
    }
    $query = $db->prepare("SELECT count(*) FROM users WHERE udid = :udid");
    $query->execute([':udid' => $udid]);
    $count = $query->fetchColumn();
    if($count == 0){
        $query = $db->prepare("INSERT INTO users (udid, userName, ip) VALUES (:udid, :userName, :ip)");
        $query->execute([":udid" => $udid, ":userName" => $userName, ":ip" => $lib->getIP()]);
    }

    $query = $db->prepare("UPDATE users SET userName = :username WHERE udid = :udid");
    $query->execute([':username' => $userName, ':udid' => $udid]);
    echo 1;
}
?>
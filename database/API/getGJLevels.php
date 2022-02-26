<?php
include "../lib/connection.php";
require "../lib/lib.php";
$lib = new GDPSLib();
//Set default values
    if(!isset($_GET["type"])){
        $type = 2;
    }else{
        $type = $_GET["type"];
    }
    if(!isset($_GET["str"])){
        $str = "";
    }else{
        $str = $_GET["str"];
    }
    if(!isset($_GET["diff"])){
        $diff = "-";
    }else{
        $diff = $_GET["diff"];
    }
    if(!isset($_GET["len"])){
        $length = "-";
    }else{
        $length = $_GET["len"];
    }
    if(!isset($_GET["page"])){
        $page = 0;
    }else{
        $page = $_GET["page"];
    }
    if(!isset($_GET["limit"])){
        $limit = 10;
    }else{
        $limit = $_GET["limit"];
    }
    $query = "";
$querys = "SELECT * FROM levels ";
if ($diff != "-" OR $length != "-" OR $type == 6){
    $query = "WHERE ";
}
if($diff != "-"){
    $diffarr = explode(",", $diff);
    if(array_key_exists(0, $diffarr)){
        $query .= "difficultyNumerator = ".$diffarr[0] * 10;
    }
    if(array_key_exists(1, $diffarr)){
        $query .= " OR difficultyNumerator = ".$diffarr[1] * 10;
    }
    if(array_key_exists(2, $diffarr)){
        $query .= " OR difficultyNumerator = ".$diffarr[2] * 10;
    }
    if(array_key_exists(3, $diffarr)){
        $query .= " OR difficultyNumerator = ".$diffarr[3] * 10;
    }
    if(array_key_exists(4, $diffarr)){
        $query .= " OR difficultyNumerator = ".$diffarr[4] * 10;
    }
    if(array_key_exists(5, $diffarr)){
        $query .= " OR difficultyNumerator = ".$diffarr[5] * 10;
    }
}
    if($length != "-"){
        $lenarr = explode(",", $length);
        if(array_key_exists(0, $lenarr)){
            if ($diff != "-"){
                $query .= " AND levelLength = ".$lenarr[0];
            }else{
                $query .= "levelLength = ".$lenarr[0];
            }
        }
        if(array_key_exists(1, $lenarr)){
            $query .= " OR levelLength = ".$lenarr[1];
        }
        if(array_key_exists(2, $lenarr)){
            $query .= " OR levelLength = ".$lenarr[2];
        }
        if(array_key_exists(3, $lenarr)){
            $query .= " OR levelLength = ".$lenarr[3];
        }
        if(array_key_exists(4, $lenarr)){
            $query .= " OR levelLength = ".$lenarr[4];
        }
    }
    switch($type){
        case 0:
            if($length != "-" AND $diff != "-"){
                $query .= " AND levelName LIKE '%".$str."%' ORDER BY likes DESC";
            }else{
                $query .= "levelName LIKE '%".$str."%' ORDER BY likes DESC";
            }
        break;
        case 1:
            $query .= " ORDER BY downloads DESC";
        break;
        case 2:
            $query .= " ORDER BY likes DESC";
        break;
        case 3:
            $week = time() - (60*60*24*7);
            if($length != "-" AND $diff != "-"){
                $query .= " AND timestamp > ".$week." ORDER BY likes DESC";
            }else{
                $query .= "timestamp > ".$week." ORDER BY likes DESC";
            }
        break;
        case 4:
            $query .= " ORDER BY timestamp DESC";
        break;
        case 5:
            if($length != "-" AND $diff != "-"){
                $query .= " AND userID = ".$str." ORDER BY timestamp DESC";
            }else{
                $query .= "userID = ".$str." ORDER BY timestamp DESC";
            }
        break;
        case 6:
            if($length != "-" AND $diff != "-"){
                $query .= " AND difficultyNumerator != 0";
            }else{
                $query .= "difficultyNumerator != 0";
            }
        break;
    }
    $query .= " LIMIT ".$limit." OFFSET ".$limit * $page;
    $result = $db->prepare($querys.$query);
    $result->execute();
    $levels = $result->fetchAll();;
    $levelarray = [];
    //print_r($levels);
    for($i = 0; $i < $limit; $i++){
        if(array_key_exists($i, $levels)){
            $userq = $db->prepare("SELECT userName FROM users WHERE userID = :userID");
            $userq->execute([":userID" => $levels[$i]["userID"]]);
            $userName = $userq->fetchColumn();

            if($levels[$i]["difficultyDenominator"] == 0){ $isRated = false; }else{ $isRated = true; }
            $difficulty = $lib->getDifficulty($levels[$i]["difficultyNumerator"]);
            $songName = $lib->getAudiotrack($levels[$i]["audioTrack"]);
            $levelarray = array_merge($levelarray, 
                [
                    "_".$i => [
                        "levelID" => $levels[$i]["levelID"],
                        "levelName" => $levels[$i]["levelName"],
                        "levelDesc" => $levels[$i]["levelDesc"],
                        "levelVersion" => $levels[$i]["levelVersion"],
                        "userID" => $levels[$i]["userID"],
                        "userName" => $userName,
                        "isRated" => $isRated,
                        "difficulty" => $difficulty,
                        "difficultyNumerator" => $levels[$i]["difficultyNumerator"],
                        "downloads" => $levels[$i]["downloads"],
                        "songID" => $levels[$i]["audioTrack"],
                        "songName" => $songName,
                        "gameVersion" => $levels[$i]["gameVersion"],
                        "likes" => $levels[$i]["likes"],
                        "levelLength" => $levels[$i]["levelLength"]
                    ]
                ]
            );
           
        }
    }
    $countq = $db->prepare("SELECT count(*) FROM levels ".$query);
    $countq->execute();
    $count = $countq->fetchColumn();
    $levelarray = array_merge($levelarray, ["count" => $count, "page" => $page, "sqlcode" => $querys.$query]);
    echo json_encode($levelarray);
    //echo $levelstring."#".$userstring."#".$count.":".$page.":10";
?>
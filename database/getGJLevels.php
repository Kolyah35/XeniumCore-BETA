<?php
include "lib/connection.php";
if(isset($_POST["secret"]) AND isset($_POST["type"]) AND isset($_POST["str"]) AND isset($_POST["diff"]) AND isset($_POST["len"]) AND isset($_POST["page"])){
    $secret = $_POST["secret"];
    $type = $_POST["type"];
    $str = $_POST["str"];
    $diff = $_POST["diff"];
    $length = $_POST["len"];
    $page = $_POST["page"];
    $query = "";
    if($secret != "Wmfd2893gb7"){
        exit("-1");
    }
    if(!empty($_POST["rawarray"])){
        if($_POST["rawarray"] != 0){
            $rawarray = true;
        }else{
            $rawarray = false;
        }
    }
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
    $query .= " LIMIT 10 OFFSET ".$page * 10;
    $result = $db->prepare($querys.$query);
    $result->execute();
    $levels = $result->fetchAll();
    $levelstring = "";
    $userstring = "";
    for($i = 0; $i < 10; $i++){
        if(array_key_exists($i, $levels)){
            $levelstring .= "1:".$levels[$i]["levelID"].":2:".$levels[$i]["levelName"].":3:".$levels[$i]["levelDesc"].":5:".$levels[$i]["levelVersion"].":6:".$levels[$i]["userID"].":8:".$levels[$i]["difficultyDenominator"].":9:".$levels[$i]["difficultyNumerator"].":10:".$levels[$i]["downloads"].":12:".$levels[$i]["audioTrack"].":13:".$levels[$i]["gameVersion"].":14:".$levels[$i]["likes"].":15:".$levels[$i]["levelLength"]."|";
            $userq = $db->prepare("SELECT userName FROM users WHERE userID = :userID");
            $userq->execute([":userID" => $levels[$i]["userID"]]);
            $userName = $userq->fetchColumn();
            $userstring .= $levels[$i]["userID"].":".$userName."|";
        }
    }
    $countq = $db->prepare("SELECT count(*) FROM levels ".$query);
    $countq->execute();
    $count = $countq->fetchColumn();
    if($rawarray){
        print_r($levels);
    }else{
        echo $levelstring."#".$userstring."#".$count.":".$page.":10";
    }
    //type 0: Search, 1: Most Downloaded, 2: Most Liked, 3: trending, 4: Most recent  6: Featured
    //diff: -: any, 0: NA, 1: Easy, 2: Normal, 3: hard, 4: Harder, 5: Insane
    //length: -: any, 0: Tiny, 1: Short, 2: Medium, 3: Long
    //1: levelID 2:LevelName 3: desc 5:level version 6: player ID 8: rated or not 9: level difficulty 10: downloads 12: song 13: gameVersion 14: likes 15: length
    //#userID:userName
    //#totalcount:page:10(limit)
}
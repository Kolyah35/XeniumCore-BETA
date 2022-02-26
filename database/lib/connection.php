<?php
//error_reporting(0);
//connection.php from StrelokCore
$port = 3306;
$servername = "sql2.7m.pl";
$username = "kolyah35_gdmsrestore";
$password = "j7r54i5z39";
$dbname = "kolyah35_gdmsrestore";
@header('Content-Type: text/html; charset=utf-8');
if(!isset($port)) $post = 3306;

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	$ms = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	$ms = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
	$ms = $_SERVER['REMOTE_ADDR'];
}

$mysqli = new mysqli($servername, $username, $password, $dbname);
try {
    $db = new PDO("mysql:host=".$servername.";port=".$port.";dbname=".$dbname, $username, $password, array(
    PDO::ATTR_PERSISTENT => true));

    // set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $ban = $db->prepare("SELECT count(DISTINCT IP) FROM bannedips WHERE IP = :ip");
    $ban->execute([':ip' => $ms]);
    $count = $ban->fetchColumn();
    if($count > 0){
        echo "Вы забанены по IP!<br>You banned IP!";
        exit('403');
    }
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}
?>
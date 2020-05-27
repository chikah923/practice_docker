<?php
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

$pdo = new PDO('mysql:host=mysql2208.xserver.jp;dbname=cy2tool_tooldb;charset=utf8','cy2tool_tooldb','ueki1695',
                       array(PDO::ATTR_EMULATE_PREPARES => false));
$stmt = '';
$sql = "SELECT * FROM channelmaster WHERE status= '0'";
$stmt = $pdo->prepare($sql);
$stmt->execute();

foreach ($stmt as $row) {
    $userId = $row['userId'];
    $chId = $row['chId'];
    $result = getInfoByChannelId($chId);
    $viewCount = $result['viewCount'];
    $crCount = $result['crCount'];
    $onedayViewCount = 0;
    $onedayCrCount = 0;
    $date = new DateTime();
    
    $sql2 = "SELECT * FROM channelinfo WHERE chId = :chId AND date < :date ORDER BY date DESC LIMIT 1";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array(':chId' => $chId, ':date' => $date->format('Y-m-d')));
    foreach ($stmt2 as $row2){
        $onedayViewCount = $viewCount - $row2['viewCount'];
        $onedayCrCount = $crCount - $row2['crCount'];
    }
    
    $sql3 = "INSERT INTO channelinfo (userId, chId, date, viewCount, crCount, onedayViewCount, onedayCrCount) VALUES (:userId, :chId, :date, :viewCount, :crCount, :onedayViewCount, :onedayCrCount)";
    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute(array(':userId' => $userId, ':chId' => $chId, ':date' => $date->format('Y-m-d'), ':viewCount' => $viewCount, ':crCount' => $crCount, ':onedayViewCount' => $onedayViewCount, ':onedayCrCount' => $onedayCrCount));
   
}

function getInfoByChannelId($cid){
    $base_url = "https://www.googleapis.com/youtube/v3/channels?";
    $key = "&key=AIzaSyABUOIzwMDeUd6ELEzzhgj2Qtia6DMFXcg";
    $prm = "part=contentDetails,snippet,statistics,brandingSettings&id=".$cid;
    $response = file_get_contents($base_url.$prm.$key);
    $result = json_decode($response,true);
    $viewCount = $result['items'][0]['statistics']['viewCount'];
    $crCount = $result['items'][0]['statistics']['subscriberCount'];
    return array('viewCount'=>$viewCount, 'crCount'=>$crCount); 
}

?>
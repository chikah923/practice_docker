<?php
//ini_set("display_errors", On);
//error_reporting(E_ALL);
session_start();
if (!isset($_SESSION["userId"])){
    header("Location: login.php");
    exit;
}
$parentUserId = $_SESSION["userId"];
$updateUserId = $_SESSION["userId"];

include("./func_db.php");
$_connect=initDB();
$pdo = new PDO(
    'mysql:host='.$_connect['host'].';dbname='.$_connect['db'].';charset=utf8',$_connect['user'],$_connect['pass']
    ,array(PDO::ATTR_EMULATE_PREPARES => false)
);

$stmt = '';
$operation = $_POST["oper"];
$data = '';

if($operation=="deleteUser"){
    $userId = $_POST["operUserId"];
    $sql = "DELETE FROM user WHERE userId = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($userId));
    $data = 'success';

	header('Content-Type: application/json');
	echo json_encode(compact('data'));

}else if($operation=="addUser"){
    $userId = $_POST["operUserId"];
    $password = $_POST["operPassword"];
    $authority = $_POST["operAuthority"];
    $etc = $_POST["operEtc"];

    $date = new DateTime();
    $sql = "INSERT INTO user (userId, password, authority, parentUserId, status, createTime, updateTime, updateUserId, etc) VALUES (:userId, :password, :authority, :parentUserId, '0', :createTime, :updateTime, :updateUserId, :etc )";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':userId' => $userId, ':password' => $password, ':authority' => $authority, ':parentUserId' => $parentUserId, ':createTime' => $date->format('Y-m-d'), ':updateTime' => $date->format('Y-m-d'), ':updateUserId' => $parentUserId, ':etc' => $etc ));
    $data = 'success';

	header('Content-Type: application/json');
	echo json_encode(compact('data'));

}else if($operation=="updateUser"){
    $userId = $_POST["operUserId"];
    $password = $_POST["operPassword"];
    $etc = $_POST["operEtc"];

    $parentSelect = ( isset($_POST["operParentUserId"]) )? $_POST["operParentUserId"] : "" ;
    if($parentSelect<>""){
        $parentUserId = $parentSelect;
    }

    $date = new DateTime();
    $sql = "UPDATE user set password = :password, updateTime= :updateTime, updateUserId = :updateUserId, parentUserId= :parentUserId, etc = :etc WHERE userId = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($password, $date->format('Y-m-d'), $updateUserId, $parentUserId, $etc, $userId ));
    $data = 'success';

	header('Content-Type: application/json');
	echo json_encode(compact('data'));

}else if($operation=="analytics"){

    $chId = $_POST["chId"];
    $content = $_POST["content"];
    $days = $_POST["days"];
    $sql = "SELECT * FROM channelinfo WHERE userId = :userId AND chId = :chId";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':userId' => $updateUserId, ':chId' => $chId));
    $date = new DateTime();
    $dataPoints1 = array();
    $dataPoints2 = array();
    $milliSecond = strtotime($date->format('Y-m-d'))*1000;
    if($days == '1'){
    //7日間
        for($count =6;$count>=0;$count--){
            $flag = true;
            $dataPoints1[] = array("x" => $milliSecond-86400000*$count, "y" => 0);
            $dataPoints2[] = array("x" => $milliSecond-86400000*$count, "y" => 0);
        }
        foreach ($stmt as $row){
            foreach($dataPoints1 as $key => $data) {
                if ($data['x'] == strtotime($row['date'])*1000) {
                    if($content == '1'){
                        $dataPoints1[$key]['y']=intval($row['viewCount']);
                        $dataPoints2[$key]['y']=intval($row['crCount']);
                    }else if($content == '2'){
                        $dataPoints1[$key]['y']=intval($row['onedayViewCount']);
                        $dataPoints2[$key]['y']=intval($row['onedayCrCount']);
                    }
                }
                continue;
            }
        }
    }else if($days == '2'){
    //28日間
        for($count =27;$count>=0;$count--){
            $dataPoints1[] = array("x" => $milliSecond-86400000*$count, "y" => 0);
            $dataPoints2[] = array("x" => $milliSecond-86400000*$count, "y" => 0);
        }
        foreach ($stmt as $row){
            foreach($dataPoints1 as $key => $data) {
                if ($data['x'] == strtotime($row['date'])*1000) {
                    if($content == '1'){
                        $dataPoints1[$key]['y']=intval($row['viewCount']);
                        $dataPoints2[$key]['y']=intval($row['crCount']);
                    }else if($content == '2'){
                        $dataPoints1[$key]['y']=intval($row['onedayViewCount']);
                        $dataPoints2[$key]['y']=intval($row['onedayCrCount']);
                    }
                }
                continue;
            }
        }
    }else if($days == '3'){
    //90日間
        for($count =89;$count>=0;$count--){
            $dataPoints1[] = array("x" => $milliSecond-86400000*$count, "y" => 0);
            $dataPoints2[] = array("x" => $milliSecond-86400000*$count, "y" => 0);
        }
        foreach ($stmt as $row){
            foreach($dataPoints1 as $key => $data) {
                if ($data['x'] == strtotime($row['date'])*1000) {
                    if($content == '1'){
                        $dataPoints1[$key]['y']=intval($row['viewCount']);
                        $dataPoints2[$key]['y']=intval($row['crCount']);
                    }else if($content == '2'){
                        $dataPoints1[$key]['y']=intval($row['onedayViewCount']);
                        $dataPoints2[$key]['y']=intval($row['onedayCrCount']);
                    }
                }
                continue;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode(array('dataPoints1'=>$dataPoints1,'dataPoints2'=>$dataPoints2));

}else if($operation=="addChannel"){
    $chId = $_POST["chId"];
    $chName = $_POST["chName"];
    $sql2 = "SELECT * FROM channelmaster WHERE userId = :userId AND chId = :chId AND status='1'";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array(':userId' => $updateUserId, ':chId' => $chId));
    if(count($stmt2->fetchAll())>0){
        $sql = "UPDATE channelmaster set status = '0' WHERE userId = :userId AND chId = :chId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':userId' => $updateUserId, ':chId' => $chId));
    }else{
        $sql = "INSERT INTO channelmaster (userId, chId, chName, status) VALUES (:userId, :chId, :chName,'0')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':userId' => $updateUserId, ':chId' => $chId, ':chName' => $chName));
    }
    $data = 'success';
    header('Content-Type: application/json');
    echo json_encode(compact('data'));

}else if($operation=="deleteChannel"){
    $chIdList = json_decode($_POST["chIdList"]);
    foreach($chIdList as $chId) {
        $sql = "UPDATE channelmaster set status = '1' WHERE userId = :userId AND chId = :chId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(':userId' => $updateUserId,':chId' => $chId));
    }
    $data = 'success';
    header('Content-Type: application/json');
    echo json_encode(compact('data'));
}


?>
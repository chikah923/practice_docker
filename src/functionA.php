<?php
//ini_set("display_errors", On);
//error_reporting(E_ALL);
session_start();

    if (!isset($_SESSION["userId"])){
        header("Location: login.php");
        exit;
    }
	include("./func_db.php");
    include("./func_toolC.php");

    //	foreach( $_GET as $key =>$val ){
    //		$$key=$val;
    //		// echo $key."=".$val."<br />";
    //	}

	$parentUserId = $_SESSION["userId"];
	$updateUserId = $_SESSION["userId"];

// $stmt = '';
$operation = $_GET["oper"];
// $data = '';
// echo $operation."<br/>";

switch($operation){
case "ADD":
    $tmp=$tmp1=array();
    $userId = $_GET["operUserId"];
    $channelTitle= $_GET["operTitle"];
    $channelUrl = $_GET["operData"];

    // $date = new DateTime();
    $sSQL = "INSERT INTO t_channel_list ( userID,channelTitle,delFlg ) VALUES ( '".$userId."','".$channelTitle."',0 )";
	$rsTmp=GetRS($sSQL);
    $rsTmp=null;

    $sSQL = "SELECT max(channelID) as maxNO FROM t_channel_list ";//追加登録したchannelIDを取得
	$rsTmp=GetRS($sSQL);
    $result = $rsTmp->fetch_assoc();
    $cID=$result['maxNO'];//incrementしたIDを取得
    $rsTmp=null;

    $ii=1;

    foreach( $channelUrl as $val ){
        $sSQL2 = "INSERT INTO t_channel_detail ( channelID,channelUrlNo,channelUrl ) VALUES ( ".$cID.",".$ii.",'".$val."' )";
		$rsTmp=GetRS($sSQL2);
        // echo $sSQL2;
        $ii++;
    }
    $data = array(
        'id'=> $cID
        ,'name' => $channelTitle
    );
    // echo $cID.":".$sSQL;
	header('Content-Type: application/json');
	echo json_encode(compact('data'));
    break;

case "UP":
    $tmp=$tmp1=array();
    $userId = $_GET["operUserId"];
    $channelTitle= $_GET["operTitle"];
    $channelUrl = $_GET["operData"];
    $cID = $_GET["operID"];

    //タイトルの更新
    $sSQL = "UPDATE t_channel_list set channelTitle='".$channelTitle."' where channelID=".$cID;
    $rsTmp=GetRS($sSQL);
    $rsTmp=null;

    //登録リストはいったん削除（リスト数の増減を考慮）
    $sSQL2 = "DELETE FROM t_channel_detail WHERE channelID=".$cID;
    $rsTmp=GetRS($sSQL2);
    $rsTmp=null;

    $ii=1;
    foreach( $channelUrl as $val ){
        $sSQL2 = "INSERT INTO t_channel_detail ( channelID,channelUrlNo,channelUrl ) VALUES ( ".$cID.",".$ii.",'".$val."' )";
        $sqlTmp.=$sSQL2.":";
        $rsTmp=GetRS($sSQL2);
        // echo $sSQL2;
        $ii++;
    }
    $data = array(
        'id'=> $cID
        ,'name' => $channelTitle
    );
    header('Content-Type: application/json');
    echo json_encode(compact('data'));
    break;
case "DEL":
   $cID = $_GET["operID"];

    //登録リスト削除
    $sSQL2 = "DELETE FROM t_channel_list WHERE channelID=".$cID;
    $rsTmp=GetRS($sSQL2);
    $rsTmp=null;

    //登録リスト削除
    $sSQL2 = "DELETE FROM t_channel_detail WHERE channelID=".$cID;
    $rsTmp=GetRS($sSQL2);
    $rsTmp=null;
    $data = array(
        'id'=> $cID
        ,'name' => $channelTitle
    );
    header('Content-Type: application/json');
    echo json_encode(compact('data'));
    break;
case "SELECT":
    $data=$tmp=array();
    $channelID= $_GET["operID"];//選択したチャンネルリスト
    //channelIDの詳細を取得
    $sSQL = "SELECT * FROM t_channel_list where channelID=".$channelID."";
    $rsTmp=GetRS($sSQL);
    $result = $rsTmp->fetch_assoc();
    $channelTitle=$result['channelTitle'];
    $rsTmp=null;

    $sSQL = "SELECT * FROM t_channel_detail where channelID=".$channelID." order by channelUrlNo";
    $rsTmp=GetRS($sSQL);
    while($result = $rsTmp->fetch_assoc()){
        $tmp[]=$result["channelUrl"];
    }
    $rsTmp=null;

    $data = array(
        'name' => $channelTitle
        ,'url' => $tmp
    );
    header('Content-Type: application/json');
    echo json_encode(compact('data'));
    break;
}
?>
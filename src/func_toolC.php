<?php
	date_default_timezone_set('Asia/Tokyo');

	define("API_KEY", "AIzaSyABUOIzwMDeUd6ELEzzhgj2Qtia6DMFXcg");//APIkey（現状固定）
	define("RPP",50);//最大取得数（ページング処理を用いてすべてのデータ取得を行うか？
	// define("CHANNEL_ID","UCGtWs5wx1EpLCehMxAQqxFw");//チャンネルID（debug）

//=======================================================================
//YahooAPI 形態素解析
//=======================================================================
function wordCheck($word){

	$YahooURL="http://jlp.yahooapis.jp/MAService/V1/parse";
	$YahooAPI="dj0zaiZpPUw4Mm1BbU1ZTkczbCZzPWNvbnN1bWVyc2VjcmV0Jng9MzQ-";//後にYahooAPIのkey発行した際には変更してください。

	$params = array(
		 "sentence" => $word
		,"results" => "uniq"
		,"filter" => "1|2|3|4|5|6|7|8|9|10"
	);

	$ch = curl_init($YahooURL);
	curl_setopt_array($ch, array(
		CURLOPT_POST => true,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_USERAGENT => "Yahoo AppID: ".$YahooAPI,
		CURLOPT_POSTFIELDS => http_build_query($params),
	));
	$fpult = curl_exec($ch);
	curl_close($ch);

	$xml = new SimpleXMLElement($fpult);

	return $xml;
}

//=======================================================================
// GetRS:レコードセット(mysqli差し替え版)
//	sSQL:SQL文字列
//=======================================================================
function GetRS($sSQL,$debug=false) {

	//DB接続設定
	$_connect=initDB();
	$mysqli = new mysqli($_connect['host'], $_connect['user'], $_connect['pass'],$_connect['db']);

	if($mysqli->connect_error) {
		error_log($mysqli->connect_error);
		exit('データベースに接続できませんでした。');
	}else{
		// var_dump($mysqli);
		$mysqli->set_charset("utf8");
	}

	$sSQL=strSQLchk($sSQL);
	$res = $mysqli->query($sSQL);//SQLを実行
	if(!$res){
		error_log($mysqli->error);
		echo 'SQLがおかしいようです。';
		echo "SQL=<span  style='color:red;font-weight:bold;'>".$sSQL."<span><br/>";
	}
	return $res;
}
//=======================================================================
// outWordRS:where句から余計な文字を削除する
//	sWhere（検索文字列）
//=======================================================================
function strSQLchk($sSQL){
	$sSQL-htmlspecialchars($sSQL);
	$chk=array(";");
	$sSQL=str_replace($chk,"",$sSQL);
	return $sSQL;
}

//=======================================================================
//Nz:データ変換
//	$sWord：引渡しデータ
//=======================================================================
Function NZ($sWord,$strWord){
	if ( is_null($sWord) || $sWord=="") {
		return $strWord;
	} else {
		return $sWord;
	}
}

//=======================================================================
//URLから内容を取得（jsonデータ取得する為）
//=======================================================================
function cGet_contents( $url, $timeout = 15 ){
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_HEADER, false );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
	$result = curl_exec( $ch );
	curl_close( $ch );
	return $result;
}

//=======================================================================
//サムネイル、タイトルのデータ取得（ユーザーID、チャンネルIDの判定を含む）
//=======================================================================
function dataOut1( $url ){

	$id=str_replace("https://www.youtube.com/","",$url);//https://www.youtube.com/の削除
	$parts=explode("/",$id);//スラッシュ区切りで配列に代入
	if( $parts[0]<>"user" && $parts[0]<>"channel" ){
		echo "<script>";
			echo "alert('youtubeURLが間違っているようです。')";
		echo "</script>";
		return "";
	}else{
		$chkID=$parts[1];//ユーザーIDorチャンネルIDを代入
	}

	//チェック用のURLを決定する。
	if( strtolower($parts[0])=="user" ){
		$url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&forUsername=".$chkID."&key=".API_KEY;
	}else{
		$url = "https://www.googleapis.com/youtube/v3/channels?part=contentDetails&id=".$chkID."&key=".API_KEY;
	}
	// echo "url=".$url."<br/>";
	$json=cGet_contents($url);//jsonでのデータ取得
	$channel = json_decode($json, true);
	$uploads=$channel["items"][0]["contentDetails"]["relatedPlaylists"]["uploads"];

	//--------------------------------------------
	//playlistId取得する
	//--------------------------------------------
	$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&playlistId=".$uploads."&key=".API_KEY."&maxResults=".RPP;
	// echo "url=".$url."<br/>";

	$json=cGet_contents($url);//jsonでのデータ取得
	$playlist = json_decode($json, true);

	if(!is_array($playlist["items"]) ) {
		//error処理
		echo "<script>";
			echo "alert('youtubeURLが間違っているようです。')";
		echo "</script>";
		return "";
	}

	$youtubeData=array();
	foreach($playlist["items"] as $val) {
		// $tmpTitle   = mb_convert_encoding($val["snippet"]["title"],"auto");//titleを代入
		$tmpTitle   = $val["snippet"]["title"];//titleを代入
		$tmpThumb   = $val["snippet"]["thumbnails"]["medium"]["url"];//サムネイル（中）のURLを代入
		$tmpVideoid = $val["snippet"]["resourceId"]["videoId"];//videoIDを代入

		if($tmpTitle<>"") {
			$youtubeData[] = array( $tmpTitle,$tmpThumb,$tmpVideoid );
		}
	}
	return $youtubeData;//データ内容を戻す。
}

//=======================================================================
//動画IDだけ取得
//=======================================================================
function dataOut2( $url ){

	$id=str_replace(array("https://www.youtube.com/watch?v=","http://youtu.be/"),"",$url);//https://www.youtube.com/の削除
	return $id;//データ内容を戻す。
}


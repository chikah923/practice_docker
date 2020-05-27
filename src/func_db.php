<?php
	date_default_timezone_set('Asia/Tokyo');


	//=======================================================================
	//DB接続情報
	//=======================================================================
	function initDB(){

		//DB接続情報をここでsettingする。
		//$tmpDB = array(
		//	 'host'=>'localhost'
		//	,'user'=>'root'
		//	,'pass'=>'root'
		//	,'db'=>'tooldb'
		//);
		$tmpDB = array(
			 'host'=>'mysql2208.xserver.jp'
			,'user'=>'cy2tool_tooldb'
			,'pass'=>'ueki1695'
			,'db'=>'cy2tool_tooldb'
		);

		//接続情報の文字列を整形
		//$tmp="'mysql:host=".$tmpDB['host'].";dbname=".$tmpDB['db'].";charset=utf8','".$tmpDB['user']."','".$tmpDB['pass']."'";
		return $tmpDB;//配列のまま返す。
	}


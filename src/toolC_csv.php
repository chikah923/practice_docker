<?php
	include("./func_db.php");
	include("./func_toolC.php");
	foreach( $_POST as $key =>$val ){
		$$key=$val;
		// echo $key."=".$val."<br />";
	}
	$sTitle="";
	switch($type){
	case 1:
		$sTitle="サムネイル";
		break;
	case 2:
		$sTitle="タイトル";
		break;
	case 3:
		$sTitle="動画";
		break;
	case 4:
		$sTitle="キーワードチェック";
		break;
	}

	//=======================================================================
	//CSV出力
	//=======================================================================
	try {

		$dataList = array();
		$nowDate=date("Y/m/d H:i");
		// $outHeader=$nowDate." 出力形式（".$sTitle."）、比較元URL： ".$urlFrom." 比較先URL： ".$urlTo;
		$dataList[]=array($nowDate,"出力形式（".$sTitle."）","比較元URL：".$urlFrom,"比較先URL：".$urlTo);

		//--------------------------------------------
		// データ一覧部分の生成
		//--------------------------------------------
		if($type<4){
			$sSQL="select * from m_check where cType=".$type." order by cOrder";
			$rs=GetRS($sSQL);

			while($cols=$rs->fetch_assoc()){
				$answer="";
				$cOrder=NZ($cols['cOrder'],"");
				// $cComment=mb_convert_encoding(NZ($cols['cComment'],""),"SJIS");
				$cComment=NZ($cols['cComment'],"");
				$chkWord="order".$cOrder;

				$answer=( $$chkWord==1)? "OK" : "NG" ;
				$dataList[]=array($cComment,$answer);
			}
			$rs=null;

		//--------------------------------------------
		}else{
			//$strTitle=NZ($keyWord1,"")."　".NZ($keyWord2,"");

			$dataList[]=array("比較元タイトル");
			$dataList[]=array("単語","出現数");
			$xml=wordCheck(NZ($keyWord1,""));
			foreach ( $xml->uniq_result->word_list->word as $node) {
				$tmpWord=$node->surface;
				$tmpCount=$node->count;
				if(mb_strlen($tmpWord,"UTF-8")>1 && $tmpCount>1 ){
					$dataList[]=array( $tmpWord, $tmpCount );
				}
			}
			$dataList[]=array("比較先タイトル");
			$dataList[]=array("単語","出現数");
			$xml=wordCheck(NZ($keyWord2,""));
			foreach ( $xml->uniq_result->word_list->word as $node) {
				$tmpWord=$node->surface;
				$tmpCount=$node->count;
				if(mb_strlen($tmpWord,"UTF-8")>1 && $tmpCount>1 ){
					$dataList[]=array( $tmpWord, $tmpCount );
				}
			}

		}
		//--------------------------------------------

		//CSV形式で情報をファイルに出力のための準備
		$csvFileName = '/tmp/' . time() . rand() . '.csv';
		$fp = fopen($csvFileName, 'w');
		if ($fp === FALSE) {
			throw new Exception('ファイルの書き込みに失敗しました。');
		}
		stream_filter_prepend($fp,'convert.iconv.utf-8/cp932');

		foreach($dataList as $dataInfo) {
			// mb_convert_variables('SJIS', 'UTF-8', $dataInfo);// 文字コード変換。エクセルで開けるようにする
			fputcsv($fp, $dataInfo);// ファイル書き出し
		}

		// ハンドル閉じる
		fclose($fp);

		//ダウンロードファイル名
		$dFileName=date("Y-m-d_Hi")."_".$sTitle.".csv";
		// ダウンロード開始
		header('Content-Type: application/octet-stream');

		// ここで渡されるファイルがダウンロード時のファイル名になる
		header('Content-Disposition: attachment; filename='.$dFileName);
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize($csvFileName));
		readfile($csvFileName);

	} catch(Exception $e) {

		// 例外処理
		echo $e->getMessage();

	}
?>

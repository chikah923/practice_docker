	//--------------------------------------------------------------
	//tab
	//--------------------------------------------------------------
	$(function() {

		// $('#containerC').on('inview', function() {
		// 	//ブラウザの表示域に表示されたときに実行する処理
		// 	window.scrollTo( 0, 0 );
		// 	alert('test');
		// });

		// $('#tabs2').on("click", function (e) { e.preventDefault(); });
		// $('#tabs3').on("click", function (e) { e.preventDefault(); });

		//location.hashで#以下を取得 変数hashに格納
		var hash = location.hash;
		//hashの中に#tab～が存在するか調べる。
		hash = (hash.match(/^#tab\d+$/) || [])[0];

		//hashに要素が存在する場合、hashで取得した文字列（#tab2,#tab3等）から#より後を取得(tab2,tab3)
		if($(hash).length){
			var tabname = hash.slice(1) ;
		} else{
			var tabname = "tab1";// 要素が存在しなければtabnameにtab1を代入する
		}
		$('#containerC .contents').css('display','none');
		$('#containerC .tabs li').removeClass('select');
		var tabno = $('#containerC ul.tabs li#' + tabname).index();
		$('#containerC .contents').eq(tabno).fadeIn();
		$('#containerC ul.tabs li').eq(tabno).addClass('select');

		//クリックしたときのファンクションをまとめて指定
		$('#containerC ul.tabs li').click(function() {
			//.index()を使いクリックされたタブが何番目かを調べ、
			//indexという変数に代入します。
			var index = $('#containerC ul.tabs li').index(this);
			$('#containerC .contents').css('display','none');////コンテンツを一度すべて非表示
			$('#containerC .contents').eq(index).fadeIn(300);////クリックされたタブと同じ順番のコンテンツを表示します。
			$('#containerC .tabs li').removeClass('select');//タブについているクラスselectを消す
			$(this).addClass('select');//クリックされたタブにクラスselectをつけます。
		});

		// $('#containerC #chk1').on("click", function (e) { init3(true); });
		// $('#containerC #chk2').on("click", function (e) { init3(true); });
		// $('#containerC #chk3').on("click", function (e) { init3(true); });

	});

	function checkBg(chkID){
		var id=document.getElementById(chkID);
		if(id.checked == true){
			id.parentNode.style.backgroundColor = '#C6E5FF';
		}else{
			id.parentNode.style.backgroundColor = '#FFFFFF';
		}
	}

	//入力チェックする
	function check1() {
		var url1 = $("#url1-1").val();
		var url2 = $("#url1-2").val();

		if ( url1 == "") { alert("転送元のURLを入力して下さい。"); return false; }
		if ( url2 == "") { alert("転送先のURLを入力して下さい。"); return false; }

		if ( url1.match(/https\:\/\/www.youtube.com\/user\//) || url1.match(/https\:\/\/www.youtube.com\/channel\//) ) {
			// return true;
		}else{
			alert("転送元URLがYoutube形式ではありません。\nURLを確認してください。");
			return false;
		}
		if ( url2.match(/https\:\/\/www.youtube.com\/user\//) || url2.match(/https\:\/\/www.youtube.com\/channel\//) ) {
			return true;
		}else{
			alert("転送先URLがYoutube形式ではありません。\nURLを確認してください。");
			return false;
		}
	}
	//入力チェックする
	function check2() {
		var url1 = $("#url2-1").val();
		var url2 = $("#url2-2").val();

		if ( url1 == "") { alert("転送元のURLを入力して下さい。"); return false; }
		if ( url2 == "") { alert("転送先のURLを入力して下さい。"); return false; }

		if ( url1.match(/https\:\/\/www.youtube.com\/user\//) || url1.match(/https\:\/\/www.youtube.com\/channel\//) ) {
			// return true;
		}else{
			alert("転送元URLがYoutube形式ではありません。\nURLを確認してください。");
			return false;
		}
		if ( url2.match(/https\:\/\/www.youtube.com\/user\//) || url2.match(/https\:\/\/www.youtube.com\/channel\//) ) {
			return true;
		}else{
			alert("転送先URLがYoutube形式ではありません。\nURLを確認してください。");
			return false;
		}
	}
	function check3() {
		var url1 = $("#url3-1").val();
		var url2 = $("#url3-2").val();

		if ( url1 == "") { alert("転送元のURLを入力して下さい。"); return false; }
		if ( url2 == "") { alert("転送先のURLを入力して下さい。"); return false; }

		if ( url1.match(/https\:\/\/www.youtube.com\/watch\?v\=/) || url1.match(/http\:\/\/youtu.be\//) ) {
			// return true;
		}else{
			alert("転送元URLがYoutube形式ではありません。\nURLを確認してください。");
			return false;
		}
		if ( url2.match(/https\:\/\/www.youtube.com\/watch\?v\=/) || url2.match(/http\:\/\/youtu.be\//) ) {
			return true;
		}else{
			alert("転送先URLがYoutube形式ではありません。\nURLを確認してください。");
			return false;
		}
	}
//「文字変換」ボタンを押した時
function goCharacterConversion() {
	var value = document.getElementById("text1").value.replace(/\r\n|\r/g, '\n');
	var CharacterLimit = document.getElementById("setnum").value;

	//console.log(CharacterLimit);
	
	if (CharacterLimit == '' || CharacterLimit == null || CharacterLimit == 0) {
		alert('指定文字数が「0」又は設定されていません。\n1000に設定しました。');
		CharacterLimit =1000;
	}

	//選択された「改行条件」にて、改行処理を行う為
	// alert($.cookie('chkRet'));
	var c= $.cookie('chkRet');
	console.log(c);
	if(!c){
		//var c = $('.ret:checked').map(function() { return $(this).val(); });
		//c = $('[class="ret"]:checked').map(function(){
		//  //$(this)でjQueryオブジェクトが取得できる。val()で値をvalue値を取得。
		//  return $(this).val();
		//}).get();
		//console.log("c="+c);
		
		retClick();
		var c= $.cookie('chkRet');
	}
	var ss = c.split(",");
	
	for (var i in ss) {
		// document.write(ss[i]);
		var sss=ss[i];
		// var re=/(sss)/g ;
		console.log(sss);
		if(sss=="「" || sss=="『"  ){
			value = value.replace( new RegExp(sss, 'g'), '\n'+sss ) ;//改行コードを前に付加
		}else{
			value = value.replace( new RegExp(sss, 'g'), sss+'\n' ) ;//改行コードを後に付加
			
			//2017.11.14
			value = value.replace( new RegExp('。\n」\n', 'g'), '。」\n' ) ;//読点（。）直後に括弧があれば再変換
			value = value.replace( new RegExp('。\n』\n', 'g'), '。』\n' ) ;//読点（。）直後に括弧があれば、間の改行を取り除くため再変換
			
		}
	}

	//文字変換処理（指定の文字をチェックして選択出来る方式へ変更）
	// value = value.replace( /、/g , '、\n' ) ;
	// value = value.replace( /。/g , '。\n' ) ;
	// value = value.replace( '。\n」' , '。」\n' ) ;

	//１行の文字数確認
	var lines = value.split( '\n' );
	var res = '';
	for ( var i = 0; i < lines.length; i++ ) {
		var LineValue = lines[i];
		//空白行の重複削除
		if (LineValue == '' && i !== 0 && lines[i-1] == ''){
			continue;
		}

		if (LineValue == '' && i !== lines.length-1){
			res += '\n';
			continue;
		}else if (LineValue == '' && i == lines.length-1){
			break;
		}

		if ( LineValue.length <= CharacterLimit ) {
			res += LineValue + "\n";
			continue;
		}
		while (LineValue.length > CharacterLimit) {

			res += LineValue.substr(0, CharacterLimit);
			LineValue = LineValue.substr(CharacterLimit);

			if (LineValue == '、' || LineValue == '。' || LineValue == ''){
				break;
			}else{
				res += '\n';
			}
		}
		if (i == lines.length-1){
			res += LineValue;
		}else{
			res += LineValue + '\n';
		}


	}

	document.getElementById("text2").value = res;
}

//「ナレーション変換」ボタンを押した時
function goNarrationChange() {
	var value = document.getElementById("text2").value.replace(/\r\n|\r/g, '\n');
	//▲記入
	var value = value.replace( /。/g , "。▲" ) ;
	var lines = value.split( '\n' );
	//最初の●記入
	var res = '●';
	//■記入
	for ( var i = 0; i < lines.length; i++ ) {
		var LineValue = lines[i];
		if (LineValue == ''){
			res += '■\n';
			continue;
		}else{
			res += LineValue + '\n';
		}


	}
	//最後の●記入
	res += '●';
	document.getElementById("text3").value = res;
}

//--------------------------------------------------------------
//tab
//--------------------------------------------------------------
	$(function() {

		//location.hashで#以下を取得 変数hashに格納
		var hash = location.hash;
		//hashの中に#tab～が存在するか調べる。
		hash = (hash.match(/^#tabA\d+$/) || [])[0];

		//hashに要素が存在する場合、hashで取得した文字列（#tab2,#tab3等）から#より後を取得(tab2,tab3)
		if($(hash).length){
			var tabname = hash.slice(1) ;
		} else{
			var tabname = "tabA1";// 要素が存在しなければtabnameにtab1を代入する
		}
		$('#container .contentsA').css('display','none');
		$('#container .tabsA li').removeClass('select');
		var tabno = $('#container ul.tabsA li#' + tabname).index();
		$('#container .contentsA').eq(tabno).fadeIn();
		$('#container ul.tabsA li').eq(tabno).addClass('select');

		//クリックしたときのファンクションをまとめて指定
		$('#container ul.tabsA li').click(function() {
			//.index()を使いクリックされたタブが何番目かを調べ、
			//indexという変数に代入します。
			var index = $('#container ul.tabsA li').index(this);
			$('#container .contentsA').css('display','none');////コンテンツを一度すべて非表示
			$('#container .contentsA').eq(index).fadeIn(300);////クリックされたタブと同じ順番のコンテンツを表示します。
			$('#container .tabsA li').removeClass('select');//タブについているクラスselectを消す
			$(this).addClass('select');//クリックされたタブにクラスselectをつけます。
		});

	});

//--------------------------------------------------------------
//チャンネルリスト設定
//--------------------------------------------------------------
$(function() {

	// 画面表示時にダイアログが表示されないよう設定
	$( "#channelInit" ).dialog({
		 autoOpen: false
		,modal: true
		,width:800
		,position: { my: "center middle", at: "center middle", of: window }
	});

	//ダイアログ外のクリックで閉じる。
	$(document).on("click", ".ui-widget-overlay", function(){
		location.reload();
		$(this).next().find(".ui-dialog-content").dialog("close");
	});

	// ボタンのクリックイベント
	$("#channelBT").click(function(){
		$('#channelInit').dialog('open');
	});

	$("#channelClose").click(function(){
		$('#channelInit').dialog('close');
		location.reload();
	});

	// 選択クリア
	$("#channelListClear").click(function(){
		var urlcnt = $(".surl");
		//クリア
		$("#channelList").val("");
        // $("#initName").val("");
       	for (var i = 0; i < 10; i++) {
		    $(urlcnt[i]).val("");
		}
	});

	// 選択クリア
	$("#channelListClear2").click(function(){
		var urlcnt = $(".surllist");
		//クリア
		$("#channelListTable").val("");
        $("#initName").val("");
       	for (var i = 0; i < 10; i++) {
		    $(urlcnt[i]).val("");
		}
	});

	$("#channelList").change(function(){
		var val=$(this).val();
		var urlcnt = $(".surl");
		//クリア
        // $("#initName").val("");
       	for (var i = 0; i < 10; i++) {
		    $(urlcnt[i]).val("");
		}

		if(val!=""){
			console.log( val );
	        $.ajax({
	            type: 'GET',
	            dataType: 'json',
	            url: 'functionA.php',
	            data: {
	                oper: "SELECT",
	                operID: val
	            },
	        }).done(function (response) {
	            console.log(response.data);
	            // $("#initName").val(response.data['name']);
	            var list=response.data['url'];
				for (var i = 0; i < list.length; i++) {
				    console.log(list[i]);
				    $(urlcnt[i]).val(list[i]);
				}

	            // location.reload();
	        }).fail(function () {
	            alert("選択エラーです。");
	        });
		}
	});

	$("#channelListTable").change(function(){
		var val=$(this).val();
		var urlcnt = $(".surllist");
		//クリア
        $("#initName").val("");
       	for (var i = 0; i < 10; i++) {
		    $(urlcnt[i]).val("");
		}

		if(val!=""){
			console.log( val );
	        $.ajax({
	            type: 'GET',
	            dataType: 'json',
	            url: 'functionA.php',
	            data: {
	                oper: "SELECT",
	                operID: val
	            },
	        }).done(function (response) {
	            console.log(response.data);
	            $("#initName").val(response.data['name']);
	            var list=response.data['url'];
				for (var i = 0; i < list.length; i++) {
				    console.log(list[i]);
				    $(urlcnt[i]).val(list[i]);
				}

	            // location.reload();
	        }).fail(function () {
	            alert("選択エラーです。");
	        });
		}
	});

	$("#channelListADD").click(function(){
        // var userId = window.sessionStorage.getItem(['userId']);
        var userId = $("#tmpUserID").val();
		// var val = $('#channelListTable').val();//セレクトボックスの選択内容
		console.log(userId);

		var tmpname=$("#initName").val();
        if (!tmpname ) {
            alert("チャンネル名称を入力して下さい");
            return false;
        }

		var numcidarray = [];
		var plural = [];
		var numcidcnt = 0;
		var numcnt = $(".num");
		var cidcnt = $(".cid");
		var urlcnt = $(".surllist");

		for (var i = 0; i < 10; i++) {
			//urlで判断
			var tmp=$(urlcnt[i]).val();
			//入力されていなかったら
			if ( tmp == "" ) {
				continue;
			}
			if (!( tmp == "") ) {
				if (plural.indexOf( tmp ) >= 0){
					alert("同じURLは使用できません。\n（URL:" + tmp + "）");
					$(urlcnt[i]).val("");
					return;
				}
				if (tmp.indexOf( "channel" ) >= 0){
					chk=tmp.replace("https://www.youtube.com/channel/","");
					// chk=tmp.replace("/videos","");
					var chks = chk.split('/');
					numcidarray[numcidcnt] = ["cid", chks[0]];
					plural.push( tmp );
				}else if(tmp.indexOf( "user" ) >= 0 ){
					chk=tmp.replace("https://www.youtube.com/user/","");
					var chks = chk.split('/');
					numcidarray[numcidcnt] = ["num", chks[0]];
					plural.push( tmp );
				}else{
					alert("URLの書式が間違っています。\n\n【youtube書式】\nhttps://www.youtube.com/user/・・・\nhttps://www.youtube.com/channel/・・・");
					$(urlcnt[i]).val("");
					return;
				}
			}
			numcidcnt += 1;
		}
        if (numcidarray.length < 1) {
			alert("URLを最低１個は入力して下さい。");
			 return;
		}
		if(!confirm("入力内容でチャンネル設定へ追加します。\n宜しいですか？")){
			return;
		}
        console.log(tmpname+":"+plural);
		// return;
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: 'functionA.php',
            data: {
                oper: "ADD",
                operUserId: userId,
                operTitle: tmpname,
                operData: plural
            },
        }).done(function (response) {
            console.log(response.data);
            // $("#channelList").append($('<option>').html(response.data['name']).val(response.data['id']));
            $("#channelListTable").append($('<option>').html(response.data['name']).val(response.data['id']));
            // location.reload();
        }).fail(function () {
            alert("追加エラーです。");
        });
	});

	$("#channelListUPDATE").click(function(){
        var userId = $("#tmpUserID").val();
		var val = $('#channelListTable').val();//セレクトボックスの選択内容
		console.log(userId+":"+val);
		if(val=="" || val==null){
            alert("リストからチャンネルを選択して下さい");
            return false;
        }else{
        	var id=val;
        }

		var tmpname=$("#initName").val();
        if (!tmpname ) {
            alert("チャンネル名称を入力して下さい");
            return false;
        }
		var numcidarray = [];
		var plural = [];
		var numcidcnt = 0;
		var numcnt = $(".num");
		var cidcnt = $(".cid");
		var urlcnt = $(".surllist");

		for (var i = 0; i < 10; i++) {
			//urlで判断
			var tmp=$(urlcnt[i]).val();
			//入力されていなかったら
			if ( tmp == "" ) {
				continue;
			}
			if (!( tmp == "") ) {
				if (plural.indexOf( tmp ) >= 0){
					alert("同じURLは使用できません。\n（URL:" + tmp + "）");
					$(urlcnt[i]).val("");
					return;
				}
				if (tmp.indexOf( "channel" ) >= 0){
					chk=tmp.replace("https://www.youtube.com/channel/","");
					// chk=tmp.replace("/videos","");
					var chks = chk.split('/');
					numcidarray[numcidcnt] = ["cid", chks[0]];
					plural.push( tmp );

				}else if(tmp.indexOf( "user" ) >= 0 ){
					chk=tmp.replace("https://www.youtube.com/user/","");
					var chks = chk.split('/');
					numcidarray[numcidcnt] = ["num", chks[0]];
					plural.push( tmp );
				}else{
					alert("URLがYoutubeの書式ではありません。\n（URL:" + tmp + "）");
					$(urlcnt[i]).val("");
					return;
				}
			}
			numcidcnt += 1;
		}
        if (numcidarray.length < 1) {
			alert("URLを最低１個は入力して下さい。");
			 return;
		}
		if(!confirm("入力内容で更新します。\n宜しいですか？")){
			return;
		}

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: 'functionA.php',
            data: {
                oper: "UP",
                operUserId: userId,
                operTitle: tmpname,
                operData: plural,
                operID: id
            },
        }).done(function (response) {
            console.log(response.data);
            // location.reload();
            // sessionStorage.setItem('showPage','setting');
	        var newid=response.data['id'];
            var newval=response.data['name'];
			// $('#channelListTable').children('option[value=newid]').html(newval);
			$('#channelListTable > option:selected').html(newval);

        }).fail(function () {
            alert("更新エラーです。");
        });
	});

	$("#channelListDELETE").click(function(){
        var userId = $("#tmpUserID").val();
		var val = $('#channelListTable').val();//セレクトボックスの選択内容
		console.log(userId+":"+val);
 		if(val=="" || val==null){
            alert("リストからチャンネルを選択して下さい");
            return false;
        }else{
        	var id=val;
        }
        if(!confirm("選択したチャンネル設定を削除します。\n宜しいですか？")){
            return false;
        }
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: 'functionA.php',
            data: {
                oper: "DEL",
                operUserId: userId,
                operID: id
            },
        }).done(function (response) {
            console.log(response.data);
			//選択されたリストを取り除く
			var urlcnt = $(".surllist");
			//クリア
	        $("#initName").val("");
	       	for (var i = 0; i < 10; i++) {
			    $(urlcnt[i]).val("");
			}
			$('#channelListTable > option:selected').remove();
            // location.reload();
            // sessionStorage.setItem('showPage','setting');
        }).fail(function () {
            alert("削除エラーです。");
        });
	});

	/* ----------------------------------------------------------------------- */
	$("#getList2").click(function () {
		var unm = $("#unm").val();
		var wrd = $("#wrd").val();
	        var date=new Date();

		if ((wrd) == "") {
			alert("キーワードを入力して下さい。");
			return;
		}

		if (unm == '0') {
		        date.setDate(date.getDate());
		        date.setHours(date.getHours() - 10);
		} else if (unm == '1') {
		        date.setDate(date.getDate());
		        date.setHours(date.getHours() - 12);
		} else if (unm == '2') {
		        date.setDate(date.getDate());
		        date.setHours(date.getHours() - 15);
		} else if (unm == '3') {
		        date.setDate(date.getDate());
		        date.setHours(date.getHours() - 21);
		} else if (unm == '4') {
		        date.setDate(date.getDate() - 1);
		        date.setHours(date.getHours() - 9);
		} else if (unm == '5') {
		        date.setDate(date.getDate() - 7);
		        date.setHours(date.getHours() - 9);
		} else if (unm == '6') {
		        date.setDate(date.getDate() - 28);
		        date.setHours(date.getHours() - 9);
		} else if (unm == '7') {
		        date.setDate(date.getDate() - 365);
		        date.setHours(date.getHours() - 9);
		}


		var url = "https://www.googleapis.com/youtube/v3/search?";
		var key = "&key=AIzaSyABUOIzwMDeUd6ELEzzhgj2Qtia6DMFXcg";
		var AFT = "&type=video&maxResults=50&prettyprint=true&order=viewCount";
	    var ked = "part=snippet&q=" + wrd;
		var prm = "&publishedAfter="
				+ date.getFullYear()
	            + "-" + ("0" + (date.getMonth() + 1).toString()).slice(-2)
				+ "-" + ("0" + date.getDate().toString()).slice(-2)
	            + "T" + ("0" + date.getHours().toString()).slice(-2)
	            + ":" + ("0" + date.getMinutes().toString()).slice(-2)
	            + ":" + ("0" + date.getSeconds().toString()).slice(-2) + "Z";

		var itemArray = [];
		var curl = [];
		$.getJSON(url + ked + prm + key + AFT, function (json) {
			if (json.items.length === 0) {
				alert("検索結果が見つかりませんでした。");
				return;
			}
			url = "https://www.googleapis.com/youtube/v3/videos?";
			ked = "&part=statistics";

			$.each(json.items, function (i, item) {
				var id = "id=" + item.id.videoId;
				curl.push($.getJSON(url + id + key+  ked));
				var itemlist = [];
				itemlist[0] = item.snippet.title;
				itemlist[1] = item.id.videoId;
				itemlist[2] = item.snippet.channelTitle;
				itemArray[itemArray.length] = itemlist;

			});

			var results = [];
			$.when.apply($, curl).done(function(){
            	if(curl.length == 1){
	        		for (var i = 0; i < arguments.length; i++) {
		        		results[0] = arguments;
		        	}
	        	}else{
		        	for (var i = 0; i < arguments.length; i++) {
		        		results.push(arguments[i]);
		        	}
	        	}
	        	ViewCountDone(itemArray, results);
            }).fail(function(jqXHR, textStatus, errorThrown){
	        	var err = $.parseJSON(jqXHR.responseText);
			    alert("再生回数取得時にエラーが発生しました。\n" + err.error.code + ":" + err.error.message);
			});
	   	}).error(function(jqXHR, textStatus, errorThrown) {
			var err = $.parseJSON(jqXHR.responseText);
			alert("チャンネル情報取得時にエラーが発生しました。\n" + err.error.code + ":" + err.error.message);
		});

	});

	function ViewCountDone (itemArray, results) {

		console.log(results);
		for (var i = 0; i < results.length; i++) {
			var json = results[i][0];
		    if (json.items.length === 0) {
		    	continue;
            }
            for (var n = 0; n < itemArray.length; n++){
	            if(itemArray[n][1] === json.items[0].id){
					if(!json.items[0].statistics.viewCount || json.items[0].statistics.viewCount == 0){
						itemArray[n][3] = 0;
					}else{
						itemArray[n][3] = json.items[0].statistics.viewCount;
					}
					itemArray[n][3] += "回";
				}
            }

        }

        var html = '<form name="ckform2">\n'
        		+ "<table border='1' cellspacing='0' cellpadding='10'>\n"
        		+ "<tbody>"
        for (var i = 0; i < itemArray.length; i++){
        	var title = itemArray[i][0];
            var videoId = itemArray[i][1];
            var channelTitle = itemArray[i][2];
            var viewCount = itemArray[i][3];
            html += "<tr><td style='padding:5px;vertical-align:middle;' >\n"
            	+ '<div class="chkbox"><input type="checkbox" id="' + videoId + '" value="' + title
            	+ '" name="ckbox2" onclick="txtchange2(this.id, this.value)"></div></td>\n'
            	+ '<td style="padding:5px;" >\n'
            	+ title
            	+ "<br />"
            	+ "http://youtu.be/"
            	+ videoId
            	+ "<br />"
            	+ "【チャンネル名】"
            	+ channelTitle
            	+ "<br />"
            	+ "【再生回数】"
            	+ viewCount
            	+ "</td></tr>\n";
        }

		html += "</tbody></table></form>\n";
		$("#uploadVideos2").html(html);

		html = '<table><tbody><tr><td>\n'
		  + '<textarea id="txtcopy2" cols="50" rows="3"></textarea></td>'
		  + '<td><button type="button" id="btncopy" class="btncopy2" data-clipboard-target="#txtcopy2" data-clipboard-action="cut" onclick="copystart2()">クリップボードにコピー</button>'
		  + '</td></tr></tbody></table>';
		$("#divcheckcopy2").html(html);


	}

	/* ----------------------------------------------------------------------- */
	$("#getList").click(function() {
		//ユーザー名／チャンネルＩＤの保存日数
		var saveday = 7;
		var numcidarray = [];
		var plural = [];
        var numcidcnt = 0;
        var numcnt = $(".num");
        var cidcnt = $(".cid");
        var urlcnt = $(".surl");

        for (var i = 0; i < 10; i++) {

			//urlで判断
			var tmp=$(urlcnt[i]).val();
            //入力されていなかったら
	       	if ( tmp == "" ) {
            	$.removeCookie('surl'+(i+1));
            	continue;
            }
            if (!( tmp == "") ) {
                if (plural.indexOf( tmp ) >= 0){
					alert("同じURLは使用できません。\n（URL:" + tmp + "）");
					$(urlcnt[i]).val("");
					return;
				}
				if (tmp.indexOf( "channel" ) >= 0){
					chk=tmp.replace("https://www.youtube.com/channel/","");
					// chk=tmp.replace("/videos","");
					var chks = chk.split('/');
					numcidarray[numcidcnt] = ["cid", chks[0]];
					plural.push( tmp );
					$.cookie('surl'+(i+1), tmp,{ expires: saveday });

				}else if(tmp.indexOf( "user" ) >= 0 ){
					chk=tmp.replace("https://www.youtube.com/user/","");
					var chks = chk.split('/');
					numcidarray[numcidcnt] = ["num", chks[0]];
					plural.push( tmp );
					$.cookie('surl'+(i+1), tmp,{ expires: saveday });
				}

            }else{
            	$.removeCookie('surl'+(i+1));
            }
            numcidcnt += 1;
        }


        if (numcidarray.length < 1) {
			// alert("ユーザー名／チャンネルＩＤを最低１個は入力して下さい。");
			alert("URLを最低１個は入力して下さい。");
            return;
		}

		var htmltitle = "<table border='1' cellspacing='0' cellpadding='10' class='outputTable' >\n";
		var url = "";
		var key = "&key=AIzaSyABUOIzwMDeUd6ELEzzhgj2Qtia6DMFXcg";
		var prm = "";
		var nonchcnt = 0;
		var curl = [];

        for (var i = 0; i < numcidarray.length; i++) {
			url = "https://www.googleapis.com/youtube/v3/channels?";
	        prm = "part=contentDetails,snippet";

	        //ユーザーorチャンネル判定
			if (numcidarray[i][0] == "cid"){
				prm += "&id=" + numcidarray[i][1];
			}else if (numcidarray[i][0] == "num"){
				prm += "&forUsername=" + numcidarray[i][1];
			}else{
				continue;
			}
			console.log(url + prm + key);
			curl.push($.getJSON(url + prm + key));
		}
		if(curl.length == 0){
			alert("チャンネル情報取得に失敗しました。");
			return;
		}

		var results = [];
		$.when.apply($, curl).done(function(){
        	if(curl.length == 1){
        		for (var i = 0; i < arguments.length; i++) {
	        		results[0] = arguments;
	        	}
        	}else{
	        	for (var i = 0; i < arguments.length; i++) {
	        		results.push(arguments[i]);
	        	}
        	}

        	allDone(results);
        }).fail(function(jqXHR, textStatus, errorThrown){
        	var err = $.parseJSON(jqXHR.responseText);
		    alert("チャンネル情報取得時にエラーが発生しました。\n" + err.error.code + ":" + err.error.message);
		    return;
        });

        function allDone (results) {
        	var itemcurl = [];

	        htmltitle += '<tbody><tr><td colspan=2 class="title" >チャンネルタイトル</td></tr>';
       		htmltitle += "<tr><td colspan=2 >\n";
			for (var i = 0; i < results.length; i++) {
				var json = results[i][0];
				if (json.items.length === 0) {
			    	nonchcnt ++;
	                continue;
	            }
	        	var curl = "https://www.youtube.com/channel/" + json.items[0].id;
    			var ctitle = json.items[0].snippet.title;
    			var cdesc = json.items[0].snippet.description;
        		var r = new RegExp("https?://((?:[\-!#$%&'=~a-zA-Z0-9@;:+*,?_]+\\.)+[\-$%&~a-zA-Z0-9@;+*,?_]+(:[0-9]+)?/?(?:[\-!#$%&'=~a-zA-Z0-9@;:+*,./?_]+)?)", "g"); //URLを検出

        		//htmltitle +=
				// "<tbody><tr><td></td><td>\n"
				// + "<h2><a href='" + curl + "' target='_blank'>" + ctitle + "</a></h2>\n"
				// + "<hr />\n"
				// // + cdesc.replace(r, "<a href='$&' target='_blank'>$&</a>")
				//	// .replace(/\n/g, "<br />\n")
				// + "</td></tr>\n";

        		htmltitle += "<p style='padding:5px;margin:0px;'><a href='" + curl + "' target='_blank'>" + ctitle + "</a></p>\n";

			    url = "https://www.googleapis.com/youtube/v3/playlistItems?";
		        prm = "part=snippet&maxResults=50&playlistId="
				        + json.items[0].contentDetails.relatedPlaylists.uploads;
			    itemcurl.push($.getJSON(url + prm + key));

			    // console.log(i+":"+url + prm + key);

			}
        	htmltitle += "</td></tr>\n";
 
			//=================================================================================
			if(itemcurl.length == 0){
				if(nonchcnt !== 0){
					alert(nonchcnt + "個のユーザー名／チャンネルが見つかりませんでした。");
				}else{
					alert("動画一覧取得に失敗しました。");
				}
				return;
			}
			var itemresults = [];
			$.when.apply($, itemcurl).done(function(){
            	if(itemcurl.length == 1){
	        		for (var i = 0; i < arguments.length; i++) {
		        		itemresults[0] = arguments;
		        	}
	        	}else{
		        	for (var i = 0; i < arguments.length; i++) {
		        		itemresults.push(arguments[i]);
		        	}
	        	}

	        	// console.log(itemresults);
	        	itemallDone(itemresults);
            }).fail(function(jqXHR, textStatus, errorThrown){
	        	var err = $.parseJSON(jqXHR.responseText);
			    alert("動画一覧取得時にエラーが発生しました。\n" + err.error.code + ":" + err.error.message);
			    return;
	        });
			//=================================================================================


		}

		function itemallDone (itemresults) {
			var listarray = [];
			var listcnt = 0;
			console.log(itemresults.length);
			for (var i = 0; i < itemresults.length; i++){
				if (itemresults[i][0].items){
					var json = itemresults[i][0];
					console.log(json.items.length);
					for (var n = 0; n < json.items.length; n++){
						var cday = json.items[n].snippet.publishedAt;
					    listarray[listcnt] = [Date.parse(cday), json.items[n].snippet.resourceId.videoId, json.items[n].snippet.title];
	            		console.log(n+"="+listarray[listcnt]);
	            		listcnt += 1;
					}

	        	}
			}

			listarray.sort(
				function(a,b){
					var aday = a[0];
					var bday = b[0];
					if( aday > bday ) return -1;
					if( aday < bday ) return 1;
					return 0;
				}
			);
			var limit = 50;
			if (listarray.length < limit){
				limit = listarray.length;
			}
			var videocurl = [];
			var viewarray = [];
			for (var i = 0; i < limit; i++){
				url = "https://www.googleapis.com/youtube/v3/videos?";
		        prm = "part=snippet,contentDetails,statistics,status&id="
				        + listarray[i][1];
			    videocurl.push($.getJSON(url + prm + key));
				viewarray.push(listarray[i]);

			    // console.log(i+":"+url + prm + key);

			}

			if(videocurl.length == 0){
				alert("再生回数取得に失敗しました。");
				return;
			}
			var videoresults = [];
			$.when.apply($, videocurl).done(function(){
            	if(videocurl.length == 1){
	        		for (var i = 0; i < arguments.length; i++) {
		        		videoresults[0] = arguments;
		        	}
	        	}else{
		        	for (var i = 0; i < arguments.length; i++) {
		        		videoresults.push(arguments[i]);
		        	}
	        	}
	        	videoallDone(videoresults,viewarray);

            }).fail(function(jqXHR, textStatus, errorThrown){
	        	var err = $.parseJSON(jqXHR.responseText);
			    alert("再生回数取得時にエラーが発生しました。\n" + err.error.code + ":" + err.error.message);
			    return;
	        });
		}

		//動画情報を取得（最大50）
		function videoallDone (videoresults,viewarray) {
			for (var i = 0; i < videoresults.length; i++) {
				var json = videoresults[i][0];
			    if (json.items.length === 0) {
			    	continue;
	            }
	            for (var n = 0; n < viewarray.length; n++){
		            if(viewarray[n][1] === json.items[0].id){
						if(!json.items[0].statistics.viewCount || json.items[0].statistics.viewCount == 0){
							viewarray[n][3] = 0;
						}else{
							viewarray[n][3] = json.items[0].statistics.viewCount;
						}

					}
	            }

	        }
	        var html = "";

	        html += '<tr><td colspan=2 class="title" >動画情報一覧</td></tr>';
	        for (var i = 0; i < viewarray.length; i++){
	        	var title = viewarray[i][2];
                var videoid = viewarray[i][1];
                var viewcount = viewarray[i][3];
	            html += '<tr><td>'
				  + '<div class="chkbox"><label><input type="checkbox" id="' + videoid + '" value="' + title +'" name="ckbox" onclick="txtchange(this.id,this.value)"></label></div></td><td>\n'
				  + title
				  + "<br>"
				  + "http://youtu.be/"
				  + videoid
				  + "<br>再生回数：" + viewcount
				  + "</td></tr>\n";
            }

			html = '<form name="ckform">' + htmltitle + html + "</tbody></table></form>\n";
			$("#uploadVideos").html(html);

			html = '<table><tbody><tr><td>\n'
			  + '<textarea id="txtcopy" cols="50" rows="3"></textarea></td>'
			  + '<td><button type="button" id="btncopy" class="btncopy" data-clipboard-target="#txtcopy" data-clipboard-action="cut" onclick="copystart()">クリップボードにコピー</button>'
			  + '</td></tr></tbody></table>';
			$("#divcheckcopy").html(html);

			if (nonchcnt > 0){
				alert(nonchcnt + "個のユーザー名／チャンネルが見つかりませんでした。");
			}
		}
	});


});

	function retClick(){
		retval = $('[class="ret"]:checked').map(function(){
		  //$(this)でjQueryオブジェクトが取得できる。val()で値をvalue値を取得。
		  return $(this).val();
		}).get();
		console.log(retval);
		$.cookie('chkRet', retval,{ expires: 7 });
	}

var cnt = 0;
function copystart(){
	var clipboard = new Clipboard(".btncopy");
	clipboard.on("error", function(e) {
	    alert("コピーに失敗しました…。");
	    return;
	});
	for (var i=0; i<document.ckform.ckbox.length; i++){
		document.ckform.ckbox[i].checked = false;
	}
}

function txtchange(videoid,title){
	var txtvalue = document.getElementById("txtcopy").value;
	if(document.getElementById(videoid).checked == true){
		if(txtvalue !== ""){
			txtvalue += "\n";
		}
		txtvalue += title + "\nhttp://youtu.be/" + videoid;
	}else if(document.getElementById(videoid).checked == false){
		var value = title + "\nhttp://youtu.be/" + videoid;
		if(txtvalue.indexOf(value + "\n") != -1){
			txtvalue = txtvalue.replace(value + "\n","") ;
		}else if(txtvalue.indexOf("\n" + value) != -1){
			txtvalue = txtvalue.replace("\n" + value,"") ;
		}else{
			txtvalue = txtvalue.replace(value,"") ;
		}
	}
	document.getElementById("txtcopy").value = txtvalue;
}


function copystart2(){
	var clipboard = new Clipboard(".btncopy2");
	clipboard.on("error", function(e) {
	    alert("コピーに失敗しました…。");
	    return;
	});
	console.log(document.ckform2.ckbox2.length);
	for (var i=0; i<document.ckform2.ckbox2.length; i++){
		document.ckform2.ckbox2[i].checked = false;
	}
}
function txtchange2(videoid,title){
	var txtvalue2 = document.getElementById("txtcopy2").value;
	if(document.getElementById(videoid).checked == true){
		if(txtvalue2 !== ""){
			txtvalue2 += "\n";
		}
		txtvalue2 += title + "\nhttp://youtu.be/" + videoid;
	}else if(document.getElementById(videoid).checked == false){
		var value2 = title + "\nhttp://youtu.be/" + videoid;
		if(txtvalue2.indexOf(value2 + "\n") != -1){
			txtvalue2 = txtvalue2.replace(value2 + "\n","") ;
		}else if(txtvalue2.indexOf("\n" + value2) != -1){
			txtvalue2 = txtvalue2.replace("\n" + value2,"") ;
		}else{
			txtvalue2 = txtvalue2.replace(value2,"") ;
		}
	}
	document.getElementById("txtcopy2").value = txtvalue2;
}

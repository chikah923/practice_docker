$(window).load(function () {
    $(window).scrollTop(0);//ページトップへ
});
$(function () {

	var hashFlag=false;
	$("#settingPage").hide();
	$("#container").hide();
	$("#channelDataAnalytics").hide();
	$("#containerB").hide();
	$("#containerC").hide();
	$("#containerD").hide();

	console.log(sessionStorage.getItem('showPage'));

	//========================================================
	//モデリングチェック//containerC　tabs処理
	//========================================================
	var hash = location.hash;
	hash = (hash.match(/^#tab\d+$/) || [])[0];

	//console.log("hash:"+$(hash).length);

	//hashに要素が存在する場合、hashで取得した文字列（#tab2,#tab3等）から#より後を取得(tab2,tab3)
	if($(hash).length){
	    $("#settingPage").hide();
        $("#container").hide();
		$("#channelDataAnalytics").hide();
        $("#containerB").hide();
	    $("#containerC").show();
        $("#containerD").hide();

        $("#settingLi").removeClass("active");
        $("#toolALi").removeClass("active");
        $("#toolBLi").removeClass("active");
	    $("#toolCLi").addClass("active");
        $("#toolDLi").removeClass("active");
        $(".panel-heading").text("モデリングチェック");
        hashFlag=true;
	}

	//========================================================
	//キーワード調査//containerD　keyword処理
	//========================================================
	var keyword = location.search;
	keyword = (keyword.match(/^\?keyword=\S+$/) || [])[0];

	console.log("keyword:"+keyword);

	//クエリストリング（?keyword）から取得
	if( keyword ){
	    
	    
	    $("#settingPage").hide();
        $("#container").hide();
		$("#channelDataAnalytics").hide();
        $("#containerB").hide();
        $("#containerC").hide();
	    $("#containerD").show();

        $("#settingLi").removeClass("active");
        $("#toolALi").removeClass("active");
        $("#toolBLi").removeClass("active");
        $("#toolCLi").removeClass("active");
	    $("#toolDLi").addClass("active");
        $(".panel-heading").text("キーワード調査");
        hashFlag=true;
	}
	console.log("hashFlag:"+hashFlag);

	//========================================================
	//初期設定(モデリングチェック、キーワード調査の処理時には、ページ読み込みとなる為、当該処理がある場合には初期設定を行わない)
	//========================================================
	if(!hashFlag){
	    $("#settingPage").hide();
	    $("#container").show();
	    $("#channelDataAnalytics").hide();
	    $("#containerC").hide();
	    $("#containerD").hide();//2017.11.13 機能追加のため

	    $("#toolALi").addClass("active");
	    $(".panel-heading").text("動画取得・文字変換");
	    $(".userName").prop("disabled", true);
	    $(".password").prop("disabled", true);
	    $("#roleSelect").prop("disabled", true);
	    $(".etc").prop("disabled", true);
	    $("#parentSelect").prop("disabled", true);

	    if (loginUserAuthority == 2) {
	        $("#settingLi").hide();
	        $("#toolBLi").hide();
	        $("#toolCLi").hide();
	        $("#toolDLi").hide();
	    } else {
	        $("#settingLi").show();
	        $("#toolBLi").show();
	        $("#toolCLi").show();
	        $("#toolDLi").show();
	    }
		//console.log("hashFlag:"+hashFlag);
	}



	//========================================================
	//設定
	//========================================================
    if(sessionStorage.getItem('showPage')=="setting"){
        $("#toolALi").removeClass("active");
        $("#toolBLi").removeClass("active");
        $("#toolCLi").removeClass("active");
        $("#toolDLi").removeClass("active");

        $("#settingLi").addClass("active");
        $("#container").hide();
        $("#settingPage").show();
        $(".panel-heading").text("設定");
        sessionStorage.removeItem('showPage');
    }

	//========================================================
	//チャンネル解析
	//========================================================
    if(sessionStorage.getItem('showPage')=="channelUpdate"){
        $("#settingLi").removeClass("active");
        $("#toolALi").removeClass("active");
        $("#toolBLi").addClass("active");
        $("#toolCLi").removeClass("active");
        $("#toolDLi").removeClass("active");

        $("#channelDataAnalytics").show();
        $("#container").hide();
        $("#containerC").hide();
        $("#containerD").hide();

        $("#settingPage").hide();
        $(".panel-heading").text("チャンネル解析");
        $("#channelUpdate").hide();
        $("#channelAnalytics2").hide();
        $("#channelAnalytics1").show();
        sessionStorage.removeItem('showPage');
    }

	//========================================================
	//動画取得・文字変換　メニュー
	//========================================================
    $("#toolA").click(function (e) {
        e.preventDefault();
        $("#settingLi").removeClass("active");
        $("#toolALi").addClass("active");
        $("#toolBLi").removeClass("active");
        $("#toolCLi").removeClass("active");
        $("#toolDLi").removeClass("active");

        $("#container").show();
        $("#channelDataAnalytics").hide();
        $("#containerC").hide();
        $("#settingPage").hide();
        $(".panel-heading").text("動画取得・文字変換");
    })

	//========================================================
	//チャンネル解析　メニュー
	//========================================================
    $("#toolB").click(function (e) {
        e.preventDefault();
        $("#settingLi").removeClass("active");
        $("#toolALi").removeClass("active");
        $("#toolBLi").addClass("active");
        $("#toolCLi").removeClass("active");
        $("#toolDLi").removeClass("active");

        $("#channelDataAnalytics").show();
        $("#channelAnalytics1").hide();
        $("#channelUpdate").show();
        $("#channelAnalytics2").show();

        $("#container").hide();
        $("#containerC").hide();
        $("#settingPage").hide();
        $(".panel-heading").text("チャンネル解析");
    })

	//========================================================
	//モデリングチェック　メニュー
	//========================================================
    $("#toolC").click(function (e) {
        e.preventDefault();
        $("#settingLi").removeClass("active");
        $("#toolALi").removeClass("active");
        $("#toolBLi").removeClass("active");
        $("#toolCLi").addClass("active");
        $("#toolDLi").removeClass("active");

        $("#container").hide();
        $("#channelDataAnalytics").hide();
        $("#containerC").show();
        $("#containerD").hide();
        $("#settingPage").hide();
        $(".panel-heading").text("モデリングチェック");
    })

	//========================================================
	//キーワード調査　メニュー
	//========================================================
    $("#toolD").click(function (e) {
        e.preventDefault();
        $("#settingLi").removeClass("active");
        $("#toolALi").removeClass("active");
        $("#toolBLi").removeClass("active");
        $("#toolCLi").removeClass("active");
        $("#toolDLi").addClass("active");

        $("#container").hide();
        $("#channelDataAnalytics").hide();
        $("#containerC").hide();
        $("#containerD").show();
        $("#settingPage").hide();
        $(".panel-heading").text("キーワード調査");

    })

	//========================================================
	//チャンネル解析　更新ボタン
	//========================================================
    $("#channelUpdateButton").click(function(){
        $("#channelUpdate").hide();
        $("#channelAnalytics2").hide();
        $("#channelAnalytics1").show();
    })

	//========================================================
	//設定　ボタン
	//========================================================
    $("#setting").click(function (e) {
        e.preventDefault();
        $("#toolALi").removeClass("active");
        $("#toolBLi").removeClass("active");
        $("#toolCLi").removeClass("active");
        $("#toolDLi").removeClass("active");

        $("#settingLi").addClass("active");
        $("#container").hide();
        $("#channelDataAnalytics").hide();
        $("#containerC").hide();
        $("#containerD").hide();
        $("#settingPage").show();
        $(".panel-heading").text("設定");

    })

	//========================================================
	//ユーザー設定関連（追加・更新・削除）登録処理もあり
	//========================================================
    $("#addUser").click(function () {
        $(".userName").val('');
        $(".password").val('');
        $(".etc").val('');

        $("#parentSelect").val(loginUserId);
        $("#parentSelect").prop("disabled", true);

        $(".userName").prop("disabled", false);
        $(".password").prop("disabled", false);
        $(".etc").prop("disabled", false);


        $("#roleSelect").prop("disabled", false);
        $("#roleSelect").children().eq(2).prop("selected", true);
        if (loginUserAuthority == 0) {
            $("#roleSelect").children().eq(0).hide();
        } else if (loginUserAuthority == 1) {
            $("#roleSelect").children().eq(0).hide();
            $("#roleSelect").children().eq(1).hide();
        }
    })

    $("#updateUser").click(function () {
        var userId = $('input[name=check]:checked').val();
        if (!userId) {
            alert("対象ユーザを一つ選んでください");
            return false;
        }
        var password = $('input[name=check]:checked').parent().parent().find(".passwordList").text();
        var authority = $('input[name=check]:checked').parent().parent().find(".authorityList").text().charAt(0);

        var etc = $('input[name=check]:checked').parent().parent().find(".etcList").text();
        var parent = $('input[name=check]:checked').parent().parent().find(".parentUserIdList").text();

        if(parent!="" ){//loginUserAuthority == 0
            $("#parentSelect").val(parent);
        }else{
            $("#parentSelect").val("admin");
        }

        if (loginUserAuthority == 0) {
            $("#parentSelect").prop("disabled", false);//選択出来るようにする。
        }else{
            // if (loginUserAuthority == 1) {
            //     $("#parentSelect").val(userId);
            // }else{
            // }
            $("#parentSelect").prop("disabled", true);
        }

        $(".password").prop("disabled", false);
        $("#roleSelect").prop("disabled", false);
        $(".etc").prop("disabled", false);

        $(".userName").val(userId);
        $(".password").val(password);
        $(".etc").val(etc);

        if (authority == '0') {
            $("#roleSelect").children().eq(0).prop("selected", true);
        } else if (authority == '1') {
            $("#roleSelect").children().eq(1).prop("selected", true);
        } else if (authority == '2') {
            $("#roleSelect").children().eq(2).prop("selected", true);
        }
        $("#roleSelect").prop("disabled", true);

        $(".userName").prop("disabled", true);

    })

    $("#deleteUser").click(function () {
        var userId = $('input[name=check]:checked').val();
        if (!userId) {
            alert("対象ユーザを一つ選んでください");
            return false;
        }
        if(loginUserId==userId){
            alert("自分自身は削除できません");
            return false;
        }
        if(!confirm(userId+"を削除しますが、よろしいでしょうか？")){
            return false;
        }
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'function.php',
            data: {
                oper: "deleteUser",
                operUserId: userId
            },
        }).done(function (response) {
            console.log(response.data);
            location.reload();
            sessionStorage.setItem('showPage','setting');
        }).fail(function () {
            alert("削除エラーです。");
        });

    })


    $("#register").click(function () {
        var oper = '';
        if($(".userName").prop("disabled")){
            oper = 'updateUser';
        }else{
            oper = 'addUser';
        }
        var userId = $(".userName").val();
        var password = $(".password").val();
        var authority = $("#roleSelect").val();
        // alert($(".etc").val());

        var parentUserId = $("#parentSelect").val();
        var etc = $(".etc").val();

        if(!userId || !password){
            alert("ユーザIDとパスワード全部を入力してください");
            return false;
        }
        if(!confirm("登録します。よろしいで゙しょうか。")){
            return false;
        }
        console.log(oper+":"+userId+":"+password+":"+authority+":"+etc);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'function.php',
            data: {
                oper: oper,
                operUserId: userId,
                operPassword: password,
                operAuthority: authority,
                operParentUserId: parentUserId,
                operEtc: etc
            },
        }).done(function (response) {
            // alert(response.data);
            console.log(response.data);
            location.reload();
            sessionStorage.setItem('showPage','setting');
        }).fail(function (response) {
            console.log(response.data+"\n"+"error!!!");
            alert("登録・更新エラーです。");

        });

    })


    $("#reset").click(function () {
        if(!confirm("登録処理をキャンセルしますが、よろしいでしょうか。")){
            /* キャンセルの時の処理 */
            return false;
        }
        $(".userName").val('');
        $(".password").val('');
        $(".etc").val('');
        $(".userName").prop("disabled", true);
        $(".password").prop("disabled", true);
        $(".etc").prop("disabled", true);
        $("#roleSelect").prop("disabled", true);
        $("#roleSelect").children().eq(2).prop("selected", true);
    })

   $(".anlyticsButton").click(function () {
        var oper = 'analytics';
        var content = $("#selectContent").val();
        var days = $("#selectDays").val();
        var chId = $(this).attr('id');
        $("#selectedChannelName").val($(this).parent().parent().children().eq(0).text());


        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'function.php',
            data: {
                oper: oper,
                chId: chId,
                content: content,
                days: days
            },
        }).done(function (response) {
            console.log('dataPoints1:',response.dataPoints1);
            updateChart(response.dataPoints1,response.dataPoints2);
        }).fail(function () {
        });
    })

    $("#channelReset").click(function(){
        $("#toolB").click();
    })

    $("#deleteChannel").click(function(){
        var oper = 'deleteChannel';
        var chkRec=$("input[class=channelCheck]:checked").parents("tr");
        if (chkRec.length == 0){
            alert('チャンネルを選択してください');
            return false;
        }
        var chIdList = [];
        var chIdStr = '';
        for(var i=0;i<chkRec.length;i++){
            var rec=chkRec[i];
            console.log(rec);
            chIdList[i]=$(rec).children().eq(0).find('.channelCheck').attr('id');
            chIdStr = chIdStr +'['+$(rec).children().eq(1).text()+']\n';
            console.log("chidList:",chIdList[i]);
        }
        if(!confirm(chIdStr+"を削除しますが、よろしいでしょうか。")){
            return false;
        }
        var chIdListJson = JSON.stringify(chIdList);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: 'function.php',
            data: {
                oper: oper,
                chIdList: chIdListJson
            },
        }).done(function (response) {
            console.log(response.data);
            location.reload();
            sessionStorage.setItem('showPage','channelUpdate');
        }).fail(function () {
        });

    })

    $("#channelRegister").click(function(){
        var oper = 'addChannel';
        var channelUrlVal = $("#channelUrl").val();
        var channelUrl = jQuery.trim(channelUrlVal.replace(/\s+/g, ""));
        var userName = '';
        var chId = '';
        var chName = '';
        if(channelUrl){
            if(channelUrl.indexOf('https://www.youtube.com/user/') != -1) {
                userName = channelUrl.replace("https://www.youtube.com/user/","").split("/")[0];
                var googleUrl = "https://www.googleapis.com/youtube/v3/channels?"
                var key = "&key=AIzaSyABUOIzwMDeUd6ELEzzhgj2Qtia6DMFXcg";
                var prm = "part=contentDetails,snippet,statistics,brandingSettings"+ "&forUsername=" + userName;
                $.ajaxSetup({ async: false });
                $.getJSON(googleUrl + prm + key, function (json) {
                    if (json.items.length === 0) {
                        alert("チャンネルが見つかりません。");
                        return false;
                      }
                    chId = json.items[0].id;
                    chName = json.items[0].snippet.title;
                }).error(function(jqXHR, textStatus, errorThrown) {
                    var err = $.parseJSON(jqXHR.responseText);
                    alert("チャンネル情報取得時にエラーが発生しました。\n" + err.error.code + ":" + err.error.message);
                });
                $.ajaxSetup({ async: true });
            }else if(channelUrl.indexOf('https://www.youtube.com/channel/') != -1){
                chId = channelUrl.replace("https://www.youtube.com/channel/","").split("/")[0];
                var googleUrl = "https://www.googleapis.com/youtube/v3/channels?"
                var key = "&key=AIzaSyABUOIzwMDeUd6ELEzzhgj2Qtia6DMFXcg";
                var prm = "part=contentDetails,snippet,statistics,brandingSettings"+ "&id=" + chId;
                console.log('curl:',googleUrl + prm + key);
                $.ajaxSetup({ async: false });
                $.getJSON(googleUrl + prm + key, function (json) {
                    if (json.items.length === 0) {
                        alert("チャンネルが見つかりません。");
                        return false;
                      }
                    chName = json.items[0].snippet.title;
                    console.log(chName);
                }).error(function(jqXHR, textStatus, errorThrown) {
                    var err = $.parseJSON(jqXHR.responseText);
                    alert("チャンネル情報取得時にエラーが発生しました。\n" + err.error.code + ":" + err.error.message);
                });
                $.ajaxSetup({ async: true });
            }else{
                alert("チャンネルURLが誤っているかチャンネルが存在しません。");
                return false;
            }
        }else{
            alert("チャンネルURLが入力されていません。");
            return false;
        }
        console.log('chId,chName',chId+":"+chName);
        if(!(chId=="" || chName=="")){
            console.log('chId,chName',chId+":"+chName);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: 'function.php',
                data: {
                    oper: oper,
                    chId: chId,
                    chName: chName
                },
            }).done(function (response) {
                console.log(response.data);
                location.reload();
                sessionStorage.setItem('showPage','channelUpdate');
            }).fail(function () {
            });
        }
    })

    var updateChart = function (dataPoints1, dataPoints2) {
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            axisY: {
                title: "再生回数",
                includeZero: false,
                lineColor: "#369EAD"
            },
            axisY2: {
                title: "登録者数",
                includeZero: false,
                lineColor: "#C24642"
            },
            axisX: {
                title: "日付",
                valueFormatString: "DD/MMM"
            },
            data: [
            {
                type: "spline",
                name: "再生回数",
                xValueType: "dateTime",
                dataPoints:dataPoints1
            },
            {
                type: "spline",
                axisYType: "secondary",
                name: "登録者数",
                xValueType: "dateTime",
                dataPoints: dataPoints2
            }
            ]
        });
        chart.render();
    };
});
$(function() {
    var showFlag = false;
    var topBtn = $('#page-top');    
    topBtn.css('bottom', '-100px');
    var showFlag = false;
    //スクロールが100に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            if (showFlag == false) {
                showFlag = true;
                topBtn.stop().animate({'bottom' : '50px'}, 200); 
            }
        } else {
            if (showFlag) {
                showFlag = false;
                topBtn.stop().animate({'bottom' : '-100px'}, 200); 
            }
        }
    });
    //スクロールしてトップ
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
});
$(function () {
 var headerHight = 50; //ヘッダの高さ
 $('a[href^=#]').click(function(){
     var href= $(this).attr("href");
       var target = $(href == "#" || href == "" ? 'html' : href);
        var position = target.offset().top-headerHight; //ヘッダの高さ分位置をずらす
     $("html, body").animate({scrollTop:position}, 550, "swing");
        return false;
   });
});

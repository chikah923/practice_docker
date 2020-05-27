<?php
	$key=array(
		"","　",
		"あ","い","う","え","お","か","き","く","け","こ","さ","し","す","せ","そ","た","ち","つ","て","と","な","に","ぬ","ね","の",
		"は","ひ","ふ","へ","ほ","ま","み","む","め","も","や","ゆ","よ","ら","り","る","れ","ろ","わ","を","ん",
		"が","ぎ","ぐ","げ","ご","ざ","じ","ず","ぜ","ぞ","だ","ぢ","づ","で","ど","ば","び","ぶ","べ","ぼ","ぱ","ぴ","ぷ","ぺ","ぽ",
		"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
		"1","2","3","4","5","6","7","8","9"
	);

	$tmp="";
	foreach($key as $val){
		$tmp.= "'".$val."',";
	}
	$tmp=substr($tmp,0,-1);

	$keyword=NZ($_GET['keyword'],"");
	$word=NZ($_GET['word'],"");
	$result=NZ($_GET['result'],"");

?>
<style>
.box{
	margin-bottom:10px;
	padding:10px;
}
.title{
	padding:10px;
	margin-bottom:10px;
	font-size:16px;
	font-weight:bold;
	color:white;
	background:#FF9999;
}
.list{

}
.textSearch{
    display: block;
    width: 100%;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
</style>
<script type="text/javascript">
	// function chk(word){
	// 	return $.ajax({
	// 				url: "http://www.google.com/complete/search",
	// 				data: {hl:'ja', ds:'yt', client:'youtube', output:'firefox', q: word},
	// 				dataType: "jsonp",
	// 				type: "GET",
	// 				async: false
	// 			})
	// }

	function searchWord(){
		
		// var key=[ 
		// 	"","　",
		// 	"あ","い","う","え","お","か","き","く","け","こ","さ","し","す","せ","そ","た","ち","つ","て","と","な","に","ぬ","ね","の",
		// 	// "は","ひ","ふ","へ","ほ","ま","み","む","め","も","や","ゆ","よ","ら","り","る","れ","ろ","わ","を","ん",
		// 	// "が","ぎ","ぐ","げ","ご","ざ","じ","ず","ぜ","ぞ","だ","ぢ","づ","で","ど","ば","び","ぶ","べ","ぼ","ぱ","ぴ","ぷ","ぺ","ぽ",
		// 	"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
		// 	"1","2","3","4","5","6","7","8","9"
		// 	];

		var key=[<?php echo $tmp?>];

		var word=$("#word").val();
		if(word!=""){
			$("#searchBox").show();
			$("#wordtitle").empty();
			$("#wordtitle").append("&nbsp;検索キーワード："+word);
			<?php
				$ii=0;
				foreach($key as $val){
					echo "$('#list".$ii."').empty();";
					$ii++;
				}
			?>
		
			// document.frm.submit();
			// document.frmSearch.submit();
			for(i=0;i<key.length;i++){
				var val=key[i];
				if(i<=1){
					var search=word+val;
				}else{
					var search=word+"　"+val;
				}
				// console.log(search);
				outputWord(i,search);
			}

		}else{
			alert("キーワードを入力してください。");
		}
	}

	function outputWord(i,word){

		$.ajax({
			url: "http://www.google.com/complete/search",
			data: {hl:'ja', ds:'yt', client:'youtube',  q: word},
			dataType: "jsonp",
			type: "GET",
			// async: false,
			success:function(data) {
				if(data[1]){
					// console.log(data);
					var a=[];
					$.each(data[1],
						function(index, elem) {
							// console.log(elem[0]);
							a.push(elem[0]);
						}
					);

					// var title=word.replace(/^\s+|\s+$/g,'_');
					// if(i<=1){
						var title=word.replace(/(.*)\s/,"$1_");
					// }else{
					// 	var title=search;
					// }
					
					str="";
					// $.each(a,function(ii, text){
					// 	$("#list").append("<li style='margin-left:10px;'>"+text+"</li>");
					// });
					a.forEach(function(text){
						str+="<li style='margin-left:0px;'><a href='https://www.youtube.com/results?search_query="+text+"' target='youtube' >"+text+"</a></li>";
					});

					tmp="";
					if(str!=""){
						tmp= "<div class='box'><div class='title'>"+title+"</div>";
						tmp+="<ul>";
						tmp+=str;
						tmp+="</ul>";
						tmp+="</div>";
					}
					$("#list"+i).append(tmp);

					// $("#result").val(a);
					// console.log("result="+a );

				}

			}
		});	
	}
</script>

<!-- Main content -->
<div style="width:800px;padding:10px 20px;margin:0 auto;">
    <div class="" style='' >
    	<input type=hidden name='keyword' value='検索' >
     	<!-- <input type=text name='result' id='result' value='<?php //echo $result; ?>'  >   -->
        <input type="text" class="form-control" id="word" name='word' size=30 placeholder="キーワードを入力してください。" value='<?php echo $word; ?>'  onFocus='this.select();' >
        <br/>
			<input type=button value='検索' onClick='return searchWord();'　class='btn btn-primary btn-block' style='background:red;color:white;border:none;width:250px;height:44px;font-size:18px;margin:0 auto;' >
        <br/>
        <span style='color:red;' >※検索で表示された各キーワードをクリックすると、youtubeの検索結果一覧へとリンクされます。</span>
        <hr>
        <?php
			echo "<div id='searchBox' style='display:none;padding-bottom:20px;' >";
			echo "<table cellspacing=1 cellpadding=5 bgcolor=#eeeeee  >";
			echo "<tr>";
			echo "<td colspan=19 id=wordtitle style='height:40px;' ></td>";
			echo "<td style='background:white;text-align:center;'><a href='#list1' style='display:block;padding:9px;' >＿</a></td>";
				$ii=0;
				foreach($key as $val){
					if($ii>1){
						$valOut=($ii==1)? "_" : $val;
					if( (($ii-2)%20)==0 ){
						echo "</tr>";
						echo "<tr>";
					}
 					echo "<td style='background:white;text-align:center;'><a href='#list".($ii)."' style='display:block;padding:9px;'>".$valOut."</a></td>";
					}
					$ii++;
				}
			echo "</tr>";
			echo "</table>";
			echo "</div>";

	        $ii=0;
			foreach($key as $val){
	            echo "<a id='#list".$ii."' style=''></a><div id='list".$ii."'></div>";
	            $ii++;
	        }
        ?>

    </div>
</div>

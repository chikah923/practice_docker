     <ul class="tabsA">
        <li id="tabA1" class="select"><span>動画一覧</span></li>
        <li id="tabA2"><span>キーワード検索</span></li>
        <li id="tabA3"><span>文字変換</span></li>
    </ul>
    <?php
    //=================================================================================================
    //ツールAをタブ化
    //=================================================================================================
    ?>
    <div class="contentsA">
        <?php
        //----------------------------------------------------------
        //Youtubeのチャンネルの動画一覧を取得
        //----------------------------------------------------------
        ?>
        <div style="margin-left: auto; margin-right:auto; margin-top: 0em; width: 800px;">
           <h1 style="text-align:center;padding-bottom:20px;">Youtubeのチャンネルの動画一覧を取得</h1>

            <div style="text-align:center;">
                <fieldset style="display:inline-block;padding:10px 50px; width: 690px;">
                    <legend></legend>
                    <div style='width:120px; float:left;'>チャンネル設定</div>
                    <div style='width:300px; float:left;text-align:left;'>
                        <?php
                        $tmpSQL="select * from t_channel_list where userId='".$userId ."'";
                        $rsTmp=GetRS($tmpSQL);
                        echo "<select id='channelList' class='channelList' size=5 style='width:300px;' >";
                        // echo "<option value=''></option>";
                        while($colsTmp=$rsTmp->fetch_assoc()){
                           $no = NZ($colsTmp['channelID'],"");
                           $val = NZ($colsTmp['channelTitle'],"");
                           echo "<option value='".$no."'>".$val."</option>";
                        }
                        $rsTmp=null;
                        ?>
                        </select>
                    </div>
                    <div style='width:150px; float:left;padding-left:10px;'>
                        <button id='channelListClear' style='padding:5px;' >選択クリア</button>&nbsp;&nbsp;
                        <button id='channelBT' style='padding:5px;' >設定</button>
                    </div>
                    <div style='clear:both;'></div>
                </fieldset>
            </div>
            <p></p>

            <div style="text-align:center;">
                <fieldset style="display:inline-block;padding:10px 50px; width: 690px;">
                    <legend>最低１個は入力して下さい</legend>
                    <?php
                        for($ii=1;$ii<=10;$ii++){
                            $tmp="surl".$ii;
                            $tmpCookie=$_COOKIE[$tmp];
                            echo "<p>URL".substr(" ".$ii,-2)."：&nbsp;";
                                echo "<input type='text' id='surl".$ii."' class='surl' value='".$tmpCookie."' size=70 length=70 />";
                            echo "</p>";
                        }
                    ?>

                   <p>
                        <!-- <button id="getList" >動画一覧を取得</button> -->
                        <button id="getList" class="btn btn-lg btn-primary btn-block" style='background:red;border:none;width:250px;margin:0 auto;' >検索</button>
                        <span style="font-size:12px;">※最大５０件<br /></span>
                    </p>
                </fieldset>
            </div>
            <hr />
            <a id="back" href="/">トップページへ戻る</a>
            <br />
            <br />
            <div id="divcheckcopy">
            </div>
            <div id="uploadVideos"></div>
        </div>
    </div>

    <div class="contentsA">
        <?php
        //----------------------------------------------------------
        //Youtubeの再生数順に検索結果を取得
        //----------------------------------------------------------
        ?>
            <!-- <h1>Youtubeの再生数順に検索結果を取得</h1> -->
        <div style="margin-left: auto; margin-right:auto; margin-top: 0em; width: 800px;">
            <h1 style="text-align:center;padding-bottom:20px;">Youtubeの再生数順に検索結果を取得</h1>
            <div style="text-align:center;">
                <fieldset style="display:inline-block;padding:10px 50px;">
                <legend>検索条件を入力してください</legend>
                アップロード日
                    <select id="unm"  class="form-control">
                            <option value="0">0: 1時間以内</option>
                            <option value="1">1: 3時間以内</option>
                            <option value="2" selected>2: 6時間以内</option>
                            <option value="3">3: 12時間以内</option>
                            <option value="4">4: １日以内</option>
                            <option value="5">5: 今週</option>
                            <option value="6">6: 今月</option>
                            <option value="7">7: 今年</option>
                    </select>
                <br />
                <br />
                キーワード　　 <input type="text" id="wrd" value="" length=30 /><br />
                <span style="font-size:12px;font-family:monospace;">検索したいキーワードを入力してください<br />
                <br /></span>
                <!--　　　　　<button id="getList2">動画一覧を取得</button> -->
                <button id="getList2" class="btn btn-lg btn-primary btn-block" style='background:red;border:none;width:250px;margin:0 auto;' >検索</button>
                <span style="font-size:12px;">※最大５０件<br /></span>
                </fieldset>
            </div>
            <hr>
            <div id="divcheckcopy2"></div>
            <div id="uploadVideos2"></div>
        </div>
    </div>

    <div class="contentsA">
        <?php
        //----------------------------------------------------------
        //文字変換
        //----------------------------------------------------------
        ?>
        <h1 style="text-align:center;padding-bottom:20px;">文字変換</h1>
        <table cellpadding="5"  >
            <tr>
                <td colspan=2 >
                    <fieldset>
                    <legend>設定</legend>
                    </fieldset>
                </td>
            </tr>
           <tr>
                <td style='width:200px;'>
                    <fieldset>
                    指定文字数&nbsp;&nbsp;&nbsp;<input id="setnum" type="text" value="1000" style="width : 60px;text-align: right;" onKeyup="this.value=this.value.replace(/[^0-9]+/i,'')" onblur="this.value=this.value.replace(/[^0-9]+/i,'')">
                    </fieldset>
                </td>
                <td valign=bottom >
                    <div style='border:1px solid blue;padding:10px;margin-right:50px;'>
                        改行条件<br/>
                        <?php
                            if($_COOKIE["chkRet"]==""){$_COOKIE["chkRet"]="。,、";}
                            $chkArray=array("。","、","「","」","『","』");//改行設定する語句を配列にて設定する（追加可能）
                            $tmp=$_COOKIE["chkRet"];
                            $tmpRet=explode("",$tmp);
                            foreach( $chkArray as $val ){
                                $strChecked= "";
                                foreach( explode(",",$_COOKIE["chkRet"]) as $val2 ){
                                    if( $val==$val2 ){
                                        $strChecked= "checked";
                                        break;
                                    }
                                }
                                echo "<input type=checkbox class='ret' id='' name='ret' value='".$val."' ".$strChecked." onClick='retClick();' >&nbsp;".$val."&nbsp;&nbsp;&nbsp;";

                            }
                            // // echo "cookie=".$_COOKIE["chkRet"]."<br/>";
                            // foreach( explode(",",$_COOKIE["chkRet"]) as $val ){
                            //     echo "val=".$val."<br/>";
                            // }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan=2 >変換前テキスト<br>
                <textarea id="text1" cols="150" rows="20"  style="overflow:auto;" wrap="off"></textarea>
                </td>
            </tr>
            <tr>
                <td colspan=2 ><INPUT type="button" value="文字変換" style="width : 150px;text-align : center;font-size : 9pt;" onClick="goCharacterConversion();">
                </td>
            </tr>
            <tr>
                <td colspan=2 >文字変換後<br>
                <textarea id="text2" cols="150" rows="20" style="overflow:auto;" wrap="off"></textarea>
                </td>
            <tr>
                <td colspan=2 ><INPUT type="button" value="ナレーション変換" style="width : 150px;text-align : center;font-size : 9pt;" onClick="goNarrationChange();">
                </td>
            </tr>
            <tr>
                <td colspan=2 >ナレーション変換後<br>
                <textarea id="text3" cols="150" rows="20" style="overflow:auto;" wrap="off"></textarea>
                </td>
            </tr>
        </table>
        <hr />
        <a id="back" href="/">トップページへ戻る</a>
    </div>

<?php
    //-------------------------------------------------------------------
    //チャンネル設定ダイアログ（現在使用中も記載）
    //-------------------------------------------------------------------
    $sItem ="<div id='channelInit' title='チャンネル設定画面' class='pl15 pb20' style='z-index:2000;display:;'>";

        $sItem.= "<div style='padding:10px 5px; margin-top:10px;background:#FFFFFF;' >";
            $sItem.= "<span style='font12'>";
            $sItem.= "<strong>【チャンネル設定について】</strong><br/>";
            $sItem.= "・新規追加する場合は、チャンネル名称、URL（最大10）を入力後「新規追加」ボタンを押して下さい。<br/>";
            $sItem.= "・リストを選択すると、登録された内容が表示されます。編集後「修正」ボタンで更新されます。<br/>";
            $sItem.= "・リストを選択し、「新規追加」ボタンを押すと内容を複製できます。<br/>";
            $sItem.= "・リストを選択して「削除」ボタンを押すと、登録内容が削除されます";
            $sItem.= "<hr>";
            $sItem.= "</span>";
            $sItem .= "<div style='width:120px; float:left;'>チャンネル設定</div>";
            $sItem .= "<div style='width:300px; float:left;text-align:left;'>";
                $tmpUser = //$_SESSION["userId"];//現在ログインしているユーザーID
                $tmpSQL="select * from t_channel_list where userId='".$userId ."'";
                $rsTmp=GetRS($tmpSQL);
                $sItem .= "<select id='channelListTable' class='channelListTable' size=5 style='width:300px;' >";
                // $sItem .= "<option value=''></option>";
                while($colsTmp=$rsTmp->fetch_assoc()){
                   $no = NZ($colsTmp['channelID'],"");
                   $val = NZ($colsTmp['channelTitle'],"");
                   $sItem.= "<option value='".$no."'>".$val."</option>";
                }
                $rsTmp=null;
                $sItem.= "</select>";
            $sItem.= "</div>";
            $sItem.= "<div style='width:300px; float:left;padding-left:10px;'>";
                $sItem.= "<div style='width:300px;float:left;'>";
                    $sItem.= "<button id='channelListClear2' style='padding:5px;' >選択クリア</button>&nbsp;&nbsp;";
                    $sItem.= "<button id='channelClose' style='padding:5px;' >閉じる</button>";
               $sItem.= "</div>";
                $sItem.= "<div style='width:300px;float:left;padding-top:50px;'>";
                    $sItem.= "<button id='channelListUPDATE' style='color:blue;padding:5px;'  > 更 新 </button>&nbsp;&nbsp;&nbsp;";
                    $sItem.= "<button id='channelListDELETE' style='color:red;padding:5px;' > 削 除 </button>";
                    $sItem.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    $sItem.= "<button id='channelListADD' style='color:green;padding:5px;'>新規追加</button>";
                $sItem.= "</div>";
            $sItem.= "</div>";
            $sItem.= "<div style='clear:both;'></div>";

        $sItem.= "</div>";

        $sItem.= "<div style='padding:10px; background:#DAE3F3;' >";
            // $sItem.= "<form>";
            $sItem.= "<p>チャンネル名称　<input type='text' name='initName' id='initName' size=30 value='' placeholder='チャンネル設定名称を入力してください' ></p>";
            $sItem.="<input type='hidden' name='tmpUserID' id='tmpUserID' size=30 value='".$userId."' >";

            for($ii=1;$ii<=10;$ii++){
                $sItem.= "<p>URL".substr(" ".$ii,-2)."：&nbsp;";
                    $sItem.= "<input type='text' id='surllist".$ii."' class='surllist' value='' size=70 length=70 />";
                $sItem.= "</p>";
            }
        $sItem.= "</div>";
        // $sItem.= "<div style='width:100px; float:right;'><button id='channelListADD' >新規追加</button></div>";

        // $sItem.= $tmpSQL." : ".$tmpUser."<br/>";
    $sItem .="</div>";
    echo $sItem;
?>
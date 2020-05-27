    <ul class='tabs'>
        <li id='tab1' class='select'><span>サムネイル</span></li>
        <li id='tab2'><span>タイトル</span></li>

    <?php
		if( !file_exists("./movie.txt") ){
			echo "<li id='tab3'><span>動画チェック</span></li>";
		}
    ?>
    </ul>

    <?php
    //=================================================================================================
    //サムネイル比較
    //=================================================================================================
    ?>
    <div class="contents">
        <?php
        //----------------------------------------------------------
        //URL入力画面
        //----------------------------------------------------------
        ?>
        <h1 style="text-align:center;padding-bottom:20px;">サムネイル比較</h1>
        <form name='frm' action="<?php echo $_SERVER['SCRIPT_NAME']; ?>#tab1" method=post >
            <input type="hidden" name="ACT" value="thumbnial" >
            <div class='left pl10' >
                <div class='left mb10 font16 bold blue' >
                    <span class='bold'>YoutubeチャンネルURLを入力して下さい</span><br /><br />
                    <div class='mb10' >比較元URL：&nbsp;<input class='font14 black normal' type="text" id="url1-1" name='url1-1' value="<?php echo $url1; ?>" size=70 onFocus='this.select();' /></div>
                    <div class='mb10' >比較先URL：&nbsp;<input class='font14 black normal' type="text" id="url1-2" name='url1-2' value="<?php echo $url2; ?>" size=70 onFocus='this.select();' /></div>
                </div>
                <!-- <button id="getList">データ一覧を取得</button> -->
                <!-- <span style="font-size:12px;">※最大５０件<br /></span> -->
                <div class='floatL mb10' >
                    <span class='bold'>&lt;URL書式&gt;&nbsp;&nbsp;以下の2種類</span><br/>
                    <span >・https://www.youtube.com/user/ユーザーID</span><br />
                    <span >・https://www.youtube.com/channel/チャンネルID</span><br />
                </div>
                <div class='floatL left p10 pl30'>
                    <input type=submit value='比較' onclick='return check1();' class='btn btn-primary btn-block' style='background:red;border:none;width:250px;height:44px;font-size:18px;margin:0 auto;'  id="chk1" >
                </div>
                <div class='clear'></div>
            </div>
        </form>
        <hr>
        <?php
        if($ret1<>"" && $ret2<>"" ){
            //----------------------------------------------------------
            //結果表示画面
            //----------------------------------------------------------
            ?>
                <div class='column_title'>
                    <table cellspacing=0 cellpadding=0 border=0 >
                    <tr>
                        <td class='center bold mb10' style='width:330px; background:#d6d6d6; border:1px solid #999999;'>比較元サムネイル</td>
                        <td class='center bold mb10' style='width:330px; background:#d6d6d6; border:1px solid #999999;border-left:none;'>比較先サムネイル</td>
                    </tr>
                    </table>
                </div>

                <div class='borderALL' style='width:680px;height:380px;overflow-y:scroll;'>
                    <table cellspacing=0 cellpadding=0 border=0 >
                    <tr>
                    <?php
                        echo "<td>";
                        foreach( $ret1 as $key => $val ){ echo "<div class='p5'><img src='".$val[1]."' /></div>"; }
                        echo "</td><td>";
                        foreach( $ret2 as $key => $val ){ echo "<div class='p5'><img src='".$val[1]."' /></div>"; }
                        echo "</td>";
                    ?>
                    </tr>
                    </table>
                </div>
            <?php
            //----------------------------------------------------------
            //チェック入力画面
            //----------------------------------------------------------
            ?>
                <div class='column_title pt10'>サムネイル確認項目</div>
                <form method='post' action='./toolC_csv.php' >
                <input type=hidden name='type' value=1 >
                <input type=hidden name='urlFrom' value="<?php echo $url1; ?>" >
                <input type=hidden name='urlTo' value="<?php echo $url2; ?>" >
                <div class='borderALL' style='width:680px;height:180px; padding:10px; overflow-y:scroll;'>
                    <?php
                        $sSQL="select * from m_check where cType=1 order by cOrder;";
                        $rs = GetRS($sSQL);
                        while( $cols= $rs->fetch_assoc()){
                            $cType=1;
                            $cOrder=NZ($cols['cOrder'],"");
                            $cComment=NZ($cols['cComment'],"");

                            echo "<div class='font16 bold p5' style='padding-bottom:0px;' >";
                                echo "<input type=checkbox id='checkbox".$cOrder."' name='order".$cOrder."' value='1' onClick='checkBg(\"checkbox".$cOrder."\")'>";
                                echo "<label for='checkbox".$cOrder."' style='padding-left:15px;' >";
                                echo $cComment;
                                echo "</label>";
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class='right p10' style='width:660px;'>
                	<!-- <input type=submit value='結果出力' class='btn btn-primary' > -->
                    <input type=submit value='結果出力' class='btn btn-primary btn-block' style='background:red;border:none;width:250px;height:44px;font-size:18px;margin:0 auto;' >
                </div>
                </form>
            <?php
        }
        ?>
    </div>

    <?php
    //=================================================================================================
    //タイトル比較
    //=================================================================================================
    ?>
    <div class="contents">
        <h1 style="text-align:center;padding-bottom:20px;">タイトル比較</h1>
        <form name='frm' action="<?php echo $_SERVER['SCRIPT_NAME']; ?>#tab2" method=post >
            <input type="hidden" name="ACT" value="title" >
            <div class='left pl10' >
                <div class='left mb10 font16 bold blue' >
                    <span class='bold'>YoutubeチャンネルURLを入力して下さい</span><br /><br />
                    <div class='mb10' >比較元URL：&nbsp;<input class='font14 black normal' type="text" id="url2-1" name='url2-1' value="<?php echo $url3; ?>" size=70 onFocus='this.select();' /></div>
                    <div class='mb10' >比較先URL：&nbsp;<input class='font14 black normal' type="text" id="url2-2" name='url2-2' value="<?php echo $url4; ?>" size=70 onFocus='this.select();' /></div>
                </div>
                <!-- <button id="getList">データ一覧を取得</button> -->
                <!-- <span style="font-size:12px;">※最大５０件<br /></span> -->
                <div class='floatL mb10' >
                    <span class='bold'>&lt;URL書式&gt;&nbsp;&nbsp;以下の2種類</span><br/>
                    <span >・https://www.youtube.com/user/ユーザーID</span><br />
                    <span >・https://www.youtube.com/channel/チャンネルID</span><br />
                </div>
                <div class='floatL left p10 pl30'>
                    <!-- <input type=submit value='比較' onclick='return check2();' class='btn btn-primary'  id="chk2" > -->
                    <input type=submit value='比較' onclick='return check2();' id="chk2" class='btn btn-primary btn-block' style='background:red;border:none;width:250px;height:44px;font-size:18px;margin:0 auto;' >
                </div>
                <div class='clear'></div>
            </div>
        </form>
        <hr>
        <?php
        if($ret3<>"" && $ret4<>"" ){
            //----------------------------------------------------------
            //結果表示画面
            //----------------------------------------------------------
            ?>
                <div class='column_title'>
                    <table cellspacing=0 cellpadding=0 border=0 >
                    <tr>
                        <td class='center bold mb10' style='width:330px; background:#d6d6d6; border:1px solid #999999;'>比較元タイトル</td>
                        <td class='center bold mb10' style='width:330px; background:#d6d6d6; border:1px solid #999999;border-left:none;'>比較先タイトル</td>
                    </tr>
                    </table>
                </div>

                <form method='post' action='./toolC_csv.php' >
                <input type=hidden name='type' value=4 >
                <input type=hidden name='urlFrom' value="<?php echo $url3; ?>" >
                <input type=hidden name='urlTo' value="<?php echo $url4; ?>" >
                <div class='borderALL' style='width:680px;height:330px;overflow-y:scroll;'>
                    <table cellspacing=0 cellpadding=0 border=0 >
                    <tr>
                    <?php
                        $tmpWord1=$tmpWord2="";
                        echo "<td>";
                        foreach( $ret3 as $key => $val ){
                            echo "<div class='p5' style='width:330px;height:100px;'>".$val[0]."</div>";
                            $tmpWord1.=$val[0]."　";
                        }
                        echo "</td><td>";
                        foreach( $ret4 as $key => $val ){
                            echo "<div class='p5' style='width:330px;height:100px;'>".$val[0]."</div>";
                            $tmpWord2.=$val[0]."　";
                        }
                        echo "</td>";
                    ?>
                    </tr>
                    </table>
                </div>
                <input type=hidden name='keyWord1' value="<?php echo $tmpWord1; ?>" >
                <input type=hidden name='keyWord2' value="<?php echo $tmpWord2; ?>" >
                <div class='right p10' style='width:660px;'><input type=submit value='キーワードチェック' class='btn btn-primary' ></div>
                </form>
            <?php
            //----------------------------------------------------------
            //チェック入力画面
            //----------------------------------------------------------
            ?>
                <div class='column_title pt10'>タイトル確認項目</div>

                <form method='post' action='./toolC_csv.php' >
                <input type=hidden name='type' value=2 >
                <input type=hidden name='urlFrom' value="<?php echo $url3; ?>" >
                <input type=hidden name='urlTo' value="<?php echo $url4; ?>" >
                <div class='borderALL' style='width:680px;height:180px; padding:10px; overflow-y:scroll;'>
                    <?php
                        $sSQL="select * from m_check where cType=2 order by cOrder;";
                        $rs = GetRS($sSQL);
                        while( $cols= $rs->fetch_assoc()){
                            $cType=1;
                            $cOrder=NZ($cols['cOrder'],"");
                            $cComment=NZ($cols['cComment'],"");

                            echo "<div class='font16 bold p5' style='padding-bottom:0px;' >";
                                echo "<input type=checkbox id='checkbox".$cOrder."' name='order".$cOrder."' value='1' onClick='checkBg(\"checkbox".$cOrder."\")'>";
                                echo "<label for='checkbox".$cOrder."' style='padding-left:15px;' >";
                                echo $cComment;
                                echo "</label>";
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class='right p10' style='width:660px;'><input type=submit value='結果出力' class='btn btn-primary' ></div>
                </form>

            <?php
        }
        ?>
    </div>

    <?php
    //=================================================================================================
    //動画比較
    //=================================================================================================
    if( !file_exists("./movie.txt") ){
    ?>
    <div class="contents">
        <?php
        //----------------------------------------------------------
        //URL入力画面
        //----------------------------------------------------------
        ?>
        <h1 style="text-align:center;padding-bottom:20px;">動画比較</h1>
        <form name='frm' action="<?php echo $_SERVER['SCRIPT_NAME']; ?>#tab3" method=post >
            <input type="hidden" name="ACT" value="movie" >
            <div class='left pl10' >
                <div class='left mb10 font16 bold blue' >
                    <span class='bold'>Youtube動画URLを入力して下さい</span><br /><br />
                    <div class='mb10' >比較元URL：&nbsp;<input class='font14 black normal' type="text" id="url3-1" name='url3-1' value="<?php echo $url5; ?>" size=70 onFocus='this.select();' /></div>
                    <div class='mb10' >比較先URL：&nbsp;<input class='font14 black normal'  type="text" id="url3-2" name='url3-2' value="<?php echo $url6; ?>" size=70 onFocus='this.select();' /></div>
                </div>
                <!-- <button id="getList">データ一覧を取得</button> -->
                <!-- <span style="font-size:12px;">※最大５０件<br /></span> -->
                <div class='floatL mb10' >
                    <span class='bold'>&lt;URL書式&gt;&nbsp;&nbsp;以下の2種類</span><br/>
                    <span >・https://www.youtube.com/watch?v=XXXXXXXXXXX</span><br />
                    <span >・http://youtu.be/XXXXXXXXXXX</span><br />
                </div>
                <div class='floatL left p10 pl30'>
                    <input type=submit value='比較' onclick='return check3();' class='btn btn-primary' id="chk3" >
                </div>
                <div class='clear'></div>
            </div>
        </form>
        <hr>
        <?php
        if($ret5<>"" && $ret6<>"" ){
            //----------------------------------------------------------
            //結果表示画面
            //----------------------------------------------------------
            ?>
                <div class='column_title'>
                    <table cellspacing=0 cellpadding=0 border=0 >
                    <tr>
                        <td class='center bold mb10' style='width:330px; background:#d6d6d6; border:1px solid #999999;'>比較元動画</td>
                        <td class='center bold mb10' style='width:330px; background:#d6d6d6; border:1px solid #999999;border-left:none;'>比較先動画</td>
                    </tr>
                    </table>
                </div>

                <div class='borderALL' style='width:680px;height:380px;overflow-y:scroll;'>
                    <table cellspacing=0 cellpadding=0 border=0 >
                    <tr>
                    <?php
                        echo "<td>";
                            echo "<div class='p5'><iframe width='320' height='180' src='https://www.youtube.com/embed/".$ret5."' frameborder='0' allowfullscreen></iframe></div>";
                        echo "</td><td>";
                            echo "<div class='p5'><iframe width='320' height='180' src='https://www.youtube.com/embed/".$ret6."' frameborder='0' allowfullscreen></iframe></div>";
                        echo "</td>";
                    ?>
                    </tr>
                    </table>
                </div>
            <?php
            //----------------------------------------------------------
            //チェック入力画面
            //----------------------------------------------------------
            ?>
                <div class='column_title pt10'>動画確認項目</div>
                <form method='post' action='./toolC_csv.php' >
                <input type=hidden name='type' value=3 >
                <input type=hidden name='urlFrom' value="<?php echo $url5; ?>" >
                <input type=hidden name='urlTo' value="<?php echo $url6; ?>" >
                <div class='borderALL' style='width:680px;height:180px; padding:10px; overflow-y:scroll;'>
                    <?php
                        $sSQL="select * from m_check where cType=3 order by cOrder;";
                        $rs = GetRS($sSQL);
                        while( $cols= $rs->fetch_assoc()){
                            $cType=1;
                            $cOrder=NZ($cols['cOrder'],"");
                            $cComment=NZ($cols['cComment'],"");

                            echo "<div class='font16 bold p5' style='padding-bottom:0px;' >";
                                echo "<input type=checkbox id='checkbox".$cOrder."' name='order".$cOrder."' value='1' onClick='checkBg(\"checkbox".$cOrder."\")'>";
                                echo "<label for='checkbox".$cOrder."' style='padding-left:15px;' >";
                                echo $cComment;
                                echo "</label>";
                            echo "</div>";
                        }
                    ?>
                </div>
                <div class='right p10' style='width:660px;'><input type=submit value='結果出力' class='btn btn-primary' ></div>
                </form>
            <?php
        }
    echo "</div>";
    }
    ?>
    <hr />
    <a id="back" href="/">トップページへ戻る</a>
<?php
//ini_set( 'display_errors', 1 );
//error_reporting( E_ALL );
session_start();
if (!isset($_SESSION["userId"])){
    header("Location: login.php");
    exit;
}

header('Content-Type: text/html; charset=utf-8');

$authority = $_SESSION["authority"];
$userId = $_SESSION["userId"];

include("./func_db.php");
$_connect=initDB();
$pdo = new PDO(
    'mysql:host='.$_connect['host'].';dbname='.$_connect['db'].';charset=utf8',$_connect['user'],$_connect['pass']
    ,array(PDO::ATTR_EMULATE_PREPARES => false)
);

$stmt = '';
//管理者
if($authority == 0){
    $sql = "SELECT * FROM user WHERE status='0' and authority in (0,1)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}else{
    //ユーザーの場合
    $sql = "SELECT * FROM user WHERE (userId = :userId OR parentUserId = :parentUserId) AND status='0'";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array($_SESSION["userId"],$_SESSION["userId"]));
}

$stmt2 = '';
$sql2 = "SELECT * FROM channelmaster WHERE userId = :userId AND status='0'";
$stmt2 = $pdo->prepare($sql2);
$stmt2->execute(array($_SESSION["userId"]));
$result = $stmt2->fetchAll();

    //=====================================================
    //toolC
    //=====================================================
    include("./func_toolC.php");
    $ACT=NZ($_POST['ACT'],"");
    $ret1=$ret2=$ret3=$ret4=$ret5=$ret6="";
    if($ACT<>""){
        // echo $ACT."<br/>";
        switch($ACT){
        case "thumbnial":
            $url1=NZ($_POST['url1-1'],"");
            $url2=NZ($_POST['url1-2'],"");
            $ret1=dataOut1( $url1 );
            $ret2=dataOut1( $url2 );
            break;
        case "title":
            $url3=NZ($_POST['url2-1'],"");
            $url4=NZ($_POST['url2-2'],"");
            $ret3=dataOut1( $url3 );
            $ret4=dataOut1( $url4 );
            break;
        case "movie":
            $url5=NZ($_POST['url3-1'],"");
            $url6=NZ($_POST['url3-2'],"");
            $ret5=dataOut2( $url5 );
            $ret6=dataOut2( $url6 );
            break;
        }
    }

?>
    <!doctype html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <title>メイン画面</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/themes/smoothness/jquery-ui.css">
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Bootstrap core JavaScript
    ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script>
            window.jQuery || document
                .write('<script src="assets/js/vendor/jquery.min.js"><\/script>');
        </script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.0/jquery-ui.min.js"></script>

        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.8/clipboard.min.js"></script>
        <script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script type="text/javascript">
            var loginUserAuthority = <?php echo json_encode($authority);?>;
            var loginUserId= <?php echo json_encode($userId);?>;
        </script>
        <link href="css/common.css" rel="stylesheet">
        <link href="css/toolA.css" rel="stylesheet">
        <link href="css/toolC.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="assets/js/ie-emulation-modes-warning.js"></script>
        <script src="myJS/toolA.js"></script>
        <script src="myJS/toolC.js"></script>
        <script src="myJS/main.js"></script>
        <script src="myJS/jquery.xdomainajax.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body>

        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="main.php" style='font-weight:bold;'>AY-Tools&nbsp;</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li id="toolALi"><a href="#" id="toolA">動画取得・文字変換</a></li>
                        <li id="toolBLi"><a href="#" id="toolB">チャンネル解析</a></li>
                        <li id="toolCLi"><a href="#" id="toolC">モデリングチェック</a></li>
                        <li id="toolDLi"><a href="#" id="toolD">キーワード調査</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li id="settingLi"><a href="#" id="setting">設定</a></li>
                        <li><a href="logout.php" id="signOut">ログアウト</a></li>
                        <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Help <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="http://wml37.com/" target="_blank">ウェブマーケティングLab37</a></li>
                                <li><a href="">Skype</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </nav>

        <div class="container">
            <div class="panel panel-success">
                <div class="panel-heading"></div>
                <div class="panel-body">

                    <!--Youtube動画一覧取得ツール画面 -->
                    <div id="container" style="display:none; margin-left: auto; margin-right:auto; margin-top: 0em;">
                       <?php
                            include("./toolA.php");
                        ?>
                    </div>

                    <!--チャンネルデータ解析ツール画面 -->
                    <div id="channelDataAnalytics" style="display:none;" >

                        <?php
                            include("./toolB.php");
                        ?>
                    </div>

                    <!--Youtubeモデリングチェックツール画面 -->
                    <div id="containerC" style="display:none; margin-left: auto; margin-right:auto; margin-top: 0em;">
                        <!-- <h1 style="text-align:center;padding-bottom:20px;">Youtubeモデリングチェック</h1> -->
                        <?php
                            include("./toolC.php");
                        ?>
                    </div>

                     <!--キーワード調査ツール画面 -->
                    <div id="containerD" style="display:none; margin-left: auto; margin-right:auto; margin-top: 0em;">
                        <!-- <h1 style="text-align:center;padding-bottom:20px;">キーワード調査</h1> -->
                        <?php
                            include("./toolD.php");
                        ?>
                    </div>
                    <!--設定画面 -->
                    <div id="settingPage" style="display:none;" >
                        <label>ユーザ一覧</label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="userListTable">
                                <thead>
                                    <tr class="info">
                                        <th>選択</th>
                                        <th>親ユーザ名</th>
                                        <th>ユーザ名</th>
                                        <th>パスワード</th>
                                        <th>権限</th>
                                        <th>備考</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // $authorityStr = '';
                                        // switch($row['authority']){
                                        // case "0":
                                        //     $authorityStr = '0: 管理者';
                                        //     break;
                                        // case "1":
                                        //     $authorityStr = '1: ユーザ';
                                        //     break;
                                        // case "2":
                                        //     $authorityStr = '2: ワーカー';
                                        //     break;
                                        // }

                                    $strAuthority = array( '0: 管理者','1: ユーザ','2: ワーカー');
                                    $styleColor= array( "style='background:#99ffff'","style='background:#eeffff'","");

                                    foreach ($stmt as $row) {
                                        $backColor = $styleColor[ $row['authority'] ];//権限によって背景色を変える
                                        echo '<tr>';
                                        echo "<td ".$backColor." ><input type='radio' name='check' value='".$row['userId']."'></td>";
                                        echo "<td class = 'parentUserIdList' ".$backColor." >".htmlspecialchars($row['parentUserId']).'</td>';
                                        echo "<td class = 'userIdList' ".$backColor." >".htmlspecialchars($row['userId']).'</td>';
                                        echo "<td class = 'passwordList' ".$backColor." >".htmlspecialchars($row['password']).'</td>';
                                        echo "<td class = 'authorityList' ".$backColor." >".htmlspecialchars($strAuthority[$row['authority']]).'</td>';
                                        echo "<td class = 'etcList' ".$backColor." >".htmlspecialchars($row['etc']).'</td>';
                                        echo '</tr>';

                                        //管理者の場合、ワーカー表示は、親ユーザー毎に表示する。
                                        if($authority == 0){
                                            $sql = "SELECT * FROM user WHERE status='0' and authority=2 and parentUserId = :parentUserId ";
                                            $stmtTmp = $pdo->prepare($sql);
                                            $stmtTmp->execute( array($row['userId']) );

                                            foreach ($stmtTmp as $rowTmp) {
                                                echo '<tr>';
                                                echo "<td><input type='radio' name='check' value='".$rowTmp['userId']."'></td>";
                                                echo "<td class = 'parentUserIdList'>".htmlspecialchars($rowTmp['parentUserId']).'</td>';
                                                echo "<td class = 'userIdList'>".htmlspecialchars($rowTmp['userId']).'</td>';
                                                echo "<td class = 'passwordList'>".htmlspecialchars($rowTmp['password']).'</td>';
                                                echo "<td class = 'authorityList'>".htmlspecialchars($strAuthority[$rowTmp['authority']]).'</td>';
                                                echo "<td class = 'etcList'>".htmlspecialchars($rowTmp['etc']).'</td>';
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                    ?>
                                        <tr>
                                            <td colspan="6">
                                                <button class="btn btn-primary" id="addUser">新規</button>
                                                <button class="btn btn-primary" id="updateUser">修正</button>
                                                <button class="btn btn-primary pull-right" id="deleteUser">削除</button>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>

                        <label>詳細情報</label>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="userListTable">
                                <tbody>
                                   <tr>
                                        <th width='20%' class='pink' >親ユーザー：</th>
                                        <td>
                                            <select id='parentSelect' class='form-control'>
                                            <?php
                                            $tmp = '';
                                            $sql = "SELECT * FROM user WHERE authority in (0,1) and status='0' order by authority";
                                            $tmp = $pdo->prepare($sql);
                                            $tmp->execute();
                                            foreach ($tmp as $tmprow) {
                                                echo "<option value='".$tmprow['userId']."'>".$tmprow['userId']."</option>";
                                            }
                                            ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%" class='pink' >ユーザ名：</th>
                                        <td>
                                            <input type="text" class="form-control input-normal userName">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%" class='pink' >パスワード：</th>
                                        <td>
                                            <input type="text" class="form-control input-normal password">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%" class='pink' >権限：</th>
                                        <td>
                                            <select id="roleSelect" class="form-control">
                                                <option value="0">0: 管理者</option>
                                                <option value="1">1: ユーザー</option>
                                                <option value="2" selected>2: ワーカー</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%" class='pink' >備考：</th>
                                        <td>
                                            <input type="text" class="form-control input-normal etc" maxlength=20 >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <button class="btn btn-primary pull-right" id="register" style="margin-left:5px">登録</button>
                                            <button class="btn btn-primary pull-right" id="reset">キャンセル</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- /container -->

		<p id="page-top"><a href="#wrap">PAGE TOP</a></p>
        <br>
        <br>
        <br>
        <br>
        <footer class="footer">
            <div class="container">
                <p class="text-muted">Create by <a href="http://wml37.com/" target="_blank">ウェブマーケティングLab37</a> 2017.</p>
            </div>
        </footer>


    </body>

    </html>
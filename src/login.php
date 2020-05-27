<?php
include("./func_db.php");

if (isset($_POST["userId"])&&isset($_POST["password"])) {
//    ini_set( 'display_errors', 1 );
//    error_reporting( E_ALL );
    try {

        $_connect=initDB();
        $pdo = new PDO(
            'mysql:host='.$_connect['host'].';dbname='.$_connect['db'].';charset=utf8',$_connect['user'],$_connect['pass']
            ,array(PDO::ATTR_EMULATE_PREPARES => false)
        );

        $sql = "SELECT * FROM user WHERE userId = :userId AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array($_POST["userId"], $_POST["password"]));
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            $status = $row["status"];
            if($status == 0){
                session_start();
                $_SESSION["userId"] = $_POST["userId"];
                $_SESSION["authority"] = $row["authority"];
                $_SESSION["password"] = $row["password"];
                header("Location: main.php");
                exit();
            }else{
                //exit('ユーザー名またはパスワードが一致しません。');
                echo "<script>";
                echo "alert('ユーザー名またはパスワードが一致しません。');";
                echo "</script>";
            }
        }
        //exit('ユーザー名またはパスワードが一致しません。');
        echo "<script>";
        echo "alert('ユーザー名またはパスワードが一致しません。');";
        echo "</script>";

    } catch (PDOException $e) {
        exit('データベース接続失敗。'.$e->getMessage());
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

        <title>login</title>

        <!-- Bootstrap core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/signin.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>

    <body onload=''>

        <div class="container">

            <form class="form-signin" action = "login.php" method = "post">
                <!-- <h2 class="form-signin-heading">ユーザ管理&nbsp;システム</h2> -->
                <h2 class="form-signin-heading">AssistYoutuberTools</h2>
                <br>
                <p class="subTitle">Have an account? Sign In</p>
                <label for="userId" class="sr-only">User ID</label>
                <input type="text" name = "userId" class="form-control" placeholder="User ID" required autofocus>
                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" name ="password" class="form-control" placeholder="Password" required>
                <br>
                <input type = "submit" name="login" class="btn btn-lg btn-primary btn-block" style='background:red;border:none;' value="Login">
            </form>

        </div>
        <!-- /container -->

        <footer class="footer">
            <div class="container">
                <p class="text-muted">Create by <a href="http://wml37.com/" target="_blank">ウェブマーケティングLab37</a> 2017.</p>
            </div>
        </footer>


        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
        <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
    </body>
    </html>
<?php
  session_start(); //セッション開始



  if (isset($_SESSION['id'])){
      //セッションにユーザIDがある＝ログインしている
      //トップページに移動する
      header('Location: index.php');

  } else if (isset($_POST['name']) && isset($_POST['password'])){ //ログインしていないがユーザ名とパスワードが送信された時

    $dsn = 'mysql:host=localhost;dbname=tennis;charset=utf8';
    $user = 'tennisuser';
    $password = 'password';

    try {
        $db = new PDO($dsn, $user, $password);
     
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $db->prepare("SELECT * FROM users WHERE name=:name AND password=:pass");

        $stmt->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
        $stmt->bindParam(':pass', sha1($_POST['password']), PDO::PARAM_STR);

        $stmt->execute();


        if($row = $stmt->fetch()){
            //ユーザが存在していたので、セッションにIDをセット
            $_SESSION['id'] = $row['id'];
            header('Location: index.php');
            exit();
        } else {
            header('Location: login.php');
            exit();
        }
    } catch(PDOException $e){
        die ('エラー:' . $e->getMessage());
    }
  } else {
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;" charset="UTF-8">
    <title>テニスサークル交流サイト</title>
</head>
<body>
    <h1>テニスサークル</h1>

    <h2>ログイン</h2>
    <form action="login.php" method="post">
      <p>ユーザ名：<input type="text" name='name'></p>
      <p>パスワード：<input type="password" name="password"></p>
      <p><input type="submit" value="ログイン"></p>
      </form>
</body>
</html>
<?php } ?>
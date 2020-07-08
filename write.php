<?php
include 'includes/login.php';

//データの受け取り
$name = $_POST['name'];
$title = $_POST['title'];
$body = $_POST['body'];
$pass - $_POST['pass'];
$token = $_POST['token'];

//必須項目チェック（名前か本文が空ではないか？）
if ($name == '' || $body == ''){
    header('Location: bbs.php'); //bbs.phpへ移動
    exit(); //終了
}

//必須項目チェック（パスワードは４桁の数字か？）
if (!preg_match("/^[0-9]{4}$/",$pass)){
    header('Location: bbs.php');
    exit();
}
if ($token !=sha1(session_id())){
    header('Location: bbs.php');
    exit();
}

//名前にクッキーをセット
setcookie('name', $name, time() + 60 * 60 * 24 * 30);

//データベースに接続
$dsn = 'mysql:host=localhost;dbname=tennis;charset=utf8';
$user = 'tennisuder';
$password = 'password'; //tennisuserに設定したパスワード

try{
    $db = new PDO($dsn, $user, $password); //インスタンス作成処理
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //セキュリティ高めてる(SQLインジェクション)
    //プリペアドステートメントを作成
    //PDO::prepare — 文を実行する準備を行い、文オブジェクトを返す
    $stmt = $db->prepare("
      INSERT INTO bbs (name, title, body, date, pass)
      VALUES (:name, :title, :body, now(), :pass)"); //テーブル名BBS
    //パラメーターを割当
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':body', $body, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    //クエリの実行
    $stmt->execute(); //このオブジェクトのこの関数を使うということ表してる
    
    //bbs.phpに戻る
    header('Location:bbs.php');
    exit();
}catch (PDOException $e){ //例外なら別の処理を行うってイメージ(Throw)
    die('エラー：' . $e->getMessage());
}
?>
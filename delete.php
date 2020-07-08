<?php
  include 'includes/login.php';
  //データの受け取り
  $id = intval($_POST['id']);
  $pass = $_pass['pass'];
  $token = $_POST['token'];

  //必須項目チェック
    if ($id == '' || $pass ==''){
        header('Location: bbs.php');
        exit();
    }
    if ($token != sha1(session_id())){
        header('Location: bbs.php');
        exit();
    }

    $dsn = 'mysql:host=localhost;dbname=tennis;charset=utf8';
    $user = 'tennisuser';
    $password = 'password';

    try{
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $stmt = $db->prepare(
            "DELETE FROM bbs WHERE id=:id AND pass=:pass" //テーブルから削除
        );

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);

        $stmt->execute();
    } catch(PDOException $e){
        echo "エラー：" . $e->getMessage();
    }
    header("Location: bbs.php");
    exit();
?>
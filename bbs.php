<?php
//１ページに表示させるコメントの数
  $num = 10;

  //データベースに接続
  $dsn = 'mysql:host=localhost;dbname=tennis;charset=utf8';
  $user = 'tennisuser';
  $password = 'password'; //tennisuserに接続したパスワード

  //ページ数が指定されている時
  $page = 0;
  if (isset($_GET['page']) && $_GET['page'] > 0){
      $page = intval($_GET['page']) -1; //マイナス１の値をページ数変数にいれる
  }

  try{
      $db = new PDO($dsn, $user, $password);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
      //プリペアドステートメントを作成
      $stmt = $db->prepare(
          "SELECT * FROM bbs ORDER BY date DESC LIMIT
          :page, :num"
      );
      //パラメーターを割当て
      $page = $page * $num;
      $stmt->bindParam(':page', $page, PDO::PARAM_INT); //数字埋め込むからPARAM_INT
      $stmt->bindParam(':num', $num, PDO::PARAM_INT);
      //クエリの実行！
      $stmt->execute();
  } catch (PDOException $e){
      echo "エラー:" . $e->getMessage();
  }

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>掲示板</title>
</head>
<body>
    <h1>掲示板</h1>
    <p><a href="index.php">トップページに戻る</a></p>
    <form action="write.php" method="post">
        <p>名前：<input type="text" name="name" value="<?php echo $_COOKIE['name']?>"></p>
        <p>タイトル：<input type="text" name="title"></p>
        <textarea name="body"></textarea>
        <p>削除パスワード（数字４桁）：<input type="text" name="pass"></p>
        <p><input type="submit" value="書き込む"></p>
        <input type="hidden" name="token" value="<?php echo sha1(session_id()); ?>">
    </form>

<?php
  while ($row = $stmt->fetch()): //レコード取得
    $title = $row['title'] ? $row['title'] : ' (無題) ';
?>
  <p>名前：<?php echo $row['name'] ?></p>
  <p>タイトル：<?php echo $title ?></p>
  <p><?php echo nl2br($row['body'], false) ?></p>
  <p><?php echo $row['date'] ?> </p>
  <form action="delete.php" method="post">
    <input type="hidden" name="id" value="<?php echo $row ['id']; ?>">
    削除パスワード：<input type="password" name="pass">
    <input type="submit" value="削除">
  </form>

<?php
  endwhile;

  //ページ数の表示
  try{
      $stmt = $db->prepare("SELECT COUNT(*) FROM bbs");
      //クエリの実行
      $stmt ->execute();
  } catch (PDOException $e){
      echo "エラー：" . $e->getMessage();
  }
  //コメントの件数を取得
  $comments = $stmt->fetchColumn();
  //ページ数を計算
  $max_page = ceil($comments / $num);
  echo '<p>';
  for ($i = 1; $i <= $max_page; $i++){
      echo '<a href="bbs.php?page=' . $i . '">' . $i . '</a>$nbsp';
  }
  echo '</p>';
?>
</body>
</html>
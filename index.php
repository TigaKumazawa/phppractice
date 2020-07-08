<?php
include 'includes/login.php'; //include 文は指定されたファイルを読み込み、評価します(ここではログイン)
  $fp = fopen("info-2.txt", "r");  //info-2のファイルを開く
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>テニスサークル交流サイト</title>
</head>
<body>
　　 <h1>テニスサークル交流サイト</h1>
    <h2>メニュー</h2>
    <p>
      <a href="album.php">アルバム</a>
      <a href="bbs.php">掲示板</a>
      <a href="logout.php">ログアウト</a>
    </p>
    
    <h2>お知らせ</h2>
    <?php
    //ファイルが正しく開けた時
    if ($fp){
        $title = fgets($fp);//info-2ファイルから１行読み込む
        //1行読み込めた時
        if ($title){
           echo '<a href="info.php">' . $title . '</a>';
        } else {
            //ファイルの中身が空だった時
            echo 'お知らせはありません';
        }
        fclose($fp);//ファイルを閉じる
    } else {
        //ファイルが開けなかった時
        echo 'お知らせはありません。';
    }
    ?>
</body>
</html>
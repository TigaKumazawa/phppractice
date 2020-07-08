<?php
  $image = array(); //画像ファイル名のリストを格納する配列
  $num = 5;

//画像ファイルから画像ファイル名を読み込む
  if ($handle = opendir('./album')){ //指定されたファイルを開きディレクトリハンドルを返す
      while ($entry = readdir($handle)){ //フォルダ内のファイルを読み込む(ファイルハンドル)
          //画像ファイル名だけを取得したいので
          //[.]か[..]でない時、ファイル名を配列に追加
          if ($entry != "." && $entry != ".."){
              $image[] = $entry;
          }
      }
      closedir($handle);
  }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>交流サイト：アルバム</title>
    </head>
    <body>
        <h1>交流サイト:アルバム</h1>
        <p>
            <a href="index.php">トップページに戻る</a>
            <a href="upload.php">写真をアップロードする</a>
        </p>
        <?php
      if (count($image) > 0){
          //指定枚数ごとに画像ファイル名を分割、配列を分割(array_chunk)
          $images = array_chunk($images, $num); //ここでは５分割
          //ページ数指定、基本は０ページ目を指す
          $page = 0;
          //GETでページ数が指定されていた場合（変数が定義させているか、変数が数値かどうか）
          if (isset($_GET['page']) && is_numeric($_GET['page'])){
              $page = intval($_GET['page']) -1;  //→ここで数字化してる
              if (!isset($image[$page])){ //指定させたページの要素があるかどうか確認(否定演算子)
                  $page = 0; //ない時は１ページ目に行く
              }
          }

          foreach ($image as $img){
              echo '<img src="./album/' . $img . '">'; //画像の表示
            } 
            echo '<p>';
            for ($i = 1; $i <= count($images); $i++){
                echo '<a href="album.php?page=' . $i .'">' . $i . '</a>&nbsp;'; //実態参照：直接記述できない文字列を指定
            }
            echo '<?p>';
        } else {
            echo '<p>画像はありません。</p>';
        }   
        ?>
    </body>
</html>
<?php
  $fp = fopen("info-2.txt", "r"); //ファイルを開く
  $line = array(); //ファイル内容を１行１要素に格納する配列
  //ファイルが開けた時
   if($fp){
       while(!feof($fp)){    //ファイルの終わりまでポインタが行ったかチェック（feof関数)
                             //正しくファイルが開けていることが条件
           $line[] = fgets($fp);
       }
       fclose($fp);
   }
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>テニスサークル交流サイト</title>
</head>
<body>
　　 <h1>テニスサークル交流サイト</h1>
    <h2>お知らせ</h2>
    <?php
      if (count($line) > 0){    //count(配列の変数名)返り値は数字(count関数)
          for ($si = 0; $i < count($line); $i++){
              if ($i == 0){   //初めの行はタイトル
                  echo '<h3>' . $line[0] . '<h3>';
              }else{
                  echo $line[$i] . '<br>';   //タイトルから下の文
              }
          }
          //ファイルの中身が空の時
      } else {
          echo 'お知らせはありません。';
      }
    ?>
</body>
</html>
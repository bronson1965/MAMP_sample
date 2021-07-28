<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<link href="styles/style.css?<?php echo date('Ymd-Hi'); ?>" rel="stylesheet">
<script src="js/main.js?<?php echo date('Ymd-Hi'); ?>"></script>
<title>データ編集画面</title>
</head>
<body bgcolor="#fee" link="#0000ff" vlink="#ff00ff" alink="#ff0000" onLoad="setFocus();">
<center>
<?php
    if(isset($_GET['flg'])) {   // 処理フラグ
        $flg = $_GET['flg']; 
    } else {
        die('flgが不明です。');
    }

    if($flg == 'upd') {         // 更新時
        if(isset($_GET['id'])) {
            $id = $_GET['id']; 
        } else {
            die('idが不明です。');
        }
    }

    print('<form action="./db_update.php" name="F1" method="post" target="_self">');

    if( $flg == 'add') {     // データ追加
        print('<h1>データ追加画面</h1>');
        print('<table cellpadding=2 cellspacing=1 border=1>');
        print('<th width=50>Id</th><th width=200>Name</th>');
        print('<tr>');
        print('<td align=center>新規</td>');
        print('<td><input type="text" name="name" value="" width="200"></td>');
        print('</tr>');
        print('</table>');
    } else {                // データ編集
        // mysqlに接続
        $link = mysqli_connect('localhost:8889','root','root','testDB');
        if (!$link) {
            die('接続失敗です。'.mysqli_error($link));
        }
        // print('<p>接続に成功しました。</p>');

        // DBの選択
        $db_selected = mysqli_select_db($link,'testDB');
        if (!$db_selected){
            die('データベース選択失敗です。'.mysqli_error($link));
        }
        // print('<p>testDB データベースを選択しました。</p>');

        // SQL文の発行
        $result = mysqli_query($link,'select * from users where id = '.$id);
        if (!$result) {
            die('クエリーが失敗しました。'.mysqli_error($link));
        }
        print('<h1>データ編集画面</h1>');
        print('<table cellpadding=2 cellspacing=1 border=1>');
        print('<th width=50>Id</th><th width=200>Name</th>');
        // 結果を連想配列に変換
        while ($row = mysqli_fetch_assoc($result)) {
            print('<tr>');
            print('<td align=center nowrap>'.$row['id'].'</td>');
            print('<td nowrap><input type="text" name="name" value="'.$row['name'].'" width="200"></td>');
            print('</tr>');
        }
        print('</table>');
        print('<input type="hidden" name="id" value="'.$id.'">');
        // close処理
        $close_flag = mysqli_close($link);
        if (!$close_flag){
            print('<p>切断に失敗しました。</p>');
        }
    }

    print('<input type="hidden" name="flg" value="'.$flg.'">');
    print('<p><input type="button" value=" 確　定 " onClick="sbmt();">&nbsp;&nbsp;');
    print('<input type="reset" value="リセット" onClick="setFocus();">&nbsp;&nbsp;');
    print('<input type="button" value=" 戻 る " onClick="goList();">');
    print('</form>');
?>
</center>
</body>
</html>

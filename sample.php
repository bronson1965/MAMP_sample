<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<link href="styles/style.css?<?php echo date('Ymd-Hi'); ?>" rel="stylesheet">
<script src="js/main.js?<?php echo date('Ymd-Hi'); ?>"></script>
<title>データ一覧画面</title>
</head>
<body link="#0000ff" vlink="#ff00ff" alink="#ff0000">
<center>
<?php
    // mysqlに接続
    $link = mysqli_connect('localhost:8889','root','root','testDB');
    if (!$link) {
        die('接続失敗です。'.mysqli_error($link));
    }

    // DBの選択
    $db_selected = mysqli_select_db($link,'testDB');
    if (!$db_selected){
        die('データベース選択失敗です。'.mysqli_error($link));
    }

    // SQL文の発行
    $result = mysqli_query($link,'select * from users');
    if (!$result) {
        die('クエリーが失敗しました。'.mysqli_error($link));
    }

    print('<h1>データ一覧画面</h1>');
    print('<table cellpadding=2 cellspacing=1 border=1>');
    print('<th width=50>ID</th><th width=200>Name</th><th width=220>DateTime</th><th width=30>Del</th>');
    // 結果を連想配列に変換
    while ($row = mysqli_fetch_assoc($result)) {
        print('<tr>');
        print('<td align=center nowrap><a href="./edit.php?id='.$row['id'].'&flg=upd">'.$row['id'].'</a></td>');
        print('<td nowrap>'.$row['name'].'</td>');
        print('<td align=center nowrap>'.$row['dt'].'</td>');
        print('<td align=center nowrap><a href="JavaScript:del('.$row['id'].');">✖</a></td>');
        print('</tr>');
    }
    print('</table>');
    print('<a href="./edit.php?flg=add" target="_self">データ追加</a>');

    // close処理
    $close_flag = mysqli_close($link);
    if (!$close_flag){
        print('<p>切断に失敗しました。</p>');
    }
?>
</center>
</body>
</html>

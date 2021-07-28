<?php
    function quote_smart($link,$value)
    {
        // 数値以外をクオートする
        if (!is_numeric($value)) {
            $value = "'" . mysqli_real_escape_string($link, $value) . "'";
        }
        return $value;
    }

    if(isset($_GET['flg'])) {   // 削除時
        if(isset($_GET['id'])) {
            $id = $_GET['id']; 
        } else {
            die('id が不明です。');
        }
        $flg = $_GET['flg']; 
    } else {                    // 追加、更新時
        if(isset($_POST['flg'])) {
            $flg = $_POST['flg']; 
        } else {
            die('flg が不明です。');
        }
        if($flg == 'upd') {
            if(isset($_POST['id'])) {
                $id = $_POST['id']; 
            } else {
                die('id が不明です。');
            }
        }
        if(isset($_POST['name'])) {
            $name = $_POST['name']; 
        } else {
            die('name が不明です。');
        }
    }

    // mysqlに接続
    $link = mysqli_connect('localhost:8889','root','root','testDB');
    if (!$link) {
        die('接続失敗です。'.mysqli_error());
    }

    // DBの選択
    $db_selected = mysqli_select_db($link,'testDB');
    if (!$db_selected){
        die('データベース選択失敗です。'.mysqli_error());
    }

    // 文字コード設定
    mysqli_set_charset($link,'utf8');

    // 日時取得
    $dt = date('Y-m-d H:i:s');

    switch ($flg){
    case 'add':     // 追加
        // SQL文の生成
        $sql = sprintf("INSERT INTO users ( name, dt ) VALUES ( %s, %s )", quote_smart($link,$name), quote_smart($link,$dt));
        break;
    case 'upd':     // 更新
        // SQL文の生成
        $sql = sprintf("UPDATE users SET name = %s, dt = %s WHERE id = %s", quote_smart($link,$name), quote_smart($link,$dt), quote_smart($link,$id));
        break;
    case 'del':     // 削除
        $sql = sprintf("DELETE FROM users WHERE id = %s", quote_smart($link,$id));
        break;
    default:
        break;
    }

    // SQL文の実行
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die('クエリーが失敗しました。'.mysqli_error($link));
    }

    // 既存データチェック
    $result = mysqli_query($link, 'SELECT count(*) AS cnt FROM users');
    $row = mysqli_fetch_assoc($result);
    $cnt = $row['cnt'];
    if ($cnt == 0) {
        $result = mysqli_query($link, 'ALTER TABLE users AUTO_INCREMENT=1');
    }

    // close処理
    $close_flag = mysqli_close($link);
    if (!$close_flag){
        print('<p>切断に失敗しました。</p>');
    }

    // 一覧画面へ遷移
    header('Location: sample.php');
?>

function del(id) {
    if(confirm('ID: '+id+' のデータを削除しますか？')) {
        window.location.href = './db_update.php?id='+id+'&flg=del';
    }
}
function setFocus() {
    document.F1.name.focus();
}
function sbmt() {
    if (document.F1.name.value.length == 0) {
        alert('Name は必ず入力して下さい！')
        document.F1.name.focus();
    } else {
        document.F1.submit();
    }
}
function goList() {
    window.location.href = './sample.php';
}

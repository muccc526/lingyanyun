<?php
include('../confing/function.php');
if (!$DB->link) {
    die("连接失败: " . $DB->error());
} else {
    echo "redis连通成功，数据库链接成功\r\n";
}

$sql = "DELETE FROM qingka_wangke_user WHERE zcz = 0";//删除总充值为0的用户
if ($DB->query($sql) === TRUE) {
    $deletedRows = $DB->affected();
    echo "本次已成功删除 $deletedRows 个 0 充值用户。";
} else {
    echo "删除数据时出错: " . $DB->error();
}

$DB->close();
?>
<?php
include('../confing/common.php');
$redis = new Redis();
$redis->connect("127.0.0.1", "6379");
$redis->select(6);

echo "连通redis： " . $redis->ping() . "\r\n";

$length = $redis->LLEN('oidblpt');

if ($length == 0) {
    $count = 0;
    $orders = $DB->query("select * from qingka_wangke_order where dockstatus=1 and status!= '已完成' and status!= '平时分' and status!= '已暂停' and status!= '待考试' and status!= '平时分中' and status!= '待处理' and status!='上号中' and status!='已提交' and status!='补刷中' and status!='等待下周' and status!='进行中' order by oid asc");

    foreach ($orders as $order) {
        $addtime = strtotime($order['addtime']);
        $currentTime = strtotime(date("Y-m-d H:i:s"));

        // 判断订单下单时间是否超过30天
        if (($currentTime - $addtime) <= (30 * 24 * 60 * 60)) {
            $redis->lPush("oidblpt", $order['oid']);
            $count++;
        }
    }

    echo "入队成功！本次入队订单共计：" . $count . "条\r\n";
} else {
    echo "失败，当前队列池中还有：" . $redis->LLEN('oidblpt') . "条订单正在执行\r\n";
}
?>

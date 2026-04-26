<?php
include('confing/common.php');
$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;
@header('Content-Type: application/json; charset=UTF-8');

switch ($act) {
    case 'kmlist': // 卡密列表
        if ($userrow['uid'] != 1) {
            jsonReturn(-1, "您暂无此权限");
        }
        
        // 接收分页和筛选参数
        $keyword = isset($_GET['keyword']) ? daddslashes($_GET['keyword']) : '';
        $status = isset($_GET['status']) ? daddslashes($_GET['status']) : 'all';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $pageSize = isset($_GET['pageSize']) ? intval($_GET['pageSize']) : 15; // 接收 pageSize 参数
        $offset = ($page - 1) * $pageSize;
        
        // 构建查询条件
        $where = [];
        if (!empty($keyword)) {
            $where[] = "content LIKE '%{$keyword}%'";
        }
        if ($status !== 'all') {
            $status = intval($status);
            $where[] = "status = {$status}";
        }
        $where_sql = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
        
        // 获取总数
        $total = $DB->get_row("SELECT COUNT(*) AS total FROM qingka_wangke_km {$where_sql}");
        
        // 获取数据
        $sql = "SELECT * FROM qingka_wangke_km {$where_sql} ORDER BY id DESC LIMIT {$offset}, {$pageSize}";
        $a = $DB->query($sql);
        
        $data = [];
        while ($row = $DB->fetch($a)) {
            $data[] = array(
                'id' => $row['id'],
                'content' => $row['content'],
                'money' => $row['money'],
                'status' => $row['status'],
                'uid' => $row['uid'],
                'addtime' => $row['addtime'],
                'usedtime' => $row['usedtime']
            );
        }
        
        $result = array(
            'code' => 1,
            'msg' => '获取成功',
            'data' => $data,
            'total' => $total['total'],
            'page' => $page,
            'total_page' => ceil($total['total'] / $pageSize)
        );
        exit(json_encode($result));
        break;
    case 'addkm': // 添加卡密
        $content = trim(strip_tags(daddslashes($_POST['content'])));
        $money = floatval(trim(strip_tags(daddslashes($_POST['money']))));
        if ($userrow['uid'] != 1) {
            jsonReturn(-1, "您暂无此权限");
        }
        if ($content == '') {
            exit('{"code": -1, "msg": "卡密不能为空"}');
        }
        if ($money == '') {
            exit('{"code": -1, "msg": "卡密的余额不能为空"}');
        }
        $ishas = $DB->get_row("select * from qingka_wangke_km where content='$content' limit 1");
        if ($ishas) {
            exit('{"code": -1, "msg": "该卡密已存在"}');
        }

        // 获取管理员余额
        $admin = $DB->get_row("select * from qingka_wangke_user where uid='1' limit 1");
        $adminBalance = floatval($admin['money']);
        if ($adminBalance < $money) {
            exit('{"code": -1, "msg": "管理员余额不足，无法生成该卡密"}');
        }

        $DB->query("insert into qingka_wangke_km (content, money, status, addtime) values ('$content', '$money', 0, NOW())");
        // 扣除管理员余额
        $newBalance = $adminBalance - $money;
        $DB->query("update qingka_wangke_user set money='$newBalance' where uid='1' ");

        $data = array(
            'code' => 1,
            'msg' => '添加成功',
            'content' => $content
        );
        exit(json_encode($data));
        break;
    case 'getAdminBalance': // 获取管理员余额
        if ($userrow['uid'] != 1) {
            jsonReturn(-1, "您暂无此权限");
        }
        $admin = $DB->get_row("select * from qingka_wangke_user where uid='1' limit 1");
        $adminBalance = floatval($admin['money']);
        $data = array(
            'code' => 1,
            'msg' => '获取成功',
            'balance' => $adminBalance
        );
        exit(json_encode($data));
        break;
    case 'querykm': // 查询卡密
        $content = trim(strip_tags(daddslashes($_POST['content'])));
        if ($content == '') {
            exit('{"code": -1, "msg": "卡密不能为空"}');
        }
        $a = $DB->query("select * from qingka_wangke_km where content='$content' ");
        while ($row = $DB->fetch($a)) {
            $data[] = array(
                'id' => $row['id'],
                'content' => $row['content'],
                'money' => $row['money'],
                'status' => $row['status'],
                'uid' => $row['uid'],
                'addtime' => $row['addtime'],
                'usedtime' => $row['usedtime']
            );
        }
        if ($data == null) {
            exit('{"code": -1, "msg": "卡密不存在"}');
        }
        $data = array('code' => 1, 'msg' => '查询成功', 'data' => $data);
        exit(json_encode($data));
        break;
    case 'paykm': // 使用卡密
        $content = trim(strip_tags(daddslashes($_POST['content'])));
        $uid = trim(strip_tags(daddslashes($_POST['uid']))) ? trim(strip_tags(daddslashes($_POST['uid']))) : $userrow['uid'];
        if ($content == '') {
            exit('{"code": -1, "msg": "卡密不能为空"}');
        }
        if ($uid == '') {
            exit('{"code": -1, "msg": "给谁充值啊？"}');
        }
        $km = $DB->get_row("select * from qingka_wangke_km where content='$content' limit 1");
        if (!$km) {
            exit('{"code": -1, "msg": "卡密不存在"}');
        }
        if ($km['status'] != 0) {
            exit('{"code": -1, "msg": "该卡密已被使用过了"}');
        }
        $user = $DB->get_row("select * from qingka_wangke_user where uid='$uid' limit 1");
        if ($user['active'] != '1') {
            exit('{"code": -1, "msg": "该用户账户状态异常，无法进行充值"}');
        }
        $kmmoney = round($km['money'], 2);
        $useradd = round($user['money'] + $kmmoney, 2);

        // 去掉管理员扣费操作
        // $DB->query("update qingka_wangke_user set money=money-'$kmmoney' where uid='1' "); 

        $DB->query("update qingka_wangke_user set money='$useradd', zcz=zcz+'$useradd' where uid='$uid' "); // 下级增加    
        wlog(1, "卡密充值", "使用卡密成功给uid为{$uid}的靓仔充值{$kmmoney}元", -$kmmoney);
        wlog($uid, "卡密充值", "您使用站长的卡密成功充值{$kmmoney}元", +$kmmoney);

        // 设置卡密状态
        $DB->query("update qingka_wangke_km set `status` = 1, `uid` = '$uid', `usedtime` = NOW() where id = '{$km['id']}' ");
        $data = array(
            'code' => 1,
            'msg' => '使用成功',
            'uid' => $uid,
            'name' => $user['name'],
            'usermoney' => $useradd,
            'kmmoney' => $km['money']
        );
        exit(json_encode($data));
        break;
    case 'deletekm': // 删除卡密
        $id = trim(strip_tags(daddslashes($_POST['id'])));
        if ($userrow['uid'] != 1) {
            jsonReturn(-1, "您暂无此权限");
        }
        if ($id == '') {
            exit('{"code": -1, "msg": "卡密不能为空"}');
        }
        $DB->query("delete from qingka_wangke_km where id='$id' ");
        $data = array(
            'code' => 1,
            'msg' => '删除成功'
        );
        exit(json_encode($data));
        break;
    case 'deleteSelectedKm': // 删除选中卡密
        if ($userrow['uid'] != 1) {
            jsonReturn(-1, "您暂无此权限");
        }
        $ids = isset($_POST['ids']) ? $_POST['ids'] : [];
        if (empty($ids)) {
            exit('{"code": -1, "msg": "请选择要删除的卡密"}');
        }
        $idStr = implode(',', array_map('intval', $ids));
        $DB->query("DELETE FROM qingka_wangke_km WHERE id IN ($idStr)");
        $data = array(
            'code' => 1,
            'msg' => '删除选中卡密成功'
        );
        exit(json_encode($data));
        break;
    case 'exportKm': // 导出卡密
        if ($userrow['uid'] != 1) {
            jsonReturn(-1, "您暂无此权限");
        }
        $a = $DB->query("SELECT * FROM qingka_wangke_km ORDER BY id DESC");
        $csvData = [];
        $csvData[] = ['ID', '卡号', '卡密金额', '使用者ID', '添加时间', '使用时间', '状态'];
        while ($row = $DB->fetch($a)) {
            $statusText = $row['status'] == 1 ? '已使用' : '未使用';
            $csvData[] = [
                $row['id'],
                $row['content'],
                $row['money'],
                $row['uid'],
                $row['addtime'],
                $row['usedtime'],
                $statusText
            ];
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="km_export.csv"');
        $output = fopen('php://output', 'w');
        foreach ($csvData as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit;
        break;
}

?>    
<?php
require_once dirname(__FILE__) . '/functions.php';

function custom_goods_api_auth()
{
    global $DB;
    $uid = trim(strip_tags(daddslashes($_POST['uid'])));
    if ($uid == '') {
        $uid = trim(strip_tags(daddslashes($_REQUEST['uid'])));
    }
    $key = trim(strip_tags(daddslashes($_POST['key'])));
    if ($key == '') {
        $key = trim(strip_tags(daddslashes($_REQUEST['key'])));
    }
    if ($uid == '' || $key == '') {
        exit('{"code":0,"msg":"所有项目不能为空"}');
    }
    $row = $DB->get_row("select * from qingka_wangke_user where uid='{$uid}' limit 1");
    if (!$row || $row['key'] == '0') {
        exit('{"code":-1,"msg":"你还没有开通接口哦"}');
    }
    if ($row['key'] != $key) {
        exit('{"code":-2,"msg":"密匙错误"}');
    }
    return $row;
}

function custom_goods_api_getclass($user)
{
    $only_id = 0;
    if (isset($_REQUEST['cid']) && custom_goods_is_platform($_REQUEST['cid'])) {
        $only_id = custom_goods_id_from_platform($_REQUEST['cid']);
    }
    return custom_goods_get_public_list($user, $only_id);
}

function custom_goods_api_add_if_needed()
{
    $platform = isset($_POST['platform']) ? trim($_POST['platform']) : '';
    if (!custom_goods_is_platform($platform)) {
        return false;
    }
    $user = custom_goods_api_auth();
    $quantity = isset($_POST['quantity']) ? floatval($_POST['quantity']) : 1;
    if ($quantity <= 0) {
        $quantity = 1;
    }
    $input_data = array();
    if (isset($_POST['input_data']) && $_POST['input_data'] !== '') {
        $json = json_decode($_POST['input_data'], true);
        if (is_array($json)) {
            $input_data = $json;
        }
    }
    $goods_id = custom_goods_id_from_platform($platform);
    global $DB;
    $goods = $DB->get_row("select * from qingka_custom_goods where id='{$goods_id}' and status=1 limit 1");
    if ($goods) {
        $config = custom_goods_decode_input_config($goods['input_config']);
        foreach ($config['fields'] as $field) {
            if (isset($field['name']) && isset($_POST[$field['name']])) {
                $input_data[$field['name']] = $_POST[$field['name']];
            }
        }
    }
    $result = custom_goods_submit_order($user, $platform, $input_data, $quantity);
    $api = array(
        'code' => $result['code'] == 1 ? 0 : -1,
        'msg' => $result['msg'],
        'status' => $result['code'] == 1 ? 0 : -1,
        'message' => $result['msg']
    );
    if (isset($result['id'])) {
        $api['id'] = 'custom_' . $result['id'];
    }
    exit(json_encode($api, JSON_UNESCAPED_UNICODE));
}

function custom_goods_api_chadan_if_needed()
{
    global $DB;
    $raw_oid = isset($_REQUEST['oid']) ? trim($_REQUEST['oid']) : '';
    if (!custom_goods_is_platform($raw_oid)) {
        return false;
    }
    $oid = custom_goods_id_from_platform($raw_oid);
    $order = $DB->get_row("select * from qingka_custom_goods_order where id='{$oid}' limit 1");
    if (!$order) {
        exit('{"code":-1,"msg":"未查到订单"}');
    }
    $result = custom_goods_query_order(1, $oid);
    if ($result['code'] != 1) {
        exit(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
    $data = array();
    foreach ($result['data'] as $row) {
        $data[] = array(
            'id' => 'custom_' . $row['id'],
            'ptname' => '自定义商品',
            'school' => '',
            'name' => $row['goods_name'],
            'user' => '',
            'kcname' => $row['goods_name'],
            'addtime' => $row['addtime'],
            'status' => $row['status'],
            'process' => $row['process'],
            'remarks' => $row['remarks']
        );
    }
    exit(json_encode(array('code' => 1, 'data' => $data), JSON_UNESCAPED_UNICODE));
}
?>

<?php
require_once dirname(__FILE__) . '/config.php';

function custom_goods_json($code, $msg, $extra = array())
{
    exit(json_encode(array_merge(array('code' => $code, 'msg' => $msg), $extra), JSON_UNESCAPED_UNICODE));
}

function custom_goods_escape($value)
{
    if (is_array($value)) {
        $data = array();
        foreach ($value as $key => $item) {
            $data[$key] = custom_goods_escape($item);
        }
        return $data;
    }
    return daddslashes(trim((string)$value));
}

function custom_goods_is_platform($platform)
{
    return preg_match('/^custom_[0-9]+$/', (string)$platform);
}

function custom_goods_table_exists($table)
{
    global $DB;
    $table = custom_goods_escape($table);
    $row = $DB->get_row("show tables like '{$table}'");
    return $row ? true : false;
}

function custom_goods_id_from_platform($platform)
{
    return intval(str_replace('custom_', '', (string)$platform));
}

function custom_goods_get_config()
{
    global $DB;
    if (!custom_goods_table_exists('qingka_custom_goods_config')) {
        return array('id' => 0, 'baseurl' => '', 'uid' => '', 'api_key' => '', 'status' => 1);
    }
    $row = $DB->get_row("select * from qingka_custom_goods_config order by id asc limit 1");
    if (!$row) {
        return array('id' => 0, 'baseurl' => '', 'uid' => '', 'api_key' => '', 'status' => 1);
    }
    return $row;
}

function custom_goods_normalize_baseurl($baseurl)
{
    $baseurl = trim($baseurl);
    return rtrim($baseurl, '/');
}

function custom_goods_upstream_request($act, $data = array())
{
    $config = custom_goods_get_config();
    if ($config['baseurl'] == '' || $config['uid'] == '' || $config['api_key'] == '') {
        return array('code' => -1, 'msg' => '请先配置上游接口');
    }
    $data['uid'] = $config['uid'];
    $data['key'] = $config['api_key'];
    $url = custom_goods_normalize_baseurl($config['baseurl']) . '/api.php?act=' . $act;
    $result = get_url($url, $data);
    $json = json_decode($result, true);
    if (!is_array($json)) {
        return array('code' => -1, 'msg' => '上游返回不是有效JSON', 'raw' => $result);
    }
    return $json;
}

function custom_goods_decode_input_config($input_config)
{
    if (is_array($input_config)) {
        $config = $input_config;
    } else {
        $raw = trim((string)$input_config);
        $candidates = array(
            $raw,
            stripslashes($raw),
            html_entity_decode($raw, ENT_QUOTES, 'UTF-8'),
            stripslashes(html_entity_decode($raw, ENT_QUOTES, 'UTF-8'))
        );
        $config = null;
        foreach ($candidates as $candidate) {
            if ($candidate === '') {
                continue;
            }
            $decoded = json_decode($candidate, true);
            if (is_string($decoded)) {
                $decoded = json_decode($decoded, true);
            }
            if (is_array($decoded)) {
                $config = $decoded;
                break;
            }
        }
    }
    if (!is_array($config)) {
        return array('fields' => array(), 'price_rule' => array('factors' => array('count')));
    }
    if (!isset($config['fields']) || !is_array($config['fields'])) {
        $config['fields'] = array();
        if (isset($config['inputs']) && is_array($config['inputs'])) {
            foreach ($config['inputs'] as $field) {
                if (!is_array($field)) {
                    continue;
                }
                if (!isset($field['type']) || $field['type'] == '') {
                    $field['type'] = 'text';
                }
                if (!isset($field['options']) || !is_array($field['options'])) {
                    $field['options'] = array();
                }
                $config['fields'][] = $field;
            }
        }
        if (isset($config['selects']) && is_array($config['selects'])) {
            foreach ($config['selects'] as $field) {
                if (!is_array($field)) {
                    continue;
                }
                $field['type'] = 'select';
                if (!isset($field['label']) || $field['label'] == '') {
                    $field['label'] = isset($field['name']) ? $field['name'] : '选项';
                }
                if (!isset($field['tips'])) {
                    $field['tips'] = '';
                }
                if (!isset($field['options']) || !is_array($field['options'])) {
                    $field['options'] = array();
                }
                $config['fields'][] = $field;
            }
        }
    }
    $config['fields'] = array_values($config['fields']);
    if (!isset($config['price_rule']) || !is_array($config['price_rule'])) {
        $config['price_rule'] = array('factors' => array('count'));
    }
    if (!isset($config['price_rule']['factors']) || !is_array($config['price_rule']['factors'])) {
        $config['price_rule']['factors'] = array('count');
    }
    return $config;
}

function custom_goods_user_unit_price($goods, $user)
{
    $price = floatval($goods['price']);
    $addprice = floatval($user['addprice']) * 5;
    if ($goods['yunsuan'] == '+') {
        return round($price + $addprice, 2);
    }
    return round($price * $addprice, 2);
}

function custom_goods_total_price($goods, $user, $quantity, $input_data)
{
    $unit = custom_goods_user_unit_price($goods, $user);
    $config = custom_goods_decode_input_config($goods['input_config']);
    $field_types = array();
    foreach ($config['fields'] as $field) {
        if (isset($field['name'])) {
            $field_types[$field['name']] = isset($field['type']) ? $field['type'] : 'text';
        }
    }
    $total = $unit;
    $factors = $config['price_rule']['factors'];
    if (!$factors) {
        $factors = array('count');
    }
    foreach ($factors as $factor) {
        if ($factor == 'count') {
            $total *= max(1, floatval($quantity));
            continue;
        }
        $type = isset($field_types[$factor]) ? $field_types[$factor] : '';
        if (($type == 'integer' || $type == 'decimal') && isset($input_data[$factor])) {
            $total *= max(0, floatval($input_data[$factor]));
        }
    }
    return array('unit_price' => $unit, 'total_price' => round($total, 2));
}

function custom_goods_validate_input($goods, $input_data)
{
    $config = custom_goods_decode_input_config($goods['input_config']);
    foreach ($config['fields'] as $field) {
        $name = isset($field['name']) ? $field['name'] : '';
        $label = isset($field['label']) ? $field['label'] : $name;
        if ($name == '') {
            continue;
        }
        if (!isset($input_data[$name]) || trim((string)$input_data[$name]) === '') {
            return array('code' => -1, 'msg' => $label . '不能为空');
        }
        $type = isset($field['type']) ? $field['type'] : 'text';
        if ($type == 'integer' && !preg_match('/^-?[0-9]+$/', (string)$input_data[$name])) {
            return array('code' => -1, 'msg' => $label . '必须为整数');
        }
        if ($type == 'decimal' && !is_numeric($input_data[$name])) {
            return array('code' => -1, 'msg' => $label . '必须为数字');
        }
    }
    return array('code' => 1, 'msg' => 'ok');
}

function custom_goods_get_public_list($user, $only_id = 0)
{
    global $DB;
    if (!custom_goods_table_exists('qingka_custom_goods')) {
        return array();
    }
    $where = "where status=1";
    if ($only_id > 0) {
        $where .= " and id='{$only_id}'";
    }
    $data = array();
    $query = $DB->query("select * from qingka_custom_goods {$where} order by sort asc,id desc");
    while ($row = $DB->fetch($query)) {
        $price = custom_goods_user_unit_price($row, $user);
        $data[] = array(
            'sort' => $row['sort'],
            'cid' => 'custom_' . $row['id'],
            'kcid' => $row['id'],
            'name' => $row['name'],
            'noun' => '自定义商品',
            'price' => $price,
            'fenlei' => 'custom',
            'content' => $row['content'],
            'input_config' => $row['input_config'],
            'input_config_data' => custom_goods_decode_input_config($row['input_config']),
            'status' => $row['status'],
            'miaoshua' => 0
        );
    }
    return $data;
}

function custom_goods_sync_from_upstream()
{
    global $DB, $date;
    if (!custom_goods_table_exists('qingka_custom_goods')) {
        return array('code' => -1, 'msg' => '请先导入 custom_goods/install.sql');
    }
    $result = custom_goods_upstream_request('getclass');
    if (!isset($result['code']) || $result['code'] != 1 || !is_array($result['data'])) {
        return array('code' => -1, 'msg' => isset($result['msg']) ? $result['msg'] : '上游商品获取失败');
    }
    $count = 0;
    foreach ($result['data'] as $item) {
        $input_config = isset($item['input_config']) ? $item['input_config'] : '';
        if (is_array($input_config)) {
            $input_config = json_encode($input_config, JSON_UNESCAPED_UNICODE);
        }
        $cid = isset($item['cid']) ? $item['cid'] : '';
        if ($input_config == '' || !preg_match('/^custom_[0-9]+$/', $cid)) {
            continue;
        }
        $name = custom_goods_escape(isset($item['name']) ? $item['name'] : '');
        $content = custom_goods_escape(isset($item['content']) ? $item['content'] : '');
        $decoded_config = custom_goods_decode_input_config($input_config);
        if (empty($decoded_config['fields'])) {
            continue;
        }
        $input_config = custom_goods_escape(json_encode($decoded_config, JSON_UNESCAPED_UNICODE));
        $cid = custom_goods_escape($cid);
        $price = floatval(isset($item['price']) ? $item['price'] : 0);
        $old = $DB->get_row("select * from qingka_custom_goods where upstream_cid='{$cid}' limit 1");
        if ($old) {
            $DB->query("update qingka_custom_goods set name='{$name}',content='{$content}',input_config='{$input_config}',upstream_price='{$price}',updatetime='{$date}' where id='{$old['id']}'");
        } else {
            $DB->query("insert into qingka_custom_goods (upstream_cid,name,content,input_config,upstream_price,price,yunsuan,sort,status,addtime,updatetime) values ('{$cid}','{$name}','{$content}','{$input_config}','{$price}','{$price}','*','10','0','{$date}','{$date}')");
        }
        $count++;
    }
    return array('code' => 1, 'msg' => "同步完成，共处理{$count}个自定义商品");
}

function custom_goods_submit_order($user, $platform, $input_data, $quantity = 1)
{
    global $DB, $date, $clientip;
    if (!custom_goods_table_exists('qingka_custom_goods_order')) {
        return array('code' => -1, 'msg' => '请先导入 custom_goods/install.sql');
    }
    $goods_id = custom_goods_id_from_platform($platform);
    $goods = $DB->get_row("select * from qingka_custom_goods where id='{$goods_id}' and status=1 limit 1");
    if (!$goods) {
        return array('code' => -1, 'msg' => '商品不存在或已下架');
    }
    $check = custom_goods_validate_input($goods, $input_data);
    if ($check['code'] != 1) {
        return $check;
    }
    $price = custom_goods_total_price($goods, $user, $quantity, $input_data);
    if ($price['unit_price'] <= 0 || floatval($user['addprice']) < 0.1) {
        return array('code' => -1, 'msg' => '价格异常，禁止下单');
    }
    if (floatval($user['money']) < $price['total_price']) {
        return array('code' => -1, 'msg' => '余额不足');
    }
    $upstream = custom_goods_upstream_request('add', array(
        'platform' => $goods['upstream_cid'],
        'quantity' => $quantity,
        'input_data' => json_encode($input_data, JSON_UNESCAPED_UNICODE)
    ));
    if (!isset($upstream['code']) || !in_array((string)$upstream['code'], array('0', '1'), true)) {
        return array('code' => -1, 'msg' => isset($upstream['msg']) ? $upstream['msg'] : (isset($upstream['message']) ? $upstream['message'] : '上游下单失败'), 'upstream' => $upstream);
    }
    $upstream_oid = '';
    if (isset($upstream['id'])) {
        $upstream_oid = $upstream['id'];
    } elseif (isset($upstream['oid'])) {
        $upstream_oid = $upstream['oid'];
    } elseif (isset($upstream['data']['id'])) {
        $upstream_oid = $upstream['data']['id'];
    }
    $input_json = custom_goods_escape(json_encode($input_data, JSON_UNESCAPED_UNICODE));
    $upstream_oid = custom_goods_escape($upstream_oid);
    $quantity = floatval($quantity) > 0 ? floatval($quantity) : 1;
    $DB->query("insert into qingka_custom_goods_order (uid,goods_id,upstream_cid,upstream_oid,input_data,quantity,unit_price,total_price,upstream_price,status,process,remarks,addtime,updatetime) values ('{$user['uid']}','{$goods['id']}','{$goods['upstream_cid']}','{$upstream_oid}','{$input_json}','{$quantity}','{$price['unit_price']}','{$price['total_price']}','{$goods['upstream_price']}','待处理','','','{$date}','{$date}')");
    $row = $DB->get_row("select last_insert_id() as id");
    $oid = $row ? $row['id'] : '';
    $DB->query("update qingka_wangke_user set money=money-'{$price['total_price']}' where uid='{$user['uid']}' limit 1");
    wlog($user['uid'], '自定义商品下单', "{$goods['name']} 扣除{$price['total_price']}积分", -$price['total_price']);
    return array('code' => 1, 'msg' => '提交成功', 'id' => $oid, 'upstream_oid' => $upstream_oid);
}

function custom_goods_query_order($uid, $oid)
{
    global $DB, $date;
    if (!custom_goods_table_exists('qingka_custom_goods_order')) {
        return array('code' => -1, 'msg' => '请先导入 custom_goods/install.sql');
    }
    if (custom_goods_is_platform($oid)) {
        $oid = custom_goods_id_from_platform($oid);
    } else {
        $oid = intval($oid);
    }
    $where = "id='{$oid}'";
    if ($uid != 1) {
        $where .= " and uid='{$uid}'";
    }
    $order = $DB->get_row("select * from qingka_custom_goods_order where {$where} limit 1");
    if (!$order) {
        return array('code' => -1, 'msg' => '未查到订单');
    }
    if ($order['upstream_oid'] != '') {
        $result = custom_goods_upstream_request('chadan', array('oid' => $order['upstream_oid']));
        if (isset($result['code']) && $result['code'] == 1 && isset($result['data'][0])) {
            $up = $result['data'][0];
            $status = custom_goods_escape(isset($up['status']) ? $up['status'] : (isset($up['status_text']) ? $up['status_text'] : $order['status']));
            $process = custom_goods_escape(isset($up['process']) ? $up['process'] : $order['process']);
            $remarks = custom_goods_escape(isset($up['remarks']) ? $up['remarks'] : $order['remarks']);
            $DB->query("update qingka_custom_goods_order set status='{$status}',process='{$process}',remarks='{$remarks}',updatetime='{$date}' where id='{$order['id']}'");
            $order['status'] = $status;
            $order['process'] = $process;
            $order['remarks'] = $remarks;
        }
    }
    $goods = $DB->get_row("select name from qingka_custom_goods where id='{$order['goods_id']}' limit 1");
    $order['goods_name'] = $goods ? $goods['name'] : '';
    return array('code' => 1, 'data' => array($order));
}
?>

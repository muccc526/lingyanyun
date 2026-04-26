<?php
include('confing/common.php');

// 从 GET 请求中获取参数
$hid = isset($_GET['hid']) ? intval($_GET['hid']) : 1;
$pricee = isset($_GET['pricee']) ? floatval($_GET['pricee']) : 5.5;
$dockcro = isset($_GET['dockcro']) ? intval($_GET['dockcro']) : 1;
$skipCategories = isset($_GET['skipCategories']) ? explode(',', $_GET['skipCategories']) : array('11111', '22222', '33333', '444444');

$act = isset($_GET['act']) ? daddslashes($_GET['act']) : null;

if ($act == 'cookie') {
    qcookie();
} elseif ($act == 'yijiankelong') { // 执行一键对接新建网址推荐这个一键克隆  
    $a = $DB->get_row("SELECT * FROM qingka_wangke_huoyuan WHERE hid='{$hid}'");
    if (!$a) {
        jsonReturn(-1, "货源信息不存在");
    }
    $data = array("uid" => $a["user"], "key" => $a["pass"]);
    $er_url = "{$a["url"]}/api.php?act=getclass";
    $br_url = "{$a["url"]}/api.php?act=getfenlei";
    $result = get_url($er_url, $data);
    $result_2 = get_url($br_url, $data);
    $result1 = json_decode($result, true);
    $result1_2 = json_decode($result_2, true);
    if (json_last_error() !== JSON_ERROR_NONE || !isset($result1["data"])) {
        jsonReturn(-1, "API 课程返回数据格式错误或缺失");
    }
    if (json_last_error() !== JSON_ERROR_NONE || !isset($result1_2["data"])) {
        jsonReturn(-1, "API 分类返回数据格式错误或缺失");
    }
    $categories = $result1["data"];
    $categories_2 = $result1_2["data"];
    $numItemsInserted = 0;
    $numItemsUpdated = 0;
    $updatedProductInfo = [];

    // 定义要跳过的 fenlei ID 列表

    if ($dockcro == 1) { // 仅当 $dockcro 为 1 时执行分类的插入或更新
        foreach ($categories_2 as $value_2) {
            // 如果 fenlei ID 在跳过列表中，则跳过
            if (in_array($value_2['id'], $skipCategories)) {
                continue;
            }

            if (empty($category) || $value_2['id'] == $category) {
                $existingCategory = $DB->get_row("SELECT * FROM qingka_wangke_fenlei WHERE id='{$value_2['id']}'");
                // 插入分类部分
                if (!$existingCategory) {
                    $DB->query("INSERT INTO qingka_wangke_fenlei (id, sort, name, status, time) VALUES ('{$value_2['id']}', '{$value_2['sort']}', '{$value_2['name']}', '1', NOW())");
                } 
                // 更新现有分类（如果需要）
                // $DB->query("UPDATE qingka_wangke_fenlei SET name='{$value['category_name']}' WHERE id='{$value['fenlei']}'");
                // }
            }
        }
    }

    foreach ($categories as $value) {
        // 如果 fenlei ID 在跳过列表中，则跳过
        if (in_array($value['fenlei'], $skipCategories)) {
            continue;
        }

        if (empty($category) || $value['fenlei'] == $category) {
            $price = $value['price'] * $pricee;
            //额外算法：$price = $value['price'] * $pricee + 0.1，先乘后加;
            $sort = $numItemsInserted + $numItemsUpdated + 1; // 排序字段
            $existingProduct = $DB->get_row("SELECT * FROM qingka_wangke_class WHERE docking='{$hid}' AND noun='{$value['cid']}'");
            if ($existingProduct) {
                $originalPrice = $existingProduct['price'] * 0.2;
                $newPrice = $price * 0.2;
                $updatedProductInfo[] = [
                    'name' => $existingProduct['name'],
                    'originalPrice' => $originalPrice,
                    'newPrice' => $newPrice
                ];
                $DB->query("UPDATE qingka_wangke_class SET price='{$price}', content='{$value['content']}' WHERE docking='{$hid}' AND noun='{$value['cid']}'");
                $numItemsUpdated++;
            } else {
                $DB->query("INSERT INTO qingka_wangke_class (name, getnoun, noun, fenlei, queryplat, docking, price, sort, content, addtime, status) 
                            VALUES ('{$value['name']}', '{$value['cid']}', '{$value['cid']}', '{$value['fenlei']}', '$hid', '$hid', '{$price}', '{$sort}', '{$value['content']}', NOW(), '1')");
                $numItemsInserted++;
            }
        }
    }
    echo "本次对接上架了{$numItemsInserted}个新商品，更新了{$numItemsUpdated}个商品的价格" . ($dockcro == 1 ? "，分类信息已更新" : "") . "<br>";
    if (!empty($updatedProductInfo)) {
        echo "更新的商品信息如下：<br>";
        foreach ($updatedProductInfo as $info) {
            echo "商品名称：{$info['name']}，原本价格：{$info['originalPrice']}，更新后价格：{$info['newPrice']}<br>";
        }
    }
}
//一键执行操作之前记着先备份
//仅更新商品价格，须谨慎最好重新测试后才尝试

elseif ($act == 'gengxinjiage') { // 仅更新商品价格
    $a = $DB->get_row("SELECT * FROM qingka_wangke_huoyuan WHERE hid='{$hid}'");
    if (!$a) {
        jsonReturn(-1, "货源信息不存在");
    }
    $data = array("uid" => $a["user"], "key" => $a["pass"]);
    $er_url = "{$a["url"]}/api.php?act=getclass";
    $result = get_url($er_url, $data);
    $result1 = json_decode($result, true);
    if (json_last_error() !== JSON_ERROR_NONE || !isset($result1["data"])) {
        jsonReturn(-1, "API 返回数据格式错误或缺失");
    }
    $categories = $result1["data"];
    $numItemsUpdated = 0;
    $updatedProductInfo = [];

    // 定义要跳过的 fenlei ID 列表
    foreach ($categories as $value) {
        // 如果 fenlei ID 在跳过列表中，则跳过
        if (in_array($value['fenlei'], $skipCategories)) {
            continue;
        }
        //额外算法：$price = $value['price'] * $pricee + 0.1，先乘后加;
        $price = $value['price'] * $pricee;
        $existingProduct = $DB->get_row("SELECT * FROM qingka_wangke_class WHERE docking='{$hid}' AND noun='{$value['cid']}'");
        if ($existingProduct) {
            $originalPrice = $existingProduct['price'] * 0.2;
            $newPrice = $price * 0.2;
            $updatedProductInfo[] = [
                'name' => $existingProduct['name'],
                'originalPrice' => $originalPrice,
                'newPrice' => $newPrice
            ];
            $DB->query("UPDATE qingka_wangke_class SET price='{$price}', content='{$value['content']}' WHERE docking='{$hid}' AND noun='{$value['cid']}'");
            $numItemsUpdated++;
        }
    }
    echo "本次更新了{$numItemsUpdated}个商品的价格<br>";
    if (!empty($updatedProductInfo)) {
        echo "更新的商品信息如下：<br>";
        foreach ($updatedProductInfo as $info) {
            echo "商品名称：{$info['name']}，原本价格：{$info['originalPrice']}，更新后价格：{$info['newPrice']}<br>";
        }
    }
}
?>    
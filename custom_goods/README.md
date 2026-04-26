# 自定义商品对接模块引入教程

## 1. 复制目录

将 `custom_goods/` 放到项目根目录。

## 2. 导入 SQL

执行：

```sql
source custom_goods/install.sql;
```

会创建：

- `qingka_custom_goods_config`
- `qingka_custom_goods`
- `qingka_custom_goods_order`

## 3. 修改项目文件

需要修改：

- `api.php`
- `apisub.php`
- `index/index.php`

本项目当前版本已经接入上述文件。如果复制到同系统其他站点，请参考这三处改动。

## 4. 管理员配置

后台进入：`自定义商品对接`

填写：

- 上游 BaseURL，例如 `https://example.com`
- 上游 UID
- 上游 KEY

保存后点击“测试连接”，再点击“同步上游自定义商品”。

## 5. 上架商品

同步后商品默认下架。管理员在列表中设置：

- 本地价
- 加价算法
- 排序
- 状态为“上架”

保存后用户可在“自定义商品下单”页面看到。

## 6. 用户下单

用户进入：`自定义商品下单`

选择商品后，页面会按上游 `input_config` 自动渲染字段，不需要手动配置表单。

## 7. 用户查单

用户进入：`自定义商品查单`

输入本地订单 ID 可以同步上游状态。订单只保存在 `qingka_custom_goods_order`，不会混入原 `qingka_wangke_order`。

## 8. 下级继续对接本站

下级继续使用同一协议：

- `api.php?act=getclass`
- `api.php?act=add`
- `api.php?act=chadan`

本站会把本地自定义商品以 `custom_本地ID` 暴露出去。下级复制此模块后，会再生成自己的 `custom_本地ID`，可继续向下传递。

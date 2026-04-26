# 自定义商品对接模块修改方案

## 目标

在本项目新增一个可复制的 `custom_goods/` 模块，用于对接上一级网站的自定义商品，并继续向下级暴露同样协议，形成可套娃传递的自定义商品对接能力。

## 模块目录

```text
custom_goods/
  install.sql      # 模块数据表
  config.php       # 模块初始化、权限和通用配置
  functions.php    # 上游请求、商品同步、计价、扣费、订单处理
  api_bridge.php   # 给 api.php 调用的 getclass/add/chadan 桥接
  admin.php        # 管理员配置和上架页面
  order.php        # 用户自定义商品下单页面
  orders.php       # 用户自定义商品独立查单页面
  README.md        # 引入教程
```

## 数据表

新增三张表，不改原订单表：

- `qingka_custom_goods_config`：上游 `baseurl`、`uid`、`key`。
- `qingka_custom_goods`：本地上架的自定义商品，保存上游 `cid`、本地商品信息、`input_config`、售价和状态。
- `qingka_custom_goods_order`：自定义商品订单，保存本地订单、上游订单号、输入数据、价格、状态和备注。

余额扣费继续使用 `qingka_wangke_user.money`，日志继续使用 `wlog()`。

## 对外 API 套娃能力

接入 `api.php`：

- `getclass`：原商品列表后追加本地已上架的自定义商品。
- `add`：如果 `platform=custom_数字`，在原网课必填校验前转给模块处理。
- `chadan`：如果查到自定义商品订单，走模块查单逻辑。

本站同步上游商品时，上游 `custom_12` 保存为 `upstream_cid`，本站对外重新生成 `custom_本地ID`。下级继续同步本站时，又生成下级自己的 `custom_本地ID`，从而实现无限传递。

## 管理员页面

`custom_goods/admin.php` 提供：

- 配置上游 `baseurl / uid / key`。
- 测试上游连接。
- 同步上游自定义商品。
- 选择上架商品。
- 设置本地商品名、说明、价格、计算方式、排序、状态。

## 用户页面

`custom_goods/order.php` 是独立入口，不合并到原订单提交。

页面根据商品 `input_config.fields` 自动渲染：

- `text`
- `integer`
- `decimal`
- `select`
- `datetime`

按 `input_config.price_rule.factors` 自动计算总价。

`custom_goods/orders.php` 是独立查单入口，自定义商品订单不写入 `qingka_wangke_order`，不混入原订单管理。

## 计价与扣费

先按本站代理加价规则计算用户单价：

- `yunsuan = "*"`：`price * addprice`
- `yunsuan = "+"`：`price + addprice`
- 其他默认乘法

再按自定义商品计价因子计算总价：

```text
总价 = 用户单价 × quantity × input_config.price_rule.factors 中的其他数值字段
```

默认未配置时按 `count`，即：

```text
总价 = 用户单价 × quantity
```

## 项目内必要改动

- `api.php`：接入 `custom_goods/api_bridge.php`。
- `apisub.php`：增加模块后台接口。
- `index/index.php`：增加管理员和用户菜单入口。

## 已确认决策

- 新增独立入口：`自定义商品下单`。
- 新增独立查单入口：`自定义商品查单`。
- 自定义商品订单写模块订单表，不写原订单表。

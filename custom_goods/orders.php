<?php
$title = '自定义商品查单';
require_once('../confing/common.php');
require_once('functions.php');
custom_goods_require_login();
?>
<link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
<script src="../assets/js/vue.min.js"></script>
<script src="../assets/js/vue-resource.min.js"></script>
<div class="app-content-body">
  <div class="wrapper-md control" id="customGoodsOrders">
    <div class="panel panel-default">
      <div class="panel-heading font-bold layui-bg-blue">自定义商品查单</div>
      <div class="panel-body">
        <div class="form-inline">
          <input class="form-control" v-model="oid" placeholder="订单ID">
          <button class="btn btn-primary" @click="query">查询并同步</button>
          <button class="btn btn-info" @click="load">刷新列表</button>
        </div>
        <div class="table-responsive" style="margin-top:15px;">
          <table class="table table-striped">
            <thead><tr><th>ID</th><th>商品</th><th>扣费</th><th>上游订单</th><th>状态</th><th>进度</th><th>备注</th><th>时间</th></tr></thead>
            <tbody>
              <tr v-for="item in orders">
                <td>{{item.id}}</td><td>{{item.goods_name}}</td><td>{{item.total_price}}</td><td>{{item.upstream_oid}}</td><td>{{item.status}}</td><td>{{item.process}}</td><td>{{item.remarks}}</td><td>{{item.addtime}}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
new Vue({
  el: '#customGoodsOrders',
  data: {oid: '', orders: []},
  methods: {
    load: function() {
      this.$http.post('/apisub.php?act=custom_goods_order_list', {}, {emulateJSON: true}).then(function(res) {
        if (res.body.code == 1) this.orders = res.body.data || [];
      });
    },
    query: function() {
      if (!this.oid) { this.load(); return; }
      this.$http.post('/apisub.php?act=custom_goods_order_query', {oid: this.oid}, {emulateJSON: true}).then(function(res) {
        if (res.body.code == 1) this.orders = res.body.data || [];
        else alert(res.body.msg || '查询失败');
      });
    }
  },
  mounted: function() { this.load(); }
});
</script>

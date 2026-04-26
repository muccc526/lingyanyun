<?php
$title = '自定义商品对接';
require_once('../confing/common.php');
require_once('functions.php');
custom_goods_require_admin();
?>
<link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../assets/element/element.css">
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/vue.min.js"></script>
<script src="../assets/js/vue-resource.min.js"></script>
<script src="../assets/element/element.js"></script>
<div class="app-content-body">
  <div class="wrapper-md control" id="customGoodsAdmin">
    <div class="panel panel-default">
      <div class="panel-heading font-bold layui-bg-blue">自定义商品上游配置</div>
      <div class="panel-body">
        <div class="form-group">
          <label>上游 BaseURL</label>
          <input class="form-control" v-model="config.baseurl" placeholder="https://example.com">
        </div>
        <div class="form-group">
          <label>上游 UID</label>
          <input class="form-control" v-model="config.uid">
        </div>
        <div class="form-group">
          <label>上游 KEY</label>
          <input class="form-control" v-model="config.api_key">
        </div>
        <button class="btn btn-primary" @click="saveConfig">保存配置</button>
        <button class="btn btn-info" @click="testConfig">测试连接</button>
        <button class="btn btn-warning" @click="syncGoods">同步上游自定义商品</button>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading font-bold layui-bg-blue">自定义商品管理</div>
      <div class="panel-body">
        <div class="form-inline">
          <input class="form-control" v-model="keyword" placeholder="搜索商品名">
          <button class="btn btn-primary" @click="loadGoods">查询</button>
        </div>
        <div class="table-responsive" style="margin-top:15px;">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>ID</th><th>本地CID</th><th>上游CID</th><th>名称</th><th>上游价</th><th>本地价</th><th>加价算法</th><th>排序</th><th>状态</th><th>操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in goods" :key="item.id">
                <td>{{item.id}}</td>
                <td>custom_{{item.id}}</td>
                <td>{{item.upstream_cid}}</td>
                <td><input class="form-control" v-model="item.name"></td>
                <td>{{item.upstream_price}}</td>
                <td><input class="form-control" v-model="item.price"></td>
                <td>
                  <select class="form-control" v-model="item.yunsuan">
                    <option value="*">乘法</option>
                    <option value="+">加法</option>
                  </select>
                </td>
                <td><input class="form-control" v-model="item.sort"></td>
                <td>
                  <select class="form-control" v-model="item.status">
                    <option value="1">上架</option>
                    <option value="0">下架</option>
                  </select>
                </td>
                <td>
                  <button class="btn btn-xs btn-success" @click="saveGoods(item)">保存</button>
                  <button class="btn btn-xs btn-danger" @click="deleteGoods(item.id)">删除</button>
                </td>
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
  el: '#customGoodsAdmin',
  data: {config: {baseurl: '', uid: '', api_key: ''}, goods: [], keyword: ''},
  methods: {
    post: function(act, data, cb) {
      this.$http.post('/apisub.php?act=' + act, data || {}, {emulateJSON: true}).then(function(res) {
        if (res.body.code == 1) {
          cb && cb(res.body);
        } else {
          this.$message.error(res.body.msg || '操作失败');
        }
      });
    },
    loadConfig: function() {
      this.post('custom_goods_config_get', {}, function(res) { this.config = res.data; }.bind(this));
    },
    saveConfig: function() {
      this.post('custom_goods_config_save', {config: this.config}, function(res) { this.$message.success(res.msg); }.bind(this));
    },
    testConfig: function() {
      this.post('custom_goods_test', {}, function(res) { this.$message.success(res.msg); }.bind(this));
    },
    syncGoods: function() {
      this.post('custom_goods_sync', {}, function(res) { this.$message.success(res.msg); this.loadGoods(); }.bind(this));
    },
    loadGoods: function() {
      this.post('custom_goods_admin_list', {keyword: this.keyword}, function(res) { this.goods = res.data || []; }.bind(this));
    },
    saveGoods: function(item) {
      this.post('custom_goods_save', {item: item}, function(res) { this.$message.success(res.msg); this.loadGoods(); }.bind(this));
    },
    deleteGoods: function(id) {
      if (!confirm('确定删除该商品？')) return;
      this.post('custom_goods_delete', {id: id}, function(res) { this.$message.success(res.msg); this.loadGoods(); }.bind(this));
    }
  },
  mounted: function() { this.loadConfig(); this.loadGoods(); }
});
</script>

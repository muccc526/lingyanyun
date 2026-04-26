<?php
$title = '自定义商品下单';
require_once('../confing/common.php');
require_once('functions.php');
custom_goods_require_login();
?>
<link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../assets/element/element.css">
<script src="../assets/js/vue.min.js"></script>
<script src="../assets/js/vue-resource.min.js"></script>
<script src="../assets/element/element.js"></script>
<div class="app-content-body">
  <div class="wrapper-md control" id="customGoodsOrder">
    <div class="panel panel-default">
      <div class="panel-heading font-bold layui-bg-blue">自定义商品下单</div>
      <div class="panel-body">
        <div class="form-group">
          <label>选择商品</label>
          <select class="form-control" v-model="cid" @change="selectGoods">
            <option value="">请选择商品</option>
            <option v-for="item in goods" :value="item.cid">{{item.name}} - {{item.price}}积分</option>
          </select>
        </div>
        <div class="form-group" v-if="current.content">
          <label>商品说明</label>
          <textarea class="form-control" rows="3" v-model="current.content" disabled></textarea>
        </div>
        <div class="form-group">
          <label>购买数量</label>
          <input class="form-control" type="number" min="1" v-model="quantity">
        </div>
        <div class="form-group" v-for="(field, fieldIndex) in fields" :key="fieldKey(field, fieldIndex)">
          <label>{{field.label || field.name}}</label>
          <select class="form-control" v-if="field.type == 'select'" v-model="input[field.name]">
            <option value="">请选择</option>
            <option v-for="option in field.options" :value="option.value || option">{{option.label || option}}</option>
          </select>
          <input v-else-if="field.type == 'integer'" class="form-control" type="number" step="1" v-model="input[field.name]" :placeholder="field.tips || ''">
          <input v-else-if="field.type == 'decimal'" class="form-control" type="number" step="0.01" v-model="input[field.name]" :placeholder="field.tips || ''">
          <input v-else-if="field.type == 'datetime'" class="form-control" type="datetime-local" v-model="input[field.name]">
          <input v-else class="form-control" type="text" v-model="input[field.name]" :placeholder="field.tips || ''">
        </div>
        <div class="alert alert-warning" v-if="current.cid && fields.length == 0">
          当前商品未解析到表单配置，请检查该商品的 input_config。
        </div>
        <p v-if="current.cid">预计扣费：<b style="color:red">{{totalPrice}}</b> 积分</p>
        <button class="btn btn-primary" @click="submit">提交订单</button>
      </div>
    </div>
  </div>
</div>
<script>
new Vue({
  el: '#customGoodsOrder',
  data: {goods: [], cid: '', current: {}, fields: [], input: {}, quantity: 1},
  computed: {
    totalPrice: function() {
      if (!this.current.price) return '0.00';
      var total = parseFloat(this.current.price || 0);
      var config = this.parseConfig();
      var factors = (config.price_rule && config.price_rule.factors) || ['count'];
      for (var i = 0; i < factors.length; i++) {
        var key = factors[i];
        if (key === 'count') {
          total *= Math.max(1, parseFloat(this.quantity || 1));
        } else {
          var field = this.fields.find(function(f) { return f.name === key; });
          if (field && (field.type === 'integer' || field.type === 'decimal')) {
            total *= Math.max(0, parseFloat(this.input[key] || 0));
          }
        }
      }
      return total.toFixed(2);
    }
  },
  methods: {
    parseConfig: function() {
      var parsed = null;
      var config = this.current.input_config_data || {};
      if (typeof config === 'object' && config.fields && config.fields.length) {
        return this.normalizeConfig(config);
      }
      config = this.current.input_config || {};
      if (typeof config === 'object') return this.normalizeConfig(config);
      try {
        parsed = JSON.parse(config || '{}');
        if (typeof parsed === 'string') parsed = JSON.parse(parsed);
        return this.normalizeConfig(parsed || {});
      } catch (e) {
        try {
          var normalized = String(config || '')
            .replace(/&quot;/g, '"')
            .replace(/&#34;/g, '"')
            .replace(/\\"/g, '"');
          parsed = JSON.parse(normalized || '{}');
          if (typeof parsed === 'string') parsed = JSON.parse(parsed);
          return this.normalizeConfig(parsed || {});
        } catch (e2) {
          return {};
        }
      }
    },
    normalizeConfig: function(config) {
      config = config || {};
      var normalized = {};
      var fields = [];
      if (Array.isArray(config.fields)) {
        for (var f = 0; f < config.fields.length; f++) {
          this.pushUniqueField(fields, Object.assign({}, config.fields[f]));
        }
      }
      if (!fields.length && Array.isArray(config.inputs)) {
        for (var i = 0; i < config.inputs.length; i++) {
          var input = Object.assign({}, config.inputs[i]);
          input.type = input.type || 'text';
          input.options = input.options || [];
          this.pushUniqueField(fields, input);
        }
      }
      if (Array.isArray(config.selects)) {
        for (var j = 0; j < config.selects.length; j++) {
          var select = Object.assign({}, config.selects[j]);
          select.type = 'select';
          select.label = select.label || select.name || '选项';
          select.tips = select.tips || '';
          select.options = select.options || [];
          this.pushUniqueField(fields, select);
        }
      }
      normalized.fields = fields;
      normalized.price_rule = config.price_rule || {factors: ['count']};
      normalized.price_rule.factors = normalized.price_rule.factors || ['count'];
      return normalized;
    },
    pushUniqueField: function(fields, field) {
      if (!field || !field.name) return;
      var type = field.type || 'text';
      for (var i = 0; i < fields.length; i++) {
        if (fields[i].name === field.name && (fields[i].type || 'text') === type) {
          return;
        }
      }
      fields.push(field);
    },
    fieldKey: function(field, index) {
      return (this.current.cid || 'none') + '_' + (field.name || 'field') + '_' + index + '_' + (field.type || 'text');
    },
    loadGoods: function() {
      this.$http.post('/apisub.php?act=custom_goods_public_list', {}, {emulateJSON: true}).then(function(res) {
        if (res.body.code == 1) this.goods = res.body.data || [];
      });
    },
    selectGoods: function() {
      this.current = {};
      this.fields = [];
      this.input = {};
      this.current = this.goods.find(function(item) { return item.cid == this.cid; }.bind(this)) || {};
      var config = this.parseConfig();
      var nextFields = config.fields || [];
      if (!Array.isArray(nextFields)) {
        nextFields = Object.keys(nextFields).map(function(key) { return nextFields[key]; });
      }
      var nextInput = {};
      for (var i = 0; i < nextFields.length; i++) {
        var field = nextFields[i];
        if (!field.name) continue;
        nextInput[field.name] = '';
      }
      this.fields = nextFields;
      this.input = nextInput;
    },
    submit: function() {
      if (!this.cid) { this.$message.error('请选择商品'); return; }
      this.$http.post('/apisub.php?act=custom_goods_order_add', {
        platform: this.cid,
        quantity: this.quantity,
        input_data: JSON.stringify(this.input)
      }, {emulateJSON: true}).then(function(res) {
        if (res.body.code == 1) {
          this.$message.success('提交成功，订单ID：' + res.body.id);
          this.input = {};
        } else {
          this.$message.error(res.body.msg || '提交失败');
        }
      });
    }
  },
  mounted: function() { this.loadGoods(); }
});
</script>

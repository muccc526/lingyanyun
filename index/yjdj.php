<?php
$title = '对接管理';
require_once('head.php');
if ($userrow['uid'] != 1) {
    exit("<script language='javascript'>window.location.href='login.php';</script>");
}
?>
<style>
.form-row {
display:flex;
align-items:flex-end;
}
</style>
<style>
.form-row {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    margin-bottom: 15px;
}

.form-group {
    flex: 1;
    margin-right: 10px;
}

.form-group:last-child {
    margin-right: 0;
}

@media (max-width: 768px) {
    .form-group {
        flex: 100%;
        margin-right: 0;
        margin-bottom: 10px;
    }
}
</style>

<div class="app-content-body">
    <div class="wrapper-md control" id="orderlist">
        <div class="panel panel-default">
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
                综合对接
            </div>
            <div class="panel-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="keyword">选择货源</label>
                        <el-select id="select" v-model="cx.hid" filterable placeholder="选择货源" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
                            <el-option label="输入关键词搜索并选择货源" value=""></el-option>
                            <?php
                            $a = $DB->query("select * from qingka_wangke_huoyuan");
                            while ($row = $DB->fetch($a)) {
                                echo '<el-option label="' .'hid '.$row['hid'] .' '. $row['name'] . '" value="' . $row['hid'] . '"></el-option>';
                            }
                            ?>
                        </el-select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <button class="btn btn-info btn-block" @click="checkBalance">查询货源余额</button>
                    </div>
                    <div class="form-group col-md-6">
                        <button class="btn btn-info btn-block" @click="checkDeployedCount">查询货源已上架数</button>
                    </div>
                </div>
 
<!-- 新增表格显示上游商品 -->
<div class="form-row">
    <div class="form-group col-md-4">
        <label for="searchName">选择需要的上游商品</label>
        <button class="btn btn-warning btn-block" @click="fetchAllProducts">获取商品</button>
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" v-model="searchName" placeholder="过滤商品名称">
    </div>
    <div class="form-group col-md-4">
        <input type="text" class="form-control" v-model="searchFenlei" placeholder="指定分类ID">
    </div>
</div>
 
<!-- 新增表格显示上游商品 -->
<div class="form-row" v-if="filteredProducts.length  > 0">
    <div class="form-group col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th><input type="checkbox" v-model="selectAll" @change="toggleSelectAll"></th>
                    <th>分类ID</th>
                    <th>商品名</th>
                    <th>CID</th>
                    <th>价格</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="product in filteredProducts" :key="product.cid"> 
                    <td>
    <input 
      type="checkbox" 
      v-model="selectedProducts" 
      :value="product.cid"
      :checked="selectAll">
  </td>
                    <td>{{ product.fenlei  }}</td>
                    <td>{{ product.name  }}</td>
                    <td>{{ product.cid  }}</td>
                    <td>{{ product.price  }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
 
<div class="form-row">
    <!-- 是否新建分类 -->
    <div class="form-group col-md-3">
        <label for="createNewCategory">是否新建分类</label>
        <el-select id="createNewCategory" v-model="createNewCategory" @change="toggleCategoryOptions" style="width:100%">
            <el-option label="否" value="0"></el-option>
            <el-option label="是" value="1"></el-option>
        </el-select>
    </div>

    <!-- 选择上架分类 -->
    <div class="form-group col-md-3" v-if="createNewCategory === '0'">
        <label for="localCategorySelect">上架分类</label>
        <el-select id="localCategorySelect" v-model="localCategoryId" filterable placeholder="请选择分类" style="width:100%" :disabled="createNewCategory === '1'">
            <el-option label="选择上架分类" value=""></el-option>
            <?php 
            $categories = $DB->query("select * from qingka_wangke_fenlei");
            while ($row = $DB->fetch($categories)) {
                echo '<el-option label="' .'ID '.$row['id'] .' '. $row['name'] . '" value="' . $row['id'] . '"></el-option>';
            }
            ?>
        </el-select>
    </div>

    <!-- 输入新建分类的名称 -->
    <div class="form-group col-md-3" v-if="createNewCategory === '1'">
        <label for="newCategoryName">请输入新建分类的名称</label>
        <input type="text" class="form-control" v-model="newCategoryName" placeholder="请输入分类名称" :disabled="createNewCategory === '0'">
    </div>
</div>

 
<!-- 新增价格计算方式选择框 -->
<div class="form-row">
    <div class="form-group col-md-3">
        <label for="upstreamCategoryIdForPrice">设置上架价格</label>
        <input type="text" class="form-control" v-model="markupMultiplier" placeholder="加价">
    </div>
    <div class="form-group col-md-3">
        <select class="form-control" v-model="multiplyByFive">
            <option value="2">乘法计算且乘5(29)</option>
            <option value="1">乘法计算且不乘5(暗网)</option>
            <option value="0">加法计算直接加价</option>
        </select>
    </div>
    <div class="form-group col-md-3">
        <select class="form-control" v-model="skipExisting">
            <option value="1">跳过已有商品</option>
            <option value="0">不跳过</option>
        </select>
    </div>
    <div class="form-group col-md-3">
        <button class="btn btn-primary btn-block" @click="startIntegrationSelected">上架选中商品</button>
    </div>
</div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <label for="upstreamCategoryIdForPrice">更新商品信息</label>
                        <input type="text" class="form-control" v-model="upstreamCategoryIdForPrice" placeholder="默认全部更新,可填写上游分类ID指定更新">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <label for="priceRatio"></label>
                        <input type="text" class="form-control" v-model="priceRatio" placeholder="加价">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <label for="multiplyByFiveForPrice"></label>
                        <select class="form-control" v-model="multiplyByFiveForPrice">
                            <option value="2">乘法计算且乘5(29)</option>
                            <option value="1">乘法计算且不乘5(暗网)</option>
                            <option value="0">加法计算直接加价</option>
                            <option value="3">不更新价格只更新介绍</option>
                            <option value="4">不更新价格只更新介绍和商品名</option>
                            <option value="5">同步上游下架商品（不会删除）</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <button class="btn btn-danger form-control" @click="updatePrice">更新价格</button>
                    </div>
                </div>
                <div class="form-row mt-4"> 
                    <div class="form-group col-md-3">
                        <label for="oldKeyword">批量对关键词进行替换</label>
                        <input type="text" class="form-control" v-model="oldKeyword" placeholder="请输入要替换的关键词">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="newKeyword" placeholder="请输入替换后的关键词,留空删除关键词">
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <select class="form-control" v-model="effectScope">
                            <option value="category">分类ID=</option>
                            <option value="docking">对接平台ID=</option>
                            <option value="all">对所有范围执行</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="scopeId" placeholder="请输入分类ID或对接平台ID" :disabled="effectScope === 'all'">
                    </div>
                    <div class="form-group col-md-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-dark form-control" @click="updateKeywords">更新关键词</button>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-3">
                        <label for="prefix">批量对商品添加前缀</label>
                        <input type="text" class="form-control" v-model="prefix" placeholder="请输入要新增的前缀">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <select class="form-control" v-model="prefixEffectScope">
                            <option value="category">分类ID=</option>
                            <option value="docking">对接平台ID=</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="prefixScopeId" placeholder="请输入分类ID或对接平台ID">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <button class="btn btn-dark form-control" @click="addPrefix">添加前缀</button>
                    </div>
                </div>
                <div class="form-row mt-4">
                    <div class="form-group col-md-3">
                        <label for="deleteDuplicateScope">删除重复商品</label>
                        <select class="form-control" v-model="deleteDuplicateScope">
                            <option value="all">所有范围</option>
                            <option value="category">分类ID=</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <input type="text" class="form-control" v-model="deleteDuplicateScopeId" placeholder="请输入分类ID" :disabled="deleteDuplicateScope === 'all'">
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <select class="form-control" v-model="deleteDuplicateStrategy">
                            <option value="keep_larger">保留CID更大的商品</option>
                            <option value="keep_smaller">保留CID更小的商品</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>&nbsp;</label>
                        <button class="btn btn-dark form-control" @click="deleteDuplicates">删除重复商品</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once("footer.php"); ?>
<script src="assets/js/element.js"></script>
<script>
new Vue({
  el: "#orderlist",
  data: {
  cx: { hid: "" },
  createNewCategory: '0',
  newCategoryName: '',
  products: [],
  selectedProducts: [],
  localCategoryId: '',
  markupMultiplier: '',
  multiplyByFive: '2',
  skipExisting: '1',
  upstreamCategoryIdForPrice: '',
  priceRatio: '',
  multiplyByFiveForPrice: '2',
  oldKeyword: '',
  newKeyword: '',
  effectScope: 'all',
  scopeId: '',
  prefix: '',
  prefixEffectScope: 'category',
  prefixScopeId: '',
  deleteDuplicateScope: 'all',
  deleteDuplicateScopeId: '',
  deleteDuplicateStrategy: 'keep_larger',
  searchName: '',
  searchFenlei: '',
  selectAll: false
  },
    computed: {
        // 根据搜索框内容过滤商品
        filteredProducts() {
            return this.products.filter(product  => {
                const nameMatch = product.name.toLowerCase().includes(this.searchName.toLowerCase().trim()); 
                const fenleiMatch = this.searchFenlei  === '' || product.fenlei.toString()  === this.searchFenlei.trim(); 
                return nameMatch && fenleiMatch;
            });
        }
    },
  methods: {
      fetchAllProducts: function() {
            if (!this.cx.hid)  {
                layer.msg(' 请选择货源接口', {icon: 2});
                return;
            }
            var load = layer.load(2); 
            this.$http.post("/apisub.php?act=fetchAllProducts",  {
                hid: this.cx.hid 
            }, {emulateJSON: true}).then(function(data) {
                layer.close(load); 
                if (data.data.code  == 1) {
                    this.products  = data.data.products; 
                } else {
                    layer.msg(data.data.msg,  {icon: 2});
                }
            }.bind(this));
        },
        toggleSelectAll: function() {
        const targetProducts = this.filteredProducts.map(p  => p.cid);  // 改用cid标识
        this.selectedProducts  = this.selectAll  ? 
        [...new Set([...this.selectedProducts,  ...targetProducts])] : 
        this.selectedProducts.filter(cid  => !targetProducts.includes(cid)); 
       },
        toggleCategoryOptions: function() {

      if (this.createNewCategory  === '1') {
        this.localCategoryId  = '';
      }
    },
       startIntegrationSelected: function() {
        if (this.createNewCategory  === '1' && !this.newCategoryName)  {
        layer.msg(' 请输入新建分类的名称', {icon: 2});
        return;
      }
        if (!this.cx.hid)  {
            layer.msg(' 请选择货源接口', {icon: 2});
            return;
        }
        if (this.createNewCategory  === '0' && !this.localCategoryId)  {
            layer.msg(' 请选择上架分类', {icon: 2});
            return;
        }
    if (this.selectedProducts.length  === 0) {
        layer.msg('  请选择要上架的商品', {icon: 2});
        return;
    }
        if (!this.markupMultiplier)  {
            layer.msg(' 请输入加价', {icon: 2});
            return;
        }
        const cids = this.selectedProducts;
        var load = layer.load(2); 
        this.$http.post("/apisub.php?act=startIntegrationSelected",  {
        hid: this.cx.hid, 
        localCategoryId: this.createNewCategory  === '1' ? '' : this.localCategoryId, 
        cids: JSON.stringify(this.selectedProducts), 
        markupMultiplier: this.markupMultiplier, 
        multiplyByFive: this.multiplyByFive, 
        skipExisting: this.skipExisting, 
        createNewCategory: this.createNewCategory, 
        newCategoryName: this.newCategoryName  
        }, {emulateJSON: true}).then(function(data) {
            layer.close(load); 
            if (data.data.code  == 1) {
                layer.msg(data.data.msg,  {icon: 1});
            } else {
                layer.msg(data.data.msg,  {icon: 2});
            }
        });
    },
       checkBalance: function() {
                if (!this.cx.hid) {
                    layer.msg('请选择货源', { icon: 2 });
                    return;
                }
                var load = layer.load(2);
                this.$http.post("/apisub.php?act=checkbalance", {
                    hid: this.cx.hid
                }, { emulateJSON: true }).then(function(data) {
                    layer.close(load);
                    if (data.data.code == 1) {
                        layer.alert(
                            data.data.msg,
                            { icon: 1, title: "信息" },
                            function () {
                                setTimeout(function () {
                                    window.location.href = "";
                                }, 500);
                            }
                        );
                    } else {
                        layer.msg(data.data.msg, { icon: 2 });
                    }
                });
            },
            checkDeployedCount: function() {
                if (!this.cx.hid) {
                    layer.msg('请选择货源', { icon: 2 });
                    return;
                }
                var load = layer.load(2);
                this.$http.post("/apisub.php?act=checkdeployedcount", {
                    hid: this.cx.hid
                }, { emulateJSON: true }).then(function(data) {
                    layer.close(load);
                    if (data.data.code == 1) {
                        layer.alert(
                            data.data.msg,
                            { icon: 1, title: "信息" },
                            function () {
                                setTimeout(function () {
                                    window.location.href = "";
                                }, 500);
                            }
                        );
                    } else {
                        layer.msg(data.data.msg, { icon: 2 });
                    }
                });
            },
  updatePrice: function() {
    if (!this.cx.hid) {
      layer.msg('请选择货源接口', {icon: 2});
      return;
    }
    var load = layer.load(2);
    this.$http.post("/apisub.php?act=updateprice", {
      hid: this.cx.hid,
      upstreamCategoryId: this.upstreamCategoryIdForPrice,
      priceRatio: this.priceRatio,
      multiplyByFive: this.multiplyByFiveForPrice
    }, {emulateJSON: true}).then(function(data) {
      layer.close(load);
      if (data.data.code == 1) {
        layer.msg(data.data.msg, {icon: 1});
      } else {
        layer.msg(data.data.msg, {icon: 2});
      }
    });
  },
  updateKeywords: function() {
    if (!this.oldKeyword) {
      layer.msg('请输入要替换的关键词', {icon: 2});
      return;
    }
    if (this.effectScope !== 'all' && !this.scopeId) {
      layer.msg('请输入分类ID或对接平台ID', {icon: 2});
      return;
    }

    var load = layer.load(2);
    this.$http.post("/apisub.php?act=updatekeywords", {
      oldKeyword: this.oldKeyword,
      newKeyword: this.newKeyword,
      effectScope: this.effectScope,
      scopeId: this.scopeId
    }, {emulateJSON: true}).then(function(data) {
      layer.close(load);
      if (data.data.code == 1) {
        layer.msg(data.data.msg, {icon: 1});
      } else {
        layer.msg(data.data.msg, {icon: 2});
      }
    });
},
addPrefix: function() {
      if (!this.prefix) {
        layer.msg('请输入要新增的前缀', {icon: 2});
        return;
      }
      if (!this.prefixScopeId) {
        layer.msg('请输入分类ID或对接平台ID', {icon: 2});
        return;
      }

      var load = layer.load(2);
      this.$http.post("/apisub.php?act=addprefix", {
        prefix: this.prefix,
        prefixEffectScope: this.prefixEffectScope,
        prefixScopeId: this.prefixScopeId
      }, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    deleteDuplicates: function() {
      if (this.deleteDuplicateScope !== 'all' && !this.deleteDuplicateScopeId) {
        layer.msg('请输入分类ID或对接接口ID', {icon: 2});
        return;
      }
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=deleteDuplicates", {
        scope: this.deleteDuplicateScope,
        scopeId: this.deleteDuplicateScopeId,
        strategy: this.deleteDuplicateStrategy
      }, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    }
  }
});
</script>
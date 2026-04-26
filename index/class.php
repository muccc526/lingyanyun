<?php
$title='课程管理';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
?>
     <div class="app-content-body ">
        <div class="wrapper-md control" id="orderlist">
            
        <div class="panel panel-default" >
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">课程列表&nbsp;<button class="btn btn-xs btn-light" data-toggle="modal" data-target="#modal-add">新增课程</button></div>
            <div class="panel-body">
              <div class="form-inline">
  <div class="form-group">
    <label for="keyword">模糊搜索</label>
    <input type="text" class="form-control" v-model="search.keyword" placeholder="输入关键词">
  </div>
  <div class="form-group">
    <label for="fenlei">分类</label>
    <select class="form-control" v-model="search.fenlei">
      <option value="">全部</option>
      <?php
        $a = $DB->query("select * from qingka_wangke_fenlei ORDER BY `sort` ASC");
        while($b = $DB->fetch($a)){
          echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';  
        }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="fenlei">对接平台</label>
    <select class="form-control" v-model="search.huoyuan">
      <option value="">全部</option>
      <?php
        $a = $DB->query("select * from qingka_wangke_huoyuan");
        while($b = $DB->fetch($a)){
          echo '<option value="'.$b['hid'].'">'.$b['name'].'</option>'; 
        }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="shangjiastatus">状态</label>
    <select class="form-control" v-model="search.shangjiastatus">
      <option value="">全部</option>
      <option value="1">上架中</option>
      <option value="0">已下架</option>
    </select>
  </div>
  <button class="btn btn-primary" @click="get(1)">查询</button>
  <button class="btn btn-danger" @click="confirmBatchUpdateStatus(0)">一键下架</button>
  <button class="btn btn-warning" @click="batchUpdateStatus(1)">一键上架</button>
  <button class="btn btn-success" @click="confirmApplyBatchChanges">应用批量修改</button>
  <button class="btn btn-danger" @click="confirmBatchDelete">批量删除</button>
  <div class="form-group">
    <label for="uid">密价用户</label>
    <input type="text" class="form-control" v-model="batchAdd.uid" placeholder="输入用户UID">
  </div>
  <button class="btn btn-success" @click="confirmBatchAddSecretPrice">批量添加密价</button>
</div>
<div class="table-responsive">
  <table class="table table-striped">
    <thead><tr><th><input type="checkbox" v-model="isAllChecked" @change="checkAll"></th><th>操作</th><th>ID</th><th>便捷排序</th><th>产品名称</th><th>便捷改价</th><th><span style="color:red;">顶级价格</span></th><th>快捷密价</th><th>查询接口</th><th>交单接口</th><th>查询参数</th><th>对接参数</th><th>下单计算</th><th>所在分类ID</th><th>状态</th><th>添加时间</th></tr></thead>
    <tbody>
      <tr v-for="res in row.data">
        <td><input type="checkbox" v-model="selectedItems" :value="res.cid"></td>
        <td>
          <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-update" @click="storeInfo=res">编辑</button>
          <button class="btn btn-xs btn-danger" @click="confirmDeleteItem(res.cid)">删除</button>
        </td>   
        <td>{{res.cid}}</td>
        <td><input type="text" v-model="res.newSort" class="form-control" placeholder="新排序"></td>
        <td>{{res.name}}</td>
        <td><input type="text" v-model="res.newPrice" class="form-control" placeholder="新价格"></td>
        <td><span style="color:red;">{{ formattedPrices[res.cid] }}</span></td>
        <td><input type="text" v-model="res.secretPrice" class="form-control" placeholder="密价"></td>
        <td>{{res.cx_name}}</td>
        <td>{{res.add_name}}</td>
        <td>{{res.getnoun}}</td>
        <td>{{res.noun}}</td>
        <td>{{res.yunsuan=='*'?"乘法":"加法"}}</td>
        <td><span class="btn btn-xs btn-info">{{res.fenlei}}</span></td>
        <td><span class="btn btn-xs btn-success" v-if="res.status==1">上架中</span><span class="btn btn-xs btn-danger" v-else-if="res.status==0">已下架</span></td>
        <td>{{res.addtime}}</td>
      </tr>
    </tbody>
  </table>
</div>
              
                 <ul class="pagination" v-if="row.last_page>1"><!--by 青卡 Vue分页 -->
                     <li class="disabled"><a @click="get(1)">首页</a></li>
                     <li class="disabled"><a @click="row.current_page>1?get(row.current_page-1):''">&laquo;</a></li>
                     <li  @click="get(row.current_page-3)" v-if="row.current_page-3>=1"><a>{{ row.current_page-3 }}</a></li>
                            <li  @click="get(row.current_page-2)" v-if="row.current_page-2>=1"><a>{{ row.current_page-2 }}</a></li>
                            <li  @click="get(row.current_page-1)" v-if="row.current_page-1>=1"><a>{{ row.current_page-1 }}</a></li>
                            <li :class="{'active':row.current_page==row.current_page}" @click="get(row.current_page)" v-if="row.current_page"><a>{{ row.current_page }}</a></li>
                            <li  @click="get(row.current_page+1)" v-if="row.current_page+1<=row.last_page"><a>{{ row.current_page+1 }}</a></li>
                            <li  @click="get(row.current_page+2)" v-if="row.current_page+2<=row.last_page"><a>{{ row.current_page+2 }}</a></li>
                            <li  @click="get(row.current_page+3)" v-if="row.current_page+3<=row.last_page"><a>{{ row.current_page+3 }}</a></li>                          
                     <li class="disabled"><a @click="row.last_page>row.current_page?get(row.current_page+1):''">&raquo;</a></li>
                     <li class="disabled"><a @click="get(row.last_page)">尾页</a></li>        
                 </ul>      
            </div>
          </div>
        <div class="modal fade primary" id="modal-update">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">平台修改</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-update">
                            <input type="hidden" name="action" value="update"/>
                            <input type="hidden" name="cid" :value="storeInfo.cid"/>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">排序</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="sort" class="layui-input" :value="storeInfo.sort" placeholder="输入数字,商品排序从小到大">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">平台名字</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="name" class="layui-input" :value="storeInfo.name" placeholder="输入平台名字">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">定价</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="price" class="layui-input" :value="storeInfo.price" placeholder="输入价格">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">查询参数</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="getnoun" class="layui-input" :value="storeInfo.getnoun" placeholder="输入标识">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">对接参数</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="noun" class="layui-input" :value="storeInfo.noun" placeholder="输入标识">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">说明</label>
                                <div class="col-sm-9"> 
                                  <textarea name="content" class="layui-textarea" rows="3" :value="storeInfo.content"></textarea>           
                               </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">查询平台</label>
                                <div class="col-sm-9">   
                                <select name="queryplat" :value="storeInfo.queryplat" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                    <option value="0">自营</option>
                                    <?php
                                             $a=$DB->query("select * from qingka_wangke_huoyuan");
                                             while($b=$DB->fetch($a)){              
                                                echo '<option value="'.$b['hid'].'">'.$b['name'].'</option>';   
                                             }
     
                                    ?>
                                </select>
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-sm-3 control-label">交单平台</label>
                                <div class="col-sm-9">   
                                <select name="docking" :value="storeInfo.docking" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">    
                                    <option value="0">自营</option>                                                               
                                    <?php
                                             $a=$DB->query("select * from qingka_wangke_huoyuan");
                                             while($b=$DB->fetch($a)){
                                                echo '<option value="'.$b['hid'].'">'.$b['name'].'</option>';   
                                             }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">代理下单算法</label>
                                <div class="col-sm-9">   
                                <select name="yunsuan" :value="storeInfo.yunsuan" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">                                                                    
                                   <option value="*">乘法</option>
                                   <option value="+">加法</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">状态</label>
                                <div class="col-sm-9">   
                                <select name="status" :value="storeInfo.status" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">
                                    <option value="1">上架</option>
                                    <option value="0">下架</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">分类</label>
                                <div class="col-sm-9">   
                                <select name="fenlei" :value="storeInfo.fenlei" class="layui-select" style="    background: url('../index/arrow.png') no-repeat scroll 99%;   width:100%">  
                                    <option value="">无</option>
                                    <?php
                                             $a=$DB->query("select * from qingka_wangke_fenlei ORDER BY `sort` ASC");
                                             while($b=$DB->fetch($a)){
                                                echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';    
                                             }
                                    ?>
                                </select>
                                </div>
                            </div>
                         </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="layui-btn layui-btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="layui-btn" @click="form('update')">确定</button>
                    </div>
                </div>
            </div>
        </div>
  
  
        <div class="modal fade primary" id="modal-add">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">平台添加</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-add">
                            <input type="hidden" name="action" value="add"/>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">排序</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="sort" class="form-control"  placeholder="输入数字,不填默认10,商品排序从小到大">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">平台名字</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="name" class="form-control"  placeholder="输入平台名字">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">定价</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="price" class="form-control"  placeholder="输入价格">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">查询参数</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="getnoun" class="form-control"  placeholder="输入标识">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">对接参数</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="noun" class="form-control" placeholder="输入标识">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">说明</label>
                                <div class="col-sm-9"> 
                                  <textarea name="content" class="form-control" rows="3"></textarea>           
                               </div>
                            </div>
                                                       <div class="form-group">
                                <label class="col-sm-3 control-label">查询平台</label>
                                <div class="col-sm-9">                              
                                    <select name="queryplat" class="form-control">
                                        <option value="0">自营</option>
                                        <?php
                                                $a=$DB->query("select * from qingka_wangke_huoyuan");
                                                 while($b=$DB->fetch($a)){
                                                    echo '<option value="'.$b['hid'].'">'.$b['name'].'</option>';   
                                                 }
                                        ?>
                                    </select>
                               </div>
                           </div>
                           <div class="form-group">
                                <label class="col-sm-3 control-label">对接平台</label>
                                <div class="col-sm-9">   
                                <select name="docking" class="form-control">
                                    <option value="0">自营</option>
                                    <?php
                                             $a=$DB->query("select * from qingka_wangke_huoyuan");
                                             while($b=$DB->fetch($a)){
                                                echo '<option value="'.$b['hid'].'">'.$b['name'].'</option>';   
                                             }
                                    ?>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">状态</label>
                                <div class="col-sm-9">   
                                <select name="status" class="form-control">
                                    <option value="1">上架</option>
                                    <option value="0">下架</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">分类</label>
                                <div class="col-sm-9">   
                                <select name="fenlei" class="form-control">
                                    <option value="">无</option>
                                    <?php
                                             $a=$DB->query("select * from qingka_wangke_fenlei ORDER BY `sort` ASC");
                                             while($b=$DB->fetch($a)){
                                                echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';    
                                             }
                                    ?>
                                </select>
                                </div>
                            </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" @click="form('add')">确定</button>
                    </div>
                </div>
            </div>
        </div>
  
  
  
  
    </div>
   </div>
 </div>

<?php require_once("footer.php");?> 
<script>
new Vue({
  el: "#orderlist",
  data: {
    row: null,
    storeInfo: {},
    search: {
      keyword: '',
      fenlei: '',
      huoyuan: '',
      shangjiastatus: ''
    },
    selectedItems: [],
    isAllChecked: false, 
    batchAdd: {
      uid: ''
    }
  },
  computed: {
    formattedPrices() {
      if (!this.row || !this.row.data) return {};
      return this.row.data.reduce((acc, res) => {
        acc[res.cid] = (res.price * 0.2).toFixed(2);
        return acc;
      }, {});
    }
  },
  methods: {
    get: function(page) {
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=classlist", {
        page: page,
        keyword: this.search.keyword,
        fenlei: this.search.fenlei,
        huoyuan: this.search.huoyuan,
        shangjiastatus: this.search.shangjiastatus
      }, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          this.row = data.body;
          this.row.data.forEach(item => {
            item.newPrice = item.price;
            item.newSort = item.sort;
            item.secretPrice = ''; 
          });
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    batchAddSecretPrice: function() {
      if (this.selectedItems.length === 0) {
        layer.msg('请选择要添加密价的课程', {icon: 2});
        return;
      }
      if (!this.batchAdd.uid) {
        layer.msg('请输入UID', {icon: 2});
        return;
      }
      let hasEmptyPrice = false;
      this.row.data.filter(item => this.selectedItems.includes(item.cid)).forEach(item => {
        if (!item.secretPrice) {
          hasEmptyPrice = true;
        }
      });

      if (hasEmptyPrice) {
        layer.msg('请输入具体价格', {icon: 2});
        return;
      }

      var secretPrices = this.row.data.filter(item => this.selectedItems.includes(item.cid)).map(item => {
        return {
          cid: item.cid,
          price: item.secretPrice
        };
      });

      var load = layer.load(2);
      this.$http.post("/apisub.php?act=batchaddsecretprice", {uid: this.batchAdd.uid, secretPrices: secretPrices}, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          this.get(this.row.current_page);
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    form: function(form) {
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=upclass", {data: $("#form-" + form).serialize()}, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        console.log($("#form-" + form).serialize())
        if (data.data.code == 1) {
          this.get(this.row.current_page);
          $("#modal-" + form).modal('hide');
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    deleteItem: function(cid) {
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=deleteclass", {cid: cid}, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          this.get(this.row.current_page);
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    batchDelete: function() {
      if (this.selectedItems.length === 0) {
        layer.msg('请选择要删除的商品', {icon: 2});
        return;
      }
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=batchdeleteclass", {cids: this.selectedItems}, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          this.get(this.row.current_page);
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    batchUpdateStatus: function(status) {
      if (this.selectedItems.length === 0) {
        layer.msg('请选择要修改状态的商品', {icon: 2});
        return;
      }
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=batchupdatestatus", {cids: this.selectedItems, status: status}, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          this.get(this.row.current_page);
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    applyBatchChanges: function() {
      if (this.selectedItems.length === 0) {
        layer.msg('请选择要修改的商品', {icon: 2});
        return;
      }
      var updates = this.row.data.filter(item => this.selectedItems.includes(item.cid)).map(item => {
        return {
          cid: item.cid,
          newPrice: item.newPrice,
          newSort: item.newSort
        };
      });
      var load = layer.load(2);
      this.$http.post("/apisub.php?act=batchupdatepricesort", {updates: updates}, {emulateJSON: true}).then(function(data) {
        layer.close(load);
        if (data.data.code == 1) {
          this.get(this.row.current_page);
          layer.msg(data.data.msg, {icon: 1});
        } else {
          layer.msg(data.data.msg, {icon: 2});
        }
      });
    },
    checkAll: function () {
      if (this.isAllChecked) {
        this.selectedItems = this.row.data.map(item => item.cid);
      } else {
        this.selectedItems = [];
      }
    },
    confirmDeleteItem: function(cid) {
      layer.confirm('确定要删除该课程？<span style="color:red;">此操作不可逆</span>，请谨慎操作！', {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
      }, () => {
        this.deleteItem(cid);
      }, () => {});
    },
    confirmBatchDelete: function() {
      layer.confirm('确定要批量删除所选课程？<span style="color:red;">此操作不可逆</span>，请谨慎操作！', {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
      }, () => {
        this.batchDelete();
      }, () => {});
    },
    confirmBatchUpdateStatus: function(status) {
      const action = status === 0 ? '下架' : '上架';
      layer.confirm(`确定要批量${action}所选商品？请谨慎操作！`, {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
      }, () => {
        this.batchUpdateStatus(status);
      }, () => {});
    },
    confirmApplyBatchChanges: function() {
      layer.confirm('确定要应用批量修改？<span style="color:red;">此操作不可逆</span>，请谨慎操作！', {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
      }, () => {
        this.applyBatchChanges();
      }, () => {});
    },
    confirmBatchAddSecretPrice: function() {
      const uid = this.batchAdd.uid;
      const confirmMsg = `确定要为用户UID为 <span style="color:red;">【${uid}】</span> 的用户批量添加所选课程密价？`;
      layer.confirm(confirmMsg, {
        btn: ['确定', '取消'],
        icon: 3,
        title: '谨慎操作',
        content: confirmMsg,
        yes: () => {
          this.batchAddSecretPrice();
        },
        cancel: () => {}
      });
    }
  },
  mounted() {
    this.get(1);
  }
});
</script>
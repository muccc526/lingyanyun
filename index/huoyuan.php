<?php
$title='编辑平台网课';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
?>
<div class="app-content-body ">
    <div class="wrapper-md control" id="orderlist">
        
        <div class="panel panel-default" >
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">平台列表&nbsp;<button class="btn btn-xs btn-light" data-toggle="modal" data-target="#modal-add">添加</button></div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead><tr><th>操作</th><th>ID</th><th>名称</th><th>平台</th><th>账号</th><th>密码</th><th>网址</th><th>密钥/token</th><th>添加时间</th></tr></thead>
                        <tbody>
                            <tr v-for="res in row.data">
                                <td>
                                    <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-update" @click="storeInfo=res">编辑
                                    </button>
                                    <button v-if="res.pt === 'xy'" class="btn btn-xs btn-primary" data-toggle="modal" @click="yjdj(res.hid)">一键对接</button>
                                    <button v-if="res.pt === '29'" class="btn btn-xs btn-primary" data-toggle="modal" @click="yjdj(res.hid)">一键对接</button>
                                    <button class="btn btn-xs btn-primary" @click="checkBalance(res.hid)">余额查询</button>
                                    <button class="btn btn-xs btn-danger"  @click="confirmDelete(res.hid)">删除</button>
                                </td>
                                <td>{{res.hid}}</td>
                                <td>{{res.name}}</td>
                                <td>{{res.pt}}</td>
                                <td>{{res.user}}</td>
                                <td>{{res.pass | asterisk}}</td>
                                <td>{{res.url}}</td>
                                <td>{{res.token | asterisk}}</td>
                                <td>{{res.addtime}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <ul class="pagination" v-if="row.last_page>1">
                    <!-- 分页代码保持不变 -->
                </ul>
            </div>
        </div>

        <!-- 修改弹窗 -->
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
                            <input type="hidden" name="hid" :value="storeInfo.hid"/>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">名称</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="name" class="layui-input" :value="storeInfo.name" placeholder="输入自定义名称">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">平台</label>
                                <div class="col-sm-9">   
                                    <select name="pt" class="layui-select" :value="storeInfo.pt" style="background: url('../index/arrow.png') no-repeat scroll 99%; width:100%">
                                        <?php
                                            $a=wkname();
                                            foreach($a as $key => $value){ 
                                                echo '<option value="'.$key.'">'.$value.'</option>';													
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">域名</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="url" class="layui-input" :value="storeInfo.url" placeholder="输入域名">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">账号</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="user" class="layui-input" :value="storeInfo.user" placeholder="输入账号,27对接填uid">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">密码</label>
                                <div class="col-sm-9">             
                                  <!-- 修改为password类型并添加placeholder -->
                                  <input type="password" name="pass" class="layui-input" placeholder="不修改请留空">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">密匙/token</label>
                                <div class="col-sm-9">             
                                  <!-- 修改为password类型并添加placeholder -->
                                  <input type="password" name="token" class="layui-input" placeholder="不修改请留空">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">cookie</label>
                                <div class="col-sm-9"> 
                                  <textarea name="cookie" placeholder="没必要，不用输入" class="layui-textarea" :value="storeInfo.cookie" rows="4"></textarea>           
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

        <!-- 添加弹窗 -->
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
                               <label class="col-sm-3 control-label">名称</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="name" class="form-control"  placeholder="输入自定义名称">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">平台</label>
                                <div class="col-sm-9">   
                                    <select name="pt" class="form-control">
                                        <?php
                                            $a=wkname();
                                            foreach($a as $key => $value){ 
                                                echo '<option value="'.$key.'">'.$value.'</option>';													
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">域名</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="url" class="form-control"  placeholder="输入域名">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">账号</label>
                                <div class="col-sm-9">             
                                  <input type="text" name="user" class="form-control"  placeholder="输入账号,27/29对接填uid">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">密码</label>
                                <div class="col-sm-9">             
                                  <!-- 添加时使用password类型 -->
                                  <input type="password" name="pass" class="form-control"  placeholder="输入密码">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">密匙/token</label>
                                <div class="col-sm-9">             
                                  <!-- 添加时使用password类型 -->
                                  <input type="password" name="token" class="form-control" placeholder="输入密匙/token">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">cookie</label>
                                <div class="col-sm-9"> 
                                  <textarea name="cookie"  placeholder="没必要，不用输入"  class="form-control" rows="4"></textarea>           
                               </div>
                            </div>                           
                         </form>
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

<?php require_once("footer.php");?>	
<script>
// 添加Vue过滤器处理星号显示
Vue.filter('asterisk', function (value) {
    return value ? '********' : '';
});

new Vue({
    el:"#orderlist",
    data:{
        row:null,
        storeInfo:{}
    },
    methods:{
        get:function(page){
            var load=layer.load(2);
            this.$http.post("/apisub.php?act=huoyuanlist",{page:page},{emulateJSON:true}).then(function(data){	
                layer.close(load);
                if(data.data.code==1){			                     	
                    this.row=data.body;			             			                     
                }else{
                    layer.msg(data.data.msg,{icon:2});
                }
            });	
        },
        checkBalance: function(hid) {
            var load = layer.load(2);
            this.$http.post("/apisub.php?act=checkbalance", { hid:hid}, { emulateJSON: true }).then(function(data) {
                layer.close(load);
                if (data.data.code == 1) {
                    layer.alert(
                        data.data.msg,
                        { icon: 1, title: "信息" }
                    );
                } else {
                    layer.msg(data.data.msg, { icon: 2 });
                }
            });
        },
        confirmDelete: function(hid) {
            layer.confirm('确定要删除该接口吗？', {
                title: '谨慎操作',
                icon: 3,
                btn: ['确定', '取消']
            }, () => {
                this.del(hid);
            });
        },
        del:function(hid){
            var load=layer.load(2);
            this.$http.post("/apisub.php?act=hy_del",{hid:hid},{emulateJSON:true}).then((data) => {	
                layer.close(load);
                if(data.data.code==1){
                    this.row.data = this.row.data.filter(item => item.hid !== hid);
                    layer.msg(data.data.msg,{icon:1});             			                     
                }else{
                    layer.msg(data.data.msg,{icon:2});
                }
            });	
        },
        yjdj: function(hid) {
            layer.confirm('确定对接该平台的项目吗？', {
                title: '温馨提示',
                icon: 1,
                btn: ['确定', '取消']
            }, function() {
                var category = prompt("请输入要对接的分类ID：");
                if (category != null) {
                    var pricee = prompt("请输入要增加的百分比价格：");
                    if (pricee != null) {
                        var load = layer.load(2);
                        $.get("/apisub.php?act=yjdj&hid=" + hid + "&pricee=" + pricee + "&category=" + category, function(data) {
                            layer.close(load);
                            if (data.code == 1) {
                                layer.msg(data.msg, { icon: 1 });
                            } else {
                                layer.msg(data.msg, { icon: 2 });
                            }
                        });
                    }
                }
            });
        },
        form:function(form){
            var load=layer.load(2);
            this.$http.post("/apisub.php?act=uphuoyuan",{data:$("#form-"+form).serialize()},{emulateJSON:true}).then(function(data){	
                layer.close(load);
                if(data.data.code==1){
                    this.get(this.row.current_page);
                    $("#modal-" + form).modal('hide');
                    layer.msg(data.data.msg,{icon:1});
                }else{
                    layer.msg(data.data.msg,{icon:2});
                }
            });	
        }
    },
    mounted(){
        this.get(1);
    }
});
</script>
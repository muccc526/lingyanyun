<?php
$title='公告';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
$uid=$_GET['uid'];
?>
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="assets/css/apps.css" type="text/css" />
<link rel="stylesheet" href="assets/css/app.css" type="text/css" />
<link rel="stylesheet" href="/assets/layui/css/layui.css" type="text/css" />
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="assets/LightYear/js/bootstrap-multitabs/multitabs.min.css">
<link href="assets/LightYear/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/LightYear/css/style.min.css" rel="stylesheet">
<link href="assets/LightYear/css/materialdesignicons.min.css" rel="stylesheet">
<script src="assets/js/jquery.min.js"></script>
<script src="layer/3.1.1/layer.js"></script>
<style>
   .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
    }

   .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

   .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 20px;
    }

   .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(20px);
        -ms-transform: translateX(20px);
        transform: translateX(20px);
    }
</style>
<body>
     <div class="app-content-body ">
        <div class="wrapper-md control" id="orderlist">
            
        <div class="panel panel-default" >
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">公告列表&nbsp;<button class="btn btn-xs btn-light" data-toggle="modal" data-target="#modal-add">添加</button></div>
                 <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead><tr><th>ID</th><th>标题</th><th>内容</th><th>时间</th><th>状态</th><th>置顶</th><th>发布人</th><th>操作</th></tr></thead>
                  <tbody>
                    <tr v-for="res in row.data">
                    	<td style="width:20px;">{{res.id}}</td>		            	
                    	<td style="width:100px;">{{res.title}}</td>
                    	<td>{{res.content}}</td>
                    	<td>{{res.time}}</td>
                    	<td>
                            <label class="switch">
                                <input type="checkbox" v-model="res.status === '1'" @change="toggleStatus(res.id)">
                                <span class="slider"></span>
                            </label>
                        </td>
                    	<td>
                            <label class="switch">
                                <input type="checkbox" v-model="res.zhiding === '1'" @change="toggleZhiding(res.id)">
                                <span class="slider"></span>
                            </label>
                        </td>
                    	<td>{{res.uid}}</td>
                    	<td style="width:120px;"><button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-update" @click="upm=res">编辑</button>
                    		&nbsp;<button class="btn btn-xs btn-danger"  @click="confirmDel(res.id)">删除</button>
                    	</td>    
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
                        <h4 class="modal-title">公告修改</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-update">
                            <input type="hidden" name="id" :value="upm.id"/>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">标题</label>
                                <div class="col-sm-9">             
                                  <input type="text" v-model="upm.title" class="form-control" :value="upm.title">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">内容</label>
                                <div class="col-sm-9">             
                               <textarea type="text" v-model="upm.content" class="layui-textarea"  rows="6" :value="upm.content"></textarea>
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">状态</label>
                                <div class="col-sm-9">             
                               <select v-model="upm.status" class="form-control">
                                	<option value="1">可见</option>
                                	<option value="0">不可见</option>
                                </select>
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">置顶</label>
                                <div class="col-sm-9">             
                                  <select v-model="upm.zhiding" class="form-control">
                                	<option value="0">不置顶</option>
                                	<option value="1">置顶</option>
                                </select>
                               </div>
                            </div>    
                                
                         </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="up_m">确定</button>
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
                        <h4 class="modal-title">公告添加</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-add">
                            <div class="form-group">
                               <label class="col-sm-3 control-label">标题</label>
                                <div class="col-sm-9">             
                                  <input type="text" v-model="addm.title" class="form-control">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">内容</label>
                                <div class="col-sm-9">             
                                 <textarea type="text" v-model="addm.content" class="layui-textarea"  rows="6"></textarea>
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">状态</label>
                                <div class="col-sm-9">             
                               <select v-model="addm.status" class="form-control">
                                	<option value="1">可见</option>
                                	<option value="0">不可见</option>
                                </select>
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">置顶</label>
                                <div class="col-sm-9">             
                                  <select v-model="addm.zhiding" class="form-control">
                                	<option value="0">不置顶</option>
                                	<option value="1">置顶</option>
                                </select>
                               </div>
                            </div>    
                                
                         </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" @click="add_m">确定</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
   </div>
 </div>
<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<?php require_once("footer.php");?>	
<script>
vm=new Vue({
    el:"#orderlist",
    data:{
        row:null,
        addm:{
            status:'1',
            zhiding:'0'
        },
        upm:{}
    },
    methods:{
        get:function(page){
          var load=layer.load(2);
             this.$http.post("/apisub.php?act=gglist1",{uid:this.uid},{emulateJSON:true}).then(function(data){	
              	layer.close(load);
              	if(data.data.code==1){			                     	
              		this.row=data.body;
                    if (this.row && this.row.data) {
                        this.row.data.forEach(item => {
                            item.status = String(item.status);
                            item.zhiding = String(item.zhiding);
                        });
                    }
              	}else{
                    layer.msg(data.data.msg,{icon:2});
              	}
            });	
        },
        add_m:function(){
            var load=layer.load(2);
         		this.$http.post("/apisub.php?act=ggadd",{data:this.addm,active:1},{emulateJSON:true}).then(function(data){	
              layer.close(load);
              if(data.data.code==1){	
                	vm.get(1);		                     	
                layer.msg(data.data.msg,{icon:1});             			                     
              }else{
                layer.msg(data.data.msg,{icon:2});
              }
        });	
        },
        up_m:function(){
            var load=layer.load(2);
         		this.$http.post("/apisub.php?act=upgg",{data:this.upm,active:2},{emulateJSON:true}).then(function(data){	
              layer.close(load);
              if(data.data.code==1){	
                    vm.get(1);		                     	
                layer.msg(data.data.msg,{icon:1});             			                     
              }else{
                layer.msg(data.data.msg,{icon:2});
              }
        });	
        },
        confirmDel:function(id) {
            layer.confirm('确定要删除该条公告吗？', {
                icon: 3,
                btn: ['确定', '取消'],
                title: '谨慎操作'
            }, function() {
                this.del(id);
            }.bind(this), function() {
            });
        },
        del:function(id){
            var load=layer.load(2);
         		this.$http.post("/apisub.php?act=gg_del",{id:id},{emulateJSON:true}).then(function(data){	
              layer.close(load);
              if(data.data.code==1){	
                    vm.get(1);		                     	
                layer.msg(data.data.msg,{icon:1});             			                     
              }else{
                layer.msg(data.data.msg,{icon:2});
              }
        });	
        },
        toggleStatus:function(id){
            var load=layer.load(2);
            this.$http.post("/apisub.php?act=toggleStatus",{id:id},{emulateJSON:true}).then(function(data){
                layer.close(load);
                if(data.data.code==1){
                    if (this.row && this.row.data) {
                        this.row.data.forEach(item => {
                            if (item.id === id) {
                                item.status = item.status === '1' ? '0' : '1';
                            }
                        });
                    }
                    layer.msg(data.data.msg,{icon:7});
                }else{
                    layer.msg(data.data.msg,{icon:7});
                }
            }.bind(this));
        },
        toggleZhiding:function(id){
            var load=layer.load(2);
            this.$http.post("/apisub.php?act=toggleZhiding",{id:id},{emulateJSON:true}).then(function(data){
                layer.close(load);
                if(data.data.code==1){
                    if (this.row && this.row.data) {
                        this.row.data.forEach(item => {
                            if (item.id === id) {
                                item.zhiding = item.zhiding === '1' ? '0' : '1';
                            }
                        });
                    }
                    layer.msg(data.data.msg,{icon:7});
                }else{
                    layer.msg(data.data.msg,{icon:7});
                }
            }.bind(this));
        }
    },
    mounted(){
        this.get(1);
    }
});
</script>    
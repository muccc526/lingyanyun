<?php
$title='编辑分类';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
$uid=$_GET['uid'];
?>
     <div class="app-content-body ">
        <div class="wrapper-md control" id="orderlist">
            
        <div class="panel panel-default" >
            <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">分类列表&nbsp;<button class="btn btn-xs btn-light" data-toggle="modal" data-target="#modal-add">添加</button></div>
                 <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead><tr><th>ID</th><th>排序</th><th>分类名称</th><th>状态</th><th>添加时间</th><th>操作</th></tr></thead>
                  <tbody>
                    <tr v-for="res in row.data">
                    	<td>{{res.id}}</td>		            	
                    	<td>{{res.sort}}</td>
                    	<td>{{res.name}}</td>
                    	<td><span class="btn btn-xs btn-success" v-if="res.status==1">已启用</span><span class="btn btn-xs btn-danger" v-else-if="res.status==0" @click="ktapi(res.uid)">未启用</span></td>
                    	<td>{{res.time}}</td>
                    	<td><button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-update" @click="upm=res">编辑</button>
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
                        <h4 class="modal-title">分类修改</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-update">
                            <input type="hidden" name="action" value="update"/>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">排序</label>
                                <div class="col-sm-9">             
                                  <input type="text" v-model="upm.sort" class="form-control" :value="upm.sort">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">分类名称</label>
                                <div class="col-sm-9">             
                                  <input type="text" v-model="upm.name" class="form-control" :value="upm.name" >
                               </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">状态</label>
                                <div class="col-sm-9">   
                                <select v-model="upm.status" :value="upm.status" class="layui-select" style="background: url('../index/arrow.png')no-repeat scroll 99%;width:100%">
                                    <option value="1">启用</option>
                                    <option value="0">关闭</option>
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
                        <h4 class="modal-title">分类添加</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-add">
                            <input type="hidden" name="action" value="add"/>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">排序</label>
                                <div class="col-sm-9">             
                                  <input type="text" v-model="addm.sort" class="form-control">
                               </div>
                            </div>
                            <div class="form-group">
                               <label class="col-sm-3 control-label">分类名称</label>
                                <div class="col-sm-9">             
                                  <input type="text" v-model="addm.name"class="form-control">
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
 
 
 
 
 
 
<?php require_once("footer.php");?>	
<script>
vm=new Vue({
    el:"#orderlist",
    data:{
        row:null,
        uid:"<?php echo $uid ?>",
        storeInfo:{},
        addm:{
            uid:"<?php echo $uid ?>",
        },
        upm:{}
    },
    methods:{
        get:function(page){
          var load=layer.load(2);
             this.$http.post("/apisub.php?act=fllist",{uid:this.uid},{emulateJSON:true}).then(function(data){	
              	layer.close(load);
              	if(data.data.code==1){			                     	
              		this.row=data.body;			             			                     
              	}else{
                    layer.msg(data.data.msg,{icon:2});
              	}
            });	
        },
        add_m:function(){
            var load=layer.load(2);
         		this.$http.post("/apisub.php?act=fl",{data:this.addm,active:1},{emulateJSON:true}).then(function(data){	
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
         		this.$http.post("/apisub.php?act=fl",{data:this.upm,active:2},{emulateJSON:true}).then(function(data){	
              layer.close(load);
              if(data.data.code==1){	
                    vm.get(1);		                     	
                layer.msg(data.data.msg,{icon:1});             			                     
              }else{
                layer.msg(data.data.msg,{icon:2});
              }
        });	
        },
        confirmDel: function(id) {
            layer.confirm('确定要删除该分类吗？', {
                btn: ['确定', '取消'],
                icon: 3,
                title: '谨慎操作'
            }, function() {
                this.del(id);
            }.bind(this), function() {
            });
        },
        del:function(id){
            var load=layer.load(2);
         		this.$http.post("/apisub.php?act=fl_del",{id:id},{emulateJSON:true}).then(function(data){	
              layer.close(load);
              if(data.data.code==1){	
                    vm.get(1);		                     	
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
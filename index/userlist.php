<?php
$mod='blank';
$title='用户列表';
require_once('head.php');
$khyue_row = $DB->get_row("SELECT k FROM qingka_wangke_config WHERE v='khyue' LIMIT 1");
$khyue = (float)$khyue_row['k'];
?>
     <div class="app-content-body ">
        <div class="wrapper-md control" id="userlist">
        	
	    <div class="panel panel-default"  style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
		    <div class="panel-heading font-bold bg-white" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">代理管理&nbsp;&nbsp;<br/><br/>
		    <el-button type="primary" size="small" data-toggle="modal" data-target="#modal-adduser">添加用户</el-button>
		    <el-button type="primary" size="small" data-toggle="modal" data-target="#modal-czgz">用户规则</el-button>
		    <?php if ($conf["khkg"] == "1" && $userrow['money'] >= $khyue) { ?>
                   <el-button type="primary" size="small" data-toggle="modal" data-target="#modal-khcz">跨户充值</el-button>
                     <?php } ?>
		    		    		     
		    </div>
				 <div class="panel-body" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
				     <div class="el-form layui-row layui-col-space10">
				      <div class="form-inline">	
						  	<div class="form-group">			          
				              <el-select class="select" name="type" v-model="type" style="    background: url('../index/arrow.png') no-repeat scroll 99%;width: 100%">
				                <el-option label="UID" value="1"></el-option>
	 		   				    <el-option label="用户名" value="2"></el-option>
	 		   				    <el-option label="邀请码" value="3"></el-option>
	 		   				    <el-option label="昵称" value="4"></el-option>
	 		   				    <el-option label="费率" value="5"></el-option>
	 		   					<el-option label="余额" value="6"></el-option>
	 		   					<el-option label="最后在线时间" value="7"></el-option>
				              </el-select>
			             </div>  
			              <div class="form-group">
				                <el-input v-model="qq" placeholder="请输入内容"></el-input>
			              </div>
			              <div class="form-group">
				               <el-button type="primary" icon="el-icon-search" @click="get(1)">查询用户</el-button>
			              </div>			              
			          </div>
		      <div class="table-responsive"> 
		           
		        <table class="table table-striped">
		          <thead><tr><th>ID</th><th>昵称</th><th>账号</th><th>余额</th><th>费率</th><th>订单</th><th>总充值</th><th>密匙</th>
		          		          
		           
		          <th>邀请码</th><th>封禁/正常</th><th>添加时间</th><th>操作</th><th>上级UID</th></tr></thead>
		          <tbody>
		            <tr v-for="res in row.data">
		            	<td>{{res.uid}}</td>		            	
		            	<td>{{res.name}}</td>
		            	<td>{{res.user}}</td>
		            	<td>{{res.money}}</td>
		            	<td>{{res.addprice}}</td>
		            	<td>{{res.dd}}</td>
		            	<td>{{res.zcz}}</td>
		            	<td><span class="el-button btn-xs btn-success" v-if="res.key==1">已开通</span><span class="el-button btn-xs btn-danger" v-else-if="res.key==0" @click="ktapi(res.uid)">未开通</span></td>
		            	<td><span class="el-button btn-xs btn-info" @click="yqm(res.uid,res.name)">{{res.yqm==''?'未设置':res.yqm}}</span></td>
		            	<td @click="ban(res.uid,res.active)"><span class="btn btn-xs btn-success" v-if="res.active==1">正常</span><span class="btn btn-xs btn-danger" v-else-if="res.active==0">封禁</span>
		            	</td>
		            	<td>{{res.addtime}}</td>
		                <td>
		                <button class="el-button btn-sm btn-success" @click="cz(res.uid,res.name)">余额充值</button>&nbsp;
		                <button class="el-button btn-sm btn-primary" @click="kc(res.uid,res.name)">余额扣除</button><br>
		                <button class="el-button btn-sm btn-info" data-toggle="modal" data-target="#modal-gjuser" @click="ddinfo(res)">修改费率</button>&nbsp;
		                <button class="el-button btn-sm btn-danger"  @click="czmm(res.uid)">重置密码</button></td> 
		                <td>{{res.uuid}}</td>
		            </tr>
		          </tbody>
		        </table>
		      </div>
		      
			     <ul class="pagination no-border" v-if="row.last_page>1"><!--by 青卡 Vue分页 -->
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
		  
		  <div class="modal fade primary" id="modal-gjuser">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">费率修改</h4>
                    </div>
                    
                    <div class="modal-body">
                        <form class="form-horizontal"  id="form-gjuser">
                            <input type="hidden" name="uid" :value="ddinfo3.info.uid"/>
							<div class="form-group">
                            	<label class="col-sm-2 control-label">选择等级</label>
                            	<div class="col-sm-9">   
	                            <select class="layui-select" name="addprice" style="background:url('../index/arrow.png')no-repeat scroll 99%;width:100%" >
								  <option v-for="row2 in row1.data" :value="row2.rate">{{row2.name}} [费率:{{row2.rate}}]</option>
							</select>
	                            </div>
                            </div>
                         </form>
                    </div>
                    <div class="modal-footer">
                        <el-button type="danger" data-dismiss="modal">取消</el-button>
                        <el-button type="primary" @click="gj()">确定</el-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade primary" id="modal-adduser">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">代理添加</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-adduser">
	                        <div class="form-group">
								<label class="col-sm-2 control-label">代理昵称:</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="name" placeholder="昵称" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">代理账号:</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="user" placeholder="必须填代理QQ" required>
								</div>
							</div>
						     <div class="form-group">
								<label class="col-sm-2 control-label">代理密码:</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="pass" placeholder="请填写密码!" required>
								</div>
							</div>
							<div class="form-group">
                            	<label class="col-sm-2 control-label">选择等级</label>
                            	<div class="col-sm-9">   
	                            <select class="layui-select" name="addprice" style="background:url('../index/arrow.png')no-repeat scroll 99%;width:100%" >
								  <option v-for="row2 in row1.data" :value="row2.rate">{{row2.name}} [费率:{{row2.rate}}]</option>
							</select>
	                            </div>
                            </div>
							
                         </form>
                    </div>
                    <div class="modal-footer">
                        <el-button type="danger" data-dismiss="modal">取消</el-button>
                        <el-button type="primary" @click="adduser()">确定</el-button>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
         <div class="modal fade primary" id="modal-khcz">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">跨户充值</h4>
                    </div>
           
                    <div class="modal-body">
                        <form class="form-horizontal" id="form-czuser">
	                        <div class="form-group">
								<label class="col-sm-3 control-label">请输入UID:</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="uid" placeholder="请输入对方账户UID" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">请输入充值金额:</label>
								<div class="col-sm-9">
									<input type="text" class="layui-input" name="rmb" placeholder="请输入充值金额" required>
								</div>
							</div>
							
                         </form>
                    </div>
                    <div class="modal-footer">
                        <el-button type="danger" data-dismiss="modal">取消</el-button>
                        <el-button type="primary" @click="khcz()">确定</el-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade primary" id="modal-czgz">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">充值规则</h4>
                    </div>
           
                    <div class="modal-body">
                    	           你旗下代理充值的时候页面将显示你的QQ<br>  	
                                   充值扣费：扣除费用=充值金额*(我的总价格/代理价格)<br>
                                   改价扣费：改价一次需要3元手续费，且代理余额会按照比例做相应调整<br>
                                   费率价格：代理费率必须是0.05的倍数，如：0.4,0.45,0.5 等等，以此类推，但不能高于你的费率                                                                                                                
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="layui-btn layui-btn-danger" data-dismiss="modal">取消</button>
                        <button type="button" class="layui-btn" data-dismiss="modal" @click="layer.msg('知道就好！')">知道了</button>
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
<script src="assets/layui/layui.js"></script>
<script src="assets/js/element.js"></script>


<script>
var vm=new Vue({
	el:"#userlist",
	data:{
		row:null,
		type:'1',
		qq:'',
		addprice:'',
		ddinfo3:{
		  	status:false,
		  	info:[]
		  },
		row1:'',
		storeInfo:{}
	},
	methods:{
		get:function(page){
		  var load=layer.load(2);
 			this.$http.post("/apisub.php?act=userlist",{type:this.type,qq:this.qq,page:page},{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.row=data.body;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
		},
		
		dj:function(){
		  var load=layer.load(2);
 			this.$http.post("/apisub.php?act=adddjlist",{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.row1=data.body;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
		},
		form:function(form){
		   var load=layer.load(2);
 			this.$http.post("/apisub.php?act="+form,{data:$("#form-"+form).serialize()},{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     		          		
	          		this.get(this.row.current_page);
	          		$("#modal-" + form).modal('hide');
	          		layer.msg(data.data.msg,{icon:1});	             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
		},ddinfo: function(a){  
      	    this.ddinfo3.info=a;
      },
      khcz: function() {
    var load = layer.load(2);

    var formData = $("#form-czuser").serializeArray();
    var uid = formData.find(item => item.name === 'uid').value;
    var money = formData.find(item => item.name === 'rmb').value;

    if (!uid ||!money) {
        layer.msg('请填写UID和充值金额', {icon: 2});
        return;
    }
    $.post("/apisub.php?act=khcz&get_confirm=1", {uid: uid, money: money}, function (data) {
        layer.close(load);
        if (data.code === 1) {
            var confirmMsg = data.confirmMsg;
            layer.confirm(confirmMsg, {
                btn: ['确定充值', '取消'],
                title: '跨户充值确认'
            }, function () {
                var load = layer.load(2);
                $.post("/apisub.php?act=khcz", {uid: uid, money: money}, function (data) {
                    layer.close(load);
                    if (data.code === 1) {
                        var msgParts = data.msg.match(/成功给(.*?)用户充值(.*?)元/);
                        var targetUser = msgParts[1];
                        var amount = msgParts[2];
                        layer.msg(`成功给${targetUser}用户充值${amount}元`, {icon: 1});
                        $("#modal-khcz").modal('hide');
                    } else {
                        layer.msg(data.msg, {icon: 2});
                    }
                }).fail(function () {
                    layer.close(load);
                    layer.msg('充值请求失败，请稍后再试', {icon: 2});
                });
            }, function () {
            });
        } else {
            layer.msg(data.msg, {icon: 2});
        }
    }).fail(function () {
        layer.close(load);
        layer.msg('获取充值信息失败，请稍后再试', {icon: 2});
    });
},
		adduser:function(){
	           var load=layer.load(2);
               $.post("/apisub.php?act=adduser",{data:$("#form-adduser").serialize()},function (data) {
		 	     layer.close(load);
	             if (data.code==1){    				
					layer.confirm(data.msg, {
					  btn: ['确定开通','取消'],title:'开通扣费' 
					}, function(){
					    var load=layer.load(2);
			 			vm.$http.post("/apisub.php?act=adduser",{data:$("#form-adduser").serialize(),type:1},{emulateJSON:true}).then(function(data){	
				          	layer.close(load);
				          	if(data.data.code==1){
				          	    vm.get(this.row.current_page);
	          		            $("#modal-adduser").modal('hide');			                     		          		
				          		layer.alert(data.data.msg,{icon:1});	             			                     
				          	}else{
				                layer.msg(data.data.msg,{icon:2});
				          	}
				        });	   
					}, function(){

					});					  									            
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
            });              
		},
		cz:function(uid,name){
			layer.prompt({title: '你将为<font color="red">'+name+'</font>充值请输入充值金额', formType: 3}, function(money, index){
			  layer.close(index);
			  var load=layer.load(2);
              $.post("/apisub.php?act=userjk",{uid:uid,money:money},function (data) {
		 	     layer.close(load);
	             if (data.code==1){
	             	vm.get(vm.row.current_page);	   
	                layer.alert(data.msg,{icon:1});
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }
              });		    		    
		  });
		},
		kc:function(uid,name){
			layer.prompt({title: '你将为<font color="red">'+name+'</font>扣款请输入扣除金额', formType: 3}, function(money, index){
			  layer.close(index);
			  var load=layer.load(2);
              $.post("/apisub.php?act=userkc1",{uid:uid,money:money},function (data) {
		 	     layer.close(load);
	             if (data.code==1){
	             	vm.get(vm.row.current_page);	   
	                layer.alert(data.msg,{icon:1});
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }
              });		    		    
		  });
		},
		gj:function(uid,name){
	           var load=layer.load(2);
               $.post("/apisub.php?act=usergj",{data:$("#form-gjuser").serialize()},function (data) {
		 	     layer.close(load);
	             if (data.code==1){    				
					layer.confirm(data.msg, {
					  btn: ['确定改价并充值','取消'],title:'改价扣费'  //按钮
					}, function(){
					    var load=layer.load(2);
			 			vm.$http.post("/apisub.php?act=usergj",{data:$("#form-gjuser").serialize(),type:1},{emulateJSON:true}).then(function(data){	
				          	layer.close(load);
				          	if(data.data.code==1){
				          	    vm.get(vm.row.current_page);		                     		          		
				          		layer.alert(data.data.msg,{icon:1});	             			                     
				          	}else{
				                layer.msg(data.data.msg,{icon:2});
				          	}
				        });	   
					}, function(){

					});					  									            
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
             });              
		},
		czmm:function(uid){
		    var load=layer.load(2);
 			vm.$http.post("/apisub.php?act=user_czmm",{uid:uid},{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     		          		
	          		layer.alert(data.data.msg,{icon:1});	             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	              	 
		},ktapi:function(uid){
			layer.confirm('给下级开通API，将扣除5元余额', {title:'温馨提示',icon:1,
				  btn: ['确定','取消'] //按钮
				}, function(){
				  		var load=layer.load(2);
		     			axios.get("/apisub.php?act=ktapi&type=2&uid="+uid)
				          .then(function(data){	
				          	   	layer.close(load);
				          	if(data.data.code==1){
				          		vm.get(vm.row.current_page);		                     	
		                        layer.alert(data.data.msg,{icon:1,title:"温馨提示"});							          				             			                     
				          	}else{
				                layer.msg(data.data.msg,{icon:2});
				          	}
				        });	
				
			    });
		},
		yqm:function(uid,name){
			layer.prompt({title: '你将为<font color="red">'+name+'</font>设置邀请码，邀请码最低4位数', formType: 3}, function(yqm, index){
			  layer.close(index);
	           var load=layer.load(2);
               $.post("/apisub.php?act=szyqm",{uid,yqm},function (data) {
		 	     layer.close(load);
	             if (data.code==1){
	             	vm.get(vm.row.current_page);		             	 
	                layer.alert(data.msg,{icon:1});	                
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
              });            
		  });		
		},ban:function(uid,active){
			var load=layer.load(2);
               $.post("/apisub.php?act=user_ban",{uid,active},function (data) {
		 	     layer.close(load);
	             if (data.code==1){
	             	vm.get(vm.row.current_page);		             	 
	                layer.msg(data.msg,{icon:1});	                
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
              });  
		},
		kh:function(uid,kuahu){
			var load=layer.load(2);
               $.post("/apisub.php?act=user_kh",{uid,kuahu},function (data) {
		 	     layer.close(load);
	             if (data.code==1){
	             	vm.get(vm.row.current_page);		             	 
	                layer.msg(data.msg,{icon:1});	                
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
              });  
		} 
	},
	mounted(){
		this.get(1);
		this.dj();
	}
});
</script>
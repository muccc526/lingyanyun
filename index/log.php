<?php
$mod='blank';
$title='日志列表';
require_once('head.php');
?>
     <div class="app-content-body ">
        <div class="wrapper-md control">
        	
	    <div class="panel panel-default" id="loglist">
		    <div class="panel-heading font-bold layui-bg-blue"  style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">操作日志</div>
				 <div class="panel-body"  style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
				     <div class="el-form layui-row layui-col-space10">
				 			<div class="form-inline">	
						  	<div class="form-group">			          
				              <el-select class="select"  v-model="type" style="scroll 99%;width:100%">
				                  <el-option label="请选择查询条件" value=""></el-option>
				                <el-option label="所有" value="所有"></el-option>
	 		   				    <el-option label="登录" value="登录"></el-option>
	 		   				    <el-option label="添加任务" value="添加任务"></el-option>
	 		   				    <el-option label="批量提交" value="批量提交"></el-option>
	 		   				    <el-option label="API添加任务" value="API添加任务"></el-option>
	 		   					<el-option label="上级充值" value="上级充值"></el-option>
	 		   					<el-option label="代理充值" value="代理充值"></el-option>
	 		   					<el-option label="修改费率" value="修改费率"></el-option>
	 		   				    <el-option label="查课" value="查课"></el-option>
	 		   				    <el-option label="API查课" value="API查课"></el-option>
	 		   				    <el-option label="在线充值" value="在线充值"></el-option>
	 		   				    <el-option label="订单退款" value="订单退款"></el-option>
				              </el-select>              			               
			            </div> 
			            <div class="form-group">			          
				               <el-select class="select"  v-model="types" style="scroll 99%;width:100%">
				                <el-option label="请选择查询条件" value=""></el-option>
				                <el-option label="用户UID" value="1"></el-option>
	 		   				    <el-option label="操作内容" value="2"></el-option>
	 		   				    <el-option label="积分变动" value="3"></el-option>
	 		   				    <el-option label="操作时间" value="4"></el-option>
	 		   				    
				              </el-select>              			               
			             </div>  
			              <div class="form-group">
				                <el-input v-model="qq" placeholder="请输入查询内容"></el-input>
			              </div> 
			              <div class="form-group">				              
				               <!--<input type="submit" @click="get(1,1)" value="查询" class="layui-btn"/>-->
				               <el-button type="primary" icon="el-icon-search" @click="get(1,1)">查询</el-button>
			              </div>			              
			          </div>
		      <div class="table-responsive">
		        <table class="table table-striped">
		          <thead><tr>
		          <th>
                    <label class="lyear-checkbox checkbox-info">
                      <input type="checkbox" id="check-all"><span>ID</span>
                    </label>
                  </th>
		          <th>用户ID</th>
		          <th>类型</th>
		          <th>积分变动</th>
		         <th>积分</th>
		          <th>操作内容</th>
		          <th>操作时间</th>
		          <th>操作IP</th></tr>
		          </thead>
		          <tbody>
		            <tr v-for="res in row.data">
		            	<!--<td>{{res.id}}</td>-->
		            	<td>
                            <label class="lyear-checkbox checkbox-info">
                              <input type="checkbox" v-model="sex"><span>{{res.id}}</span>
                            </label>
                        </td>
		            	<td>{{res.uid}}</td>
		            	<td>
		            	    <span class="btn btn-xs btn-success" v-if="res.type=='批量提交' ||res.type=='添加任务' || res.type=='API添加任务'">{{res.type}}</span>
		            	    <span class="btn btn-xs btn-danger" v-else-if="res.type=='删除订单信息'">{{res.type}}</span>
		            	    <span class="btn btn-xs btn-warning" v-else-if="res.type=='查课' || res.type=='API查课'">{{res.type}}</span>
		            	    <span class="btn btn-xs btn-warning" v-else-if="res.type=='代理充值'">代理充值</span>
		            	    <span class="btn btn-xs btn-success" v-else-if="res.type=='上级充值'">上级充值</span>
		            	    <span class="btn btn-xs btn-primary" v-else-if="res.type=='添加商户'">添加商户</span>
		            	    <span class="btn btn-xs btn-info" v-else-if="res.type=='修改费率' || res.type=='登录'">{{res.type}}</span>
		            	    <span class="btn btn-xs btn-default" v-else="">{{res.type}}</span></td>
		            	<td>{{res.money}}</td>
		            	<td>{{res.smoney}}</td>
		            	<td>{{res.text}}</td>
		            	<td>{{res.addtime}}</td>
		            	<td>{{res.ip}}</td>           	          	
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
new Vue({
	el:"#loglist",
	data:{
		row:null,
		sex:[],
		type:'',
		types:'',
		qq:''
	},
	methods:{
		get:function(page,a){
		  var load=layer.load(2);
		  data={page:page,type:this.type,types:this.types,qq:this.qq}
 			this.$http.post("/apisub.php?act=loglist",data,{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.row=data.body;			             			                     
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
<script>
             //禁止鼠标右击
      document.oncontextmenu = function() {
        event.returnValue = false;
      };
      //禁用开发者工具F12
      document.onkeydown = document.onkeyup = document.onkeypress = function(event) {
        let e = event || window.event || arguments.callee.caller.arguments[0];
        if (e && e.keyCode == 123) {
          e.returnValue = false;
          return false;
        }
      };
      let userAgent = navigator.userAgent;
      if (userAgent.indexOf("Firefox") > -1) {
        let checkStatus;
        let devtools = /./;
        devtools.toString = function() {
          checkStatus = "on";
        };
        setInterval(function() {
          checkStatus = "off";
          console.log(devtools);
          console.log(checkStatus);
          console.clear();
          if (checkStatus === "on") {
            let target = "";
            try {
              window.open("about:blank", (target = "_self"));
            } catch (err) {
              let a = document.createElement("button");
              a.onclick = function() {
                window.open("about:blank", (target = "_self"));
              };
              a.click();
            }
          }
        }, 200);
      } else {
        //禁用控制台
        let ConsoleManager = {
          onOpen: function() {
            alert("Console is opened");
          },
          onClose: function() {
            alert("Console is closed");
          },
          init: function() {
            let self = this;
            let x = document.createElement("div");
            let isOpening = false,
              isOpened = false;
            Object.defineProperty(x, "id", {
              get: function() {
                if (!isOpening) {
                  self.onOpen();
                  isOpening = true;
                }
                isOpened = true;
                return true;
              }
            });
            setInterval(function() {
              isOpened = false;
              console.info(x);
              console.clear();
              if (!isOpened && isOpening) {
                self.onClose();
                isOpening = false;
              }
            }, 200);
          }
        };
        ConsoleManager.onOpen = function() {
          //打开控制台，跳转
          let target = "";
          try {
            window.open("about:blank", (target = "_self"));
          } catch (err) {
            let a = document.createElement("button");
            a.onclick = function() {
              window.open("about:blank", (target = "_self"));
            };
            a.click();
          }
        };
        ConsoleManager.onClose = function() {
          alert("Console is closed!!!!!");
        };
        ConsoleManager.init();
      }
        </script>
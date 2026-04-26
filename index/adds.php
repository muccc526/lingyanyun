<?php
$title='批量交单';
require_once('head.php');
$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
?>

        <div class="wrapper-md control" id="add">
        <div class="row">	
        <div class="col-md-12">

        	
	    <div class="card panel-default">
		      <div class="panel-heading font-bold  bg-white">无查提交 </div>
				<div class="panel-body" id="tips">
					<form class="form-horizontal devform">
						<div class="form-group">
							<label class="col-sm-1 control-label">选择项目:</label>
						<div class="col-sm-9">
							<el-select id="select"  v-model="cid"  @change="tips(cid)" filterable placeholder="直接输入名称即可搜索" style="width:100%">
                                    <el-option
                                      v-for="class2 in class1"
                                      :key="class2.cid"
                                      :label="class2.name+'('+class2.price+'积分)'"
                                      :value="class2.cid">
                                    </el-option>
                                  </el-select>					
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-1 control-label">账号信息:</label>
							<div class="col-sm-9">
						    <textarea rows="6" class="layui-textarea" v-model="userinfo" placeholder="填写格式：&#10例： 手机号 密码 课程 &#10或： 学校 账号 密码 课程 &#10多账号下单必须换行！ &#10务必一行一条信息！ &#10且账号密码正确！"   style="border-radius: 8px;"></textarea>	
						    <div style="height:5px"></div>
                            <span class="help-block m-b-none" style="color:red;" id="warning">
						        <span v-html="content"></span>
						    </span>	
							</div>
							
						</div>
	                    <!--<div class="col-sm-offset-2 col-sm-4">-->
				  	    <div class="col-sm-offset-1">
				  	    		<input type="button" @click="add" value="立即提交" class="layui-btn layui-btn-normal"/>
				  	    			<input type="reset"  value="重置" class="layui-btn layui-btn-primary"/>
				  	    	
				  	    </div>

			        </form>
		        </div>
	        </div>
	        
	        
	        
	        
	    </div> 
	     
        
	   </div> 
	     
		 
       </div>
        <div  class="wrapper-md control" id="loglist"  style="margin-top:-35px" >
        <div  class="panel panel-default"   >
		    <!--<div class="panel-heading font-bold bg-success">提交结果</div>-->
		     <div class="panel-heading font-bold bg-white">提交结果</div>
				 <div class="panel-body">
				 			<!--<div class="form-inline">	-->
						  <!--	<div class="form-group">			          -->
				    <!--          <select class="form-control"  v-model="type">-->
				    <!--          	<option value="批量提交">批量提交</option>-->
				    <!--            <option value="登录">登录</option>-->
				    <!--            <option value="添加任务">添加任务</option>-->
				    <!--            <option value="批量提交">批量提交</option>-->
				    <!--            <option value="API添加任务">API添加任务</option>-->
				    <!--            <option value="上级充值">上级充值</option>-->
				    <!--            <option value="代理充值">代理充值</option>-->
				    <!--            <option value="修改费率">修改费率</option>-->
				    <!--            <option value="查课">查课</option>-->
				    <!--            <option value="API查课">API查课</option>-->
				    <!--          </select>              			               -->
			     <!--       </div> -->
			     <!--       <div class="form-group">			          -->
				    <!--          <select class="form-control"  v-model="types">-->
				    <!--          	<option value="">所有</option>-->
				    <!--            <option value="1">用户名</option>-->
				    <!--            <option value="2">余额变动</option>-->
				    <!--            <option value="3">时间</option>-->
				    <!--          </select>              			               -->
			     <!--        </div>  -->
			     <!--         <div class="form-group">				              -->
				    <!--            <input type="text" v-model="qq" value="" class="form-control" placeholder="请输入查询内容"/>				              -->
			     <!--         </div> -->
			     <!--         <div class="form-group">				              -->
				    <!--           <input type="submit" @click="get(1,1)" value="查询" class="btn btn-sm btn-primary form-control"/>				              -->
			     <!--         </div>			              -->
			     <!--     </div>-->
		      <div class="table-responsive">
		        <table class="table table-striped">
		          <thead>
		              <tr>
		                  <th>ID</th>
		                  <th>平台 学校 账号 密码 课程名称</th>
		                  <!--<th>操作人ID</th>-->
		                  <!--<th>类型</th>-->
		                  <th>预计扣费</th>
		                  <th>余额</th>
		                  <!--<th>操作内容</th>-->
		                  <th>操作时间</th>
		                  <!--<th>操作IP</th>-->
		              </tr>
		          </thead>
		          <tbody>
		            <tr v-for="res in row.data">
		            	<td>{{res.id}}</td>		  
		            	<!--<td>{{res.uid}}</td>-->
		            	<!--<td><span class="btn btn-xs btn-danger" v-if="res.type=='批量提交' ||res.type=='添加任务' || res.type=='API添加任务'">{{res.type}}</span><span class="btn btn-xs btn-warning" v-else-if="res.type=='代理充值'">代理充值</span><span class="btn btn-xs btn-success" v-else-if="res.type=='上级充值'">上级充值</span><span class="btn btn-xs btn-primary" v-else-if="res.type=='添加商户'">添加商户</span><span class="btn btn-xs btn-info" v-else-if="res.type=='修改费率'">修改费率</span><span class="btn btn-xs btn-default" v-else="">{{res.type}}</span></td>-->
		            	<td>{{res.text}}</td>
		            	<td>{{res.money}}</td>
		            	<td>{{res.smoney}}</td>
		            	<td>{{res.addtime}}</td>
		            	<!--<td>{{res.ip}}</td>           	          	-->
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
    
    

<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/axios.min.js"></script>>
<script src="assets/js/element.js"></script>



 <script type="text/javascript">
    /* 鼠标特效 */
    var a_idx = 0;
    jQuery(document).ready(function($) {
        $("body").click(function(e) {
            var a = new Array("富强","民主","文明","和谐","自由","平等","公正","法治","爱国","敬业","诚信","友善");
            var $i = $("<span />").text(a[a_idx]);
            a_idx = (a_idx + 1) % a.length;
            var x = e.pageX
              , y = e.pageY;
            $i.css({
                "z-index": 999999999999999999999999999999999999999999999999999999999999999999999,
                "top": y - 20,
                "left": x,
                "position": "absolute",
                "font-weight": "bold",
                "color": "#ff6651"
            });
            $("body").append($i);
            $i.animate({
                "top": y - 180,
                "opacity": 0
            }, 1500, function() {
                $i.remove();
            });
        });
    });
</script>

<script>

var vm=new Vue({
	el:"#add",
	data:{	
	    row:[],
	    check_row:[],
		userinfo:'',
		cid:'',
		miaoshua:'',
		class1:'',
		class3:'',
		activems:false,
		content:'',
	},
 		
	methods:{
	    add:function(){	 
			if(!this.cid){
				layer.msg("请先选择平台");return false;
			}
			if(!this.userinfo){
				layer.msg("请填写信息");return false;
			}
			userinfo=this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");
			userinfo=userinfo.split('[br]');//分割
			 
			
			for(var i=0;this.class1.length>i;i++){
				if(this.class1[i].cid==this.cid){
					var price=this.class1[i].price	 		
				}        	 	
			}
			
				
			kofei=price*userinfo.length;
			
			num = userinfo.length
			
			console.log(userinfo)
		 
			layer.confirm("检测到有<b style='color:red'>"+userinfo.length+"</b>条账号信息，具体扣费以提交结果为准", {title:'温馨提示',icon:3,btn: ['确定交单','取消']}, function(){
				var loading=layer.load(2);
				vm.$http.post("/apisub.php?act=add_pl",{cid:vm.cid,userinfo:userinfo,num:num},{emulateJSON:true}).then(function(data){
					layer.close(loading);
					if(data.data.code==1){
					    //layer.alert(data.data.msg,{icon:1,title:"提交结果"});
				 		layer.alert(data.data.msg,{icon:1,title:"提交结果"},function(){setTimeout(function(){window.location.href=""});});
					}else{
						layer.alert(data.data.msg,{icon:2,title:"提交结果"});
					}
				},function(){
					layer.close(loading);
					layer.alert("服务器错误");
				});
				
			  } 	 
			);	
	    },
	    getclass:function(){
		  var load=layer.load(2);
 			this.$http.post("/apisub.php?act=getclass_pl").then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.class1=data.body.data;		          			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
	    	
	    },
tips: function (message) {
        	 for(var i=0;this.class1.length>i;i++){
        	 	if(this.class1[i].cid==message){
        	 	    this.show = true;
        	 	    this.content = this.class1[i].content;
	    		return false;	
        	 		if(this.class1[i].miaoshua==1){
					   	 this.activems=true;
					   }else{
					   	 this.activems=false;
					   }
        	 		return false;
        	 		
        	 	}
        	 	
        	 }
	
        },
        tips2: function () {
        	layer.tips('秒刷几分钟干完，但不包平时分等内容，慎重选择', '#miaoshua',{tips:1});      	  
		  
        }    
	},
	mounted(){
		//this.scsz(100,1000,600);
		this.getclass();
	}
});


</script>

<script>

new Vue({
	el:"#loglist",
	data:{
		row:null,
		type:'' ,
		types:'',
		qq:''
	},
	methods:{
		get:function(page,a){
		  var load=layer.load(2);
		  data={page:page,type:this.type,types:this.types,qq:this.qq}
 			this.$http.post("/apisub.php?act=loglist1",data,{emulateJSON:true}).then(function(data){	
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
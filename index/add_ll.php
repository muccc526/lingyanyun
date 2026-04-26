<?php
$title='提交订单';
include('../confing/common.php');
$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
?>
<link rel="stylesheet" href="assets/css/element.css">
<meta name="author" content="qingka">
<link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../assets/css/app.css" type="text/css" />
<link rel="stylesheet" href="../assets/layui/css/layui.css" type="text/css" />
<link href="assets/LightYear/css/materialdesignicons.min.css" rel="stylesheet">
<link href="assets/LightYear/css/style.min.css" rel="stylesheet"/>
<script src="../assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/layer/3.1.1/layer.js"></script>
<link href="./assets/css/tailwind.min.css" rel="stylesheet">
<script src="https://at.alicdn.com/t/font_1185698_xknqgkk0oph.js?spm=a313x.7781069.1998910419.40&file=font_1185698_xknqgkk0oph.js"></script>
<style type="text/css">
    .susuicon {
        position: absolute;
    left: 21px;
    top: 14px;
       width: 1.3em; height: 1.3em;
       vertical-align: -0.15em;
       fill: currentColor;
       overflow: hidden;
    }
    .susuicon2 {
     position: absolute;
    top: 50%;
    right: 20px;
    margin-top: -7px;
    transition: transform .3s;
       width: 1.1em; height: 1.1em;
       vertical-align: -0.15em;
       fill: currentColor;
       overflow: hidden;
    }
    .flex{height: 2em; width: 2em;   vertical-align: -0.15em;
       fill: currentColor;float:left; position: absolute;
    bottom: 7px;
    left: 5px;
       overflow: hidden;}
       
    .flex2{height: 1.4em; width: 1.4em;   vertical-align: -0.15em;
       fill: currentColor;float:left;margin-top:2px;margin-right: 5px;
       overflow: hidden;}
    .malet{padding-left:20px;font-size:11px;}
    .nav>li:hover{
        background-color: #f8f8ff;
    }
    hr {
    height: 1px;
    margin: 4px;
        
    }
    
    
    .frosss{    height: 38px;
    border-radius: 8px !important; border: 2px solid rgb(236, 236, 236);
    border-color: #ebebeb;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    padding: 5px 12px;
    line-height: inherit;
    -webkit-transition: 0.2s linear;
    transition: 0.2s linear;
    -webkit-box-shadow: none;
    box-shadow: none;}
      .frosss2{ 
           border-radius: 8px !important; border: 2px solid rgb(236, 236, 236);
           display: block;
    width: 100%;
          height: 38px;
    border-color: #ebebeb;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    padding: 5px 12px;
    line-height: inherit;
    -webkit-transition: 0.2s linear;
    transition: 0.2s linear;
    -webkit-box-shadow: none;
    box-shadow: none;}
    .table>thead>tr>th {
    padding: 20px;
</style>
<style>
.lioverhide {
     width: 300px
  }
</style>
   <div class="app-content-body ">
        <div class="wrapper-md control" id="add">
	       <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
		    <div class="panel-heading font-bold " style="border-top-left-radius: 8px; border-top-right-radius: 8px;background-color:#fff;">
		    <div style="float:right;margin-right:20px"><el-link type="primary"></el-link></div>
			    订单提交
		     </div>
				<div class="panel-body">
					<el-form class="form-horizontal devform">
					    <?php if ($conf['flkg']=="1"&&$conf['fllx']=="1") {?>
					    <div class="form-group">
					        <label class="col-sm-2 control-label">项目分类</label>
					        <div class="col-sm-9">
					            <select class="layui-select" v-model="id" @change="fenlei(id);"  style="scroll 99%; border-radius: 8px; width:100%" >
					                <option value="">全部分类</option>
					                <?php 
					                $a=$DB->query("select * from qingka_wangke_fenlei where status=1  ORDER BY `sort` ASC");
					                while($rs=$DB->fetch($a)){
					                ?>
					                <option :value="<?=$rs['id']?>"><?=$rs['name']?></option>
					                <?php } ?>
					                </select>
					         </div>
					         </div>
					    <?php } else if ($conf['flkg']=="1"&&$conf['fllx']=="2") {?>
					    <div class="form-group">
					        <label class="col-sm-2 control-label">项目分类</label>
					        <div class="col-sm-9">
					            <div class="col-xs-12">
					                <div class="example-box">
					                    <label class="lyear-radio radio-inline radio-info">
					                        <input type="radio" name="e" checked="" @change="fenlei('');"><span style="color: #1e9fff;">全部</span>
					                    </label>
					                    <?php
					                    $a=$DB->query("select * from qingka_wangke_fenlei where status=1  ORDER BY `sort` ASC");
					                    while($rs=$DB->fetch($a)){
					                    ?>
					                    <label class="lyear-radio radio-inline radio-info">
					                        <input type="radio" name="e" @change="fenlei(<?=$rs['id']?>);"><span style="color: #1e9fff;"><?=$rs['name']?></span>
					                    </label>
					                    <?php } ?>
					                </div>
					            </div>
					         </div>
						</div>
					    <?php }?>
						<div class="form-group">
							<label class="col-sm-2 control-label">选择平台</label>
						<div class="col-sm-9">
							<el-select id="select" v-model="cid" filterable @change="tips(cid)" popper-class="lioverhide" :popper-append-to-body ="false" placeholder="点击选择下单平台" style=" scroll 99%;   width:100%">
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
							<label class="col-sm-2 control-label">信息填写</label>
							<div class="col-sm-9">
						    <!--<input  class="layui-input" v-model="userinfo" required/> -->	
						    <el-input v-model="userinfo" placeholder="请输入下单信息" prefix-icon="el-icon-search"></el-input>
						    <!--<span class="help-block m-b-none" style="color:red;"><span v-html="content"></span>
						    </span>-->
							</div>
						</div>
							<div class="form-group">
							<label class="col-sm-2 control-label">网课说明</label>
							<div class="col-sm-9">
						    <!--<span class="help-block m-b-none" style="color:red;"><span v-html="content"></span></span>-->
						    <el-input placeholder="请选择商品查看说明" type="textarea":rows="3" v-model="content" :disabled="true"></el-input>
						    
							</div>
						</div>
				  	    <div class="col-sm-offset-2">
				  	    	<el-button type="primary" @click="get" icon="el-icon-search" round>立即查询</el-button>
				  	    	<el-button type="primary" @click="add" icon="el-icon-circle-check" round>提交订单</el-button>
				  	        <!--<button class="btn btn-label btn-round btn-warning" type="reset"  value="清空数据"><label><i class="mdi mdi-delete-empty"></i></label> 清空数据</button>-->
				  	        
				  	    </div>

			        </el-form>
		        </div>
	     </div>
	     


	    <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
		   
		    <div class="panel-heading font-bold " style="border-top-left-radius: 8px; border-top-right-radius: 8px;background-color:#fff;">
			    查询结果 &nbsp;
			    <a class="el-button el-button--primary   is-plain el-button--mini" style="padding: 4px 10px;" @click="selectAll()">全选</a>
		     </div>
				<div class="panel-body">
					<form class="form-horizontal devform">		
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							  <div v-for="(rs,key) in row">
								  <div class="panel panel-default">
								    <div class="panel-heading" role="tab" id="headingOne">
								      <h4 class="panel-title">								
								        <a role="button" data-toggle="collapse" data-parent="#accordion" :href="'#'+key" aria-expanded="true" >
								         <b>{{rs.userName}}</b>  {{rs.userinfo}} <span v-if="rs.msg=='查询成功'"><b style="color: green;">{{rs.msg}}</b></span><span v-else-if="rs.msg!='查询成功'"><b style="color: red;">{{rs.msg}}</b></span>
								        </a>
								      </h4>
								    </div>
								    <div :id="key" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
								        <div class="panel-body">
								      	    <div v-for="(res,key) in rs.data">
								      	        <label class="layui-table lyear-checkbox checkbox-inline checkbox-success">
								      	  	        <li><input style="margin-left: 0px;" :checked="checked" name="checkbox" type="checkbox" :value="res.name" @click="checkResources(rs.userinfo,rs.userName,rs.data,res.name,res.id)"><span>{{res.name}} - {{res.credit}} </span><br><span v-if="res.id!=''"> [课程ID:{{res.id}}] </span><!--<span v-if="res.sort!=''"> [课程序号:{{res.sort}}] </span>--></li>
								                </label>
									      </div>
								      </div>
								    </div>
								  </div>
							</div>
					</div>			
			        </form>
		        </div>
       </div>
        <div class="panel panel-default" style="box-shadow: 8px 8px 15px #d1d9e6, -18px -18px 30px #fff; border-radius:8px;">
               <div class="panel-heading font-bold bg-white" style="border-radius: 10px;">注意事项</div>
               <div class="panel-body">
                  <ul class="layui-timeline">
                      <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>请务必查看项目下单须知和说明，防止出现错误！</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>同商品重复下单，请修改密码后再下！</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>默认下单格式为学校、账号、密码(空格分开)！</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>查课出问题及时反馈！</p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
    </div>
<script>
    
$(document).ready(function(){
 $("#btn4").click(function(){ 
$("input[name='checkbox']").each(function(){ 
if($(this).attr("checked")) 
{ 
$(this).removeAttr("checked"); 
} 
else
{ 
$(this).attr("checked","true"); 
} 
}) 
}) 




}); 
</script>


<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="../assets/js/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script src="https://cdn.staticfile.org/axios/0.18.0/axios.min.js"></script>
<script src="./assets/js/element.js"></script>




<script>
var vm=new Vue({
	el:"#add",
	data:{	
	    row:[],
	    shu:'',
	    bei:'',
	    nochake:0,
	    check_row:[],
		userinfo:'',
		cid:'',
		miaoshua:'',
		class1:'',
		class3:'',
		activems:false,
		checked:false,
		content:''
	},
	methods:{
	    get:function(salt){
	    	if(this.cid=='' || this.userinfo==''){
	    		layer.msg("所有项目不能为空");
	    		return false;
	    	}
		    userinfo=this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");      	           	    
	   	    userinfo=userinfo.split('[br]');//分割
	   	    this.row=[];
	   	    this.check_row=[];    	
	   	    for(var i=0;i<userinfo.length;i++){	
	   	    	info=userinfo[i]
	   	    	if(info==''){continue;}
	   	    	var hash=getENC('<?php echo $addsalt;?>');
	   	    	var loading=layer.load();
	    	    this.$http.post("/apisub.php?act=get",{cid:this.cid,userinfo:info,hash},{emulateJSON:true}).then(function(data){
	    		     layer.close(loading);	    	
	    		     if(data.body.code==-7){
	    	            salt=getENC(data.body.msg);
	    	            vm.get(salt);
	    	        }else{
	    	            this.row.push(data.body);
	    	        }
	    			    
	    	    });
	   	    }	   	    	    
	    },
	    add:function(){
	    	if(this.cid==''){
	    	    if(this.nochake!=1){
    	    		layer.msg("请先查课");
    	    		return false;
	    	    }
	    	} 	
	    	if(this.check_row.length<1){
	    	    if(this.nochake!=1){
    	    		layer.msg("请先选择课程");
    	    		return false;
	    	    }
	    	} 	
	    	//console.log(this.check_row);
	        var loading=layer.load();
	    	this.$http.post("/apisub.php?act=add",{cid:this.cid,data:this.check_row,shu:this.shu,bei:this.bei,userinfo:this.userinfo,nochake:this.nochake},{emulateJSON:true}).then(function(data){
	    		layer.close(loading);
	    		if(data.data.code==1){
	    			this.row=[];
	    			this.check_row=[]; 
	    			/*this.$message({type: 'success', showClose: true,message: data.data.msg});*/
        	    	layer.msg('提交成功',{icon:1,time:2000}, function(){
                    setTimeout('window.location.reload()',1000);
                    });
	    		}else{
	    			this.$message({type: 'error', showClose: true,message: data.data.msg});
	    		}
	    	});
	    },
	    check888:function(userinfo,userName,rs,name){
	        var btns=document.getElementById("btns");
	        var  zk= document.getElementById("s1");
	        var x= zk.getElementsByTagName("input");
        	if(btns.checked==true) {
        		for(var i=0   ; i < x.length; ++i) {
                    data={userinfo,userName,data:rs[i]};
        			x[i].checked=true;
        		    vm.check_row.push(data);
        		}
        	}else {
        		for(var i=0; i < x.length; ++i) {
        			x[i].checked=false; 
        		}
        		 this.check_row = []
        	}
	    },
	    selectAll:function () {            
            if(this.cid==''){
	    		layer.msg("请先查课");
	    		return false;
	    	} 	
	    	this.checked=!this.checked;  
	    	if(this.check_row.length<1){
		    	for(i=0;i<vm.row.length;i++){
		    		console.log(i);
		    		userinfo=vm.row[i].userinfo
		    		userName=vm.row[i].userName
		    		rs=vm.row[i].data
		            for(a=0;a<rs.length;a++){
			    		aa=rs[a]
			    		data={userinfo,userName,data:aa}
			    		vm.check_row.push(data);
			        } 				    	
				}     	          
            }else{
            	vm.check_row=[]
            }   	    
	    	console.log(vm.check_row);                            
        },
	    checkResources:function(userinfo,userName,rs,name){
	    	for(i=0;i<rs.length;i++){
	    		if(rs[i].name==name){
	    			aa=rs[i]
	    		}	    		
	    	}
	    	data={userinfo,userName,data:aa}
	    	if(this.check_row.length<1){
	    		vm.check_row.push(data); 
	    	}else{
	    	    var a=0;
		    	for(i=0;i<this.check_row.length;i++){		    		
		    		if(vm.check_row[i].userinfo==data.userinfo && vm.check_row[i].data.name==data.data.name){		    			
	            		var a=1;
	            		vm.check_row.splice(i,1);	
		    		}	    		
		    	}	    	   	    	               
               if(a==0){
               	   vm.check_row.push(data);
               }
	    	} 
	    },
	    fenlei:function(id){
		  var load=layer.load(2);
 			this.$http.post("/apisub.php?act=getclassfl",{id:id},{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.class1=data.body.data;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
	    	
	    },
	    getclass:function(){
		  var load=layer.load();
 			this.$http.post("/apisub.php?act=getclass").then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.class1=data.body.data;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
	    	
	    },
	    getnock:function(cid){
 			this.$http.post("/apisub.php?act=getnock").then(function(data){	
	          	if(data.data.code==1){			                     	
	          		this.nock=data.body.data;	
	          		for(i=0;this.nock.length>i;i++){
	          		    if(cid==this.nock[i].cid){
	          		        this.nochake=1;
	          		        break;
	          		    }else{
	          		        this.nochake=0;
	          		    }
	          		}
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
	    	
	    },tips: function (message) {
        	 for(var i=0;this.class1.length>i;i++){
        	 	if(this.class1[i].cid==message){
        	 	    this.show = true;
        	 	    this.content = this.class1[i].content;
                    /*layer.open({
                	 		    type: 0 
                                ,title: '商品说明'
                                ,content: this.class1[i].content
                                ,time: 5000
                                ,shade: 0  //不显示遮罩
                                ,anim: 1
                                ,maxmin: true
                                ,
                            });*/
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
	    /*tips: function (message) {
        	for(var i=0;this.class1.length>i;i++){
        	 	if(this.class1[i].cid==message){
                    this.$notify({
                        title: this.class1[i].name+'说明：',
                        dangerouslyUseHTMLString: true,
                        duration: 6000,
                        // showClose: false,
                        message:'<span style="font-size:14px;">'+this.class1[i].content+'</font>',
                    });
                    if(this.class1[i].miaoshua==1){
					   	 this.activems=true;
				   }else{
				   	 this.activems=false;
				   }
        	 		return false;
        	 	}
        	}
        },*/
        tips2: function () {
        	layer.tips('开启秒刷将额外收0.05的费用', '#miaoshua');      	  
		  
        }    
	},
	mounted(){
		this.getclass();		
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
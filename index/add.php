<?php
$title='批量查询';
require_once('head.php');
$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
?>
<style>
.lioverhide {
     width: 300px
  }
</style>
<link rel="stylesheet" href="assets/LightYear/js/ion-rangeslider/ion.rangeSlider.min.css">
<script type="text/javascript" src="assets/LightYear/js/ion-rangeslider/ion.rangeSlider.min.js"></script>
<link rel="stylesheet" href="assets/css/element.css" type="text/css" />
     
     
     <div class="app-content-body ">
        <div class="wrapper-md control" id="add">
            <div class="layui-row layui-col-space5">
            <div class="layui-col-md6">
	       <div class="panel panel-default" style="border-radius: 10px;">
				<div class="panel-body" >
					<form class="form-horizontal devform">
					    <?php if ($conf['flkg']=="1"&&$conf['fllx']=="1") {?>
					    <div class="form-group">
					        <label class="col-sm-2 control-label">项目分类</label>
					        <div class="col-sm-9">
					            <select class="layui-select" v-model="id" @change="fenlei(id);"  style="    background: url('../index/arrow.png') no-repeat scroll 99%; border-radius: 8px; width:100%" >
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
					                    <label class="lyear-radio radio-inline radio-primary">
					                        <input type="radio" name="e" checked="" @change="fenlei('');"><span>全部</span>
					                    </label>
					                    <?php
					                    $a=$DB->query("select * from qingka_wangke_fenlei where status=1  ORDER BY `sort` DESC");
					                    while($rs=$DB->fetch($a)){
					                    ?>
					                    <label class="lyear-radio radio-inline radio-primary">
					                        <input type="radio" name="e" @change="fenlei(<?=$rs['id']?>);"><span style="color: #1e9fff;"><?=$rs['name']?></span>
					                    </label>
					                    <?php } ?>
					                </div>
					            </div>
					         </div>
						</div>
					    <?php }?>
						<div class="form-group">
                        <label class="col-sm-2 control-label">搜索/选择</label>
                        <div class="col-sm-9">
                           <form class="form-horizontal" id="form-update">
                              <template>
<el-select
id="select"
v-model="cid"
@change="tips(cid)"
popper-class="lioverhide" :popper-append-to-body ="false" filterable placeholder="直接输入名称即可搜索" 
style=" background: url('../index/arrow.png') no-repeat scroll 99%; width:100%">
                                    <el-option v-for="class2 in class1" :label="class2.name+'→'+class2.price+'积分'" :value="class2.cid">
                                       <span style="float: left">{{ class2.cid }} ★ {{ class2.name }}</span>
                                       <span style="float: right; color: #8492a6; font-size: 13px">{{ class2.price }}积分</span>
                                    </el-option>
                                 </el-select>
                              </template>
                        </div>
                     </div>
						<div v-show="show">
						<div class="form-group" id="score" style="display: none;">
									<label class="col-sm-2 control-label">分数设置</label>
									<div class="col-sm-9 col-xs-8">
										<input id="range_02">
										<small class="form-text text-muted">{{score_text}}</small>
									</div>
								</div>
								<div class="form-group" id="shic" style="display: none;">
									<label class="col-sm-2 control-label">时长设置</label>
									<div class="col-sm-9 col-xs-8">
										<input id="range_01">
										<small class="form-text text-muted">{{shichang_text}}</small>
									</div>
								</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">信息填写</label>
							<div class="col-sm-9">
						    <textarea rows="5" class="layui-textarea" v-model="userinfo" placeholder="下单格式：账号 密码（中间用空格分隔）&#10或：           学校 账号 密码 （中间用空格分隔）&#10多账号下单必须换行，务必一行一条信息"   style="border-radius: 8px;"></textarea>	
						    <span class="help-block m-b-none" style="color:red;" id="warning">
						        <span v-html="content"></span>
						    </span>				
							</div>
						</div>
	
				  	    <div class="col-sm-offset-2 col-sm-12">
				  	    	<button type="button" @click="get" style="border-radius: 13px;" class="layui-btn layui-btn-sm"/> ☆ 查课 </button>
				  	    	<button type="button" @click="add" style="border-radius: 13px;" class="layui-btn layui-btn-sm layui-btn-normal"/> ☆ 提交 </button>
				  	    	<button type="reset" style="border-radius: 10px;" class="layui-btn layui-btn-sm layui-btn-primary"/> 重置 </button>
				  	    </div>
				  	    </div>
			        </form>
		        </div>
	     </div>
	     </div>
	     <div class="layui-col-md6" v-show="show1">
	    <div class="panel panel-default" style="border-radius: 10px;">
		     <div class="panel-heading font-bold bg-white" style="border-radius: 10px;">
			    查询结果
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
								      	  <div v-for="(res,key) in rs.data" class="checkbox checkbox-success">
								      	  	   <li><input type="checkbox" :value="res.name" @click="checkResources(rs.userinfo,rs.userName,rs.data,res.id,res.name)"><label for="checkbox1"></label><span>{{res.name}}</span><span v-if="res.id!=''">[课程ID:{{res.id}}]</span>                                       </li>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
            <div class="layui-col-md6">
            <div class="panel panel-default" style="border-radius: 10px;">
               <div class="panel-heading font-bold bg-white" style="border-radius: 10px;">免责声明：
               <div class="panel-body">
                  <ul class="layui-timeline">
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text" style="color:red">
                           <p>本站无任何自营项目，所有项目均来自互联网现有渠道</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>本站仅负责将订单提交至上游，订单到上游后无法退款</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>本站对各项目的具体功能并不了解,亦不对项目质量负责</p>
                        </div>
                     </li>
                     <li class="layui-timeline-item">
                        <i class="layui-icon layui-timeline-axis"></i>
                        <div class="layui-timeline-content layui-text">
                           <p>如有需要的项目尚未上架，且市面有此项目，可向上联系上架</p>
                        </div>
                     </li>
                  </ul>
               </div>
            </div>
   </div>
</div>

<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="assets/js/vue.min.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/axios.min.js"></script>
<script src="assets/js/element.js"></script>

<script>
var vm=new Vue({
	el:"#add",
	data:{	
	    row:[],
	    check_row:[],
		userinfo:'',
		cid:'',
		id:'',
		score_text: '',
		shichang_text: '',
		class1:'',
		class3:'',
		show: false,
		show1: false,
		content:'',
	},
	methods:{
	    get:function(){
	    	if(this.cid=='' || this.userinfo==''){
	    		layer.msg("信息格式错误，请检查");
	    		return false;
	    	}
		    userinfo=this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");      	           	    
	   	    userinfo=userinfo.split('[br]');//分割
	   	    this.row=[];
	   	    this.check_row=[];    	
	   	    for(var i=0;i<userinfo.length;i++){	
	   	    	info=userinfo[i]
	   	    	var hash=getENC('<?php echo $addsalt;?>');
	   	    	var loading=layer.load(2);
	    	    this.$http.post("/apisub.php?act=get",{cid:this.cid,userinfo:info,hash},{emulateJSON:true}).then(function(data){
	    		     layer.close(loading);	    	
	    		     this.show1 = true;
	    			 this.row.push(data.body);
	    	    });
	   	    }	   	    	    
	    },
	    add:function(){
	    	if(this.cid==''){
	    		layer.msg("请先查课");
	    		return false;
	    	} 	
	    	if(this.check_row.length<1){
	    		layer.msg("请先选择课程");
	    		return false;
	    	} 	
	        var loading=layer.load(2);
	        score = $("#range_02").val();
            shichang = $("#range_01").val();
	    	this.$http.post("/apisub.php?act=add",{
	    	    cid:this.cid,
	    	    data:this.check_row,
	    	    shichang: shichang,
                score: score
	    	},{emulateJSON:true}).then(function(data){
	    		layer.close(loading);
	    		if(data.data.code==1){
	    			this.row=[];
	    			this.check_row=[]; 
	    			layer.alert(data.data.msg,{icon:1,title:"温馨提示"},function(){setTimeout(function(){window.location.href=""});});
	    		}else{
	    			layer.alert(data.data.msg,{icon:2,title:"温馨提示"});
	    		}
	    	});
	    },
	    checkResources:function(userinfo,userName,rs,id,name){
	        for(i=0;i<rs.length;i++){
	            if(id==""){
	                if(rs[i].name==name){
	                    aa=rs[i]
	                }
	            }else{
	                if(rs[i].id==id && rs[i].name==name){
	                    aa=rs[i]
	                }
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
	    scsz: function(min, max, from) {
				$("#range_01").ionRangeSlider({
					min: min,
					max: max,
					from: from,
				});
			},
			scoresz: function(min, max, from) {
				$("#range_02").ionRangeSlider({
					min: min,
					max: max,
					from: from,
				});
			},
	    getclass:function(){
		  var load=layer.load(2);
 			this.$http.post("/apisub.php?act=getclass").then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.class1=data.body.data;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
	    	
	    },
        tips: function (message) {
            //修改此处message为自己白泽商品id
            if (message == '4449' || message == '4448' || message == '4482'|| message == '4497') {
					this.scoresz(70, 100, 99);
					this.score_text = '设置的分数小于100分的，具有1-2分的弹性范围';
					this.scsz(1, 50, 25);
					this.shichang_text = '具有1-2小时的弹性范围，更具合理性，小节时长随机';
					$("#score").show();
					$("#shic").show();
				} else {
					$("#score").hide();
					$("#shic").hide();
				}
        	 for(var i=0;this.class1.length>i;i++){
        	 	if(this.class1[i].cid==message){
        	 	    this.show = true;
        	 	    this.content = this.class1[i].content;
	    		return false;
        	 	}
        	 }
        }
	},
	mounted(){
		this.getclass();		
	}
	
	
});
</script>
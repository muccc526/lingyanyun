<?php
$title='批量查询';
require_once('head.php');
$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
?>
<style>
    .input_div {
        display: inline-block;
        vertical-align: middle;
        border-radius: 4px;
        border: 1px solid #DCDFE6;
        -webkit-box-shadow: 0 1px 15px rgba(0, 0, 0, 0.1);
        box-shadow: 0 1px 15px rgba(0, 0, 0, 0.1);
        padding: 9px 15px;
        font-size: 12px;
        white-space: nowrap;
        background: #FFF;
        font-weight: 500;
        color: #606266 !important;
        -webkit-appearance: none;
        text-align: center;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        outline: 0;
        margin: 5px;
        position: relative;
        cursor: pointer;
        -webkit-transition: all .3s cubic-bezier(.645,.045,.355,1);
        transition: all .3s cubic-bezier(.645,.045,.355,1);
        font-size: 16px;
        border-radius: 10px;
    }
    .input_active {
        background: #409EFF;
        color: #fff !important;
    }
    .layui-textarea {
    min-height: 70px;
    height: auto;
    line-height: 20px;
    padding: 6px 10px;
    resize: vertical;
    }
</style>
<link rel="stylesheet" href="assets/LightYear/js/ion-rangeslider/ion.rangeSlider.min.css">
<script type="text/javascript" src="assets/LightYear/js/ion-rangeslider/ion.rangeSlider.min.js"></script>
<link rel="stylesheet" href="assets/css/element.css" type="text/css" />

<div class="app-content-body">
    <div class="wrapper-md control" id="add">
        <div class="layui-row layui-col-space5">
            <div class="layui-col-md60">
                <div class="panel panel-default" style="border-radius: 10px;">
                    <div class="panel-body">
                        <form class="form-horizontal devform">
                            <?php if ($conf['flkg'] == "1" && $conf['fllx'] == "1") { ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">项目分类</label>
                                <div class="col-sm-9">
                                    <select class="layui-select" v-model="id" @change="fenlei(id);" style="background: url('../index/arrow.png') no-repeat scroll 99%; border-radius: 8px; width:100%">
                                        <option value="">项目分类</option>
                                        <?php 
                                        $a = $DB->query("select * from qingka_wangke_fenlei where status=1 ORDER BY `sort` ASC");
                                        while($rs = $DB->fetch($a)) {
                                        ?>
                                        <option :value="<?=$rs['id']?>"><?=$rs['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } else if ($conf['flkg'] == "1" && $conf['fllx'] == "2") { ?>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">项目分类</label>
                                <div class="col-sm-9">
                                        <div class="example-box">
                                            <div @click="fenlei('', '')" :class="flag == '' ? 'input_div input_active' : 'input_div'"> 全站搜索 </div>
                                            <?php
                                            $i = 0;
                                            $a = $DB->query("select * from qingka_wangke_fenlei where status=1 ORDER BY `sort` ASC");
                                            while($rs = $DB->fetch($a)) {
                                                $i++;
                                            ?>
                                            <div :class="<?=$i?> == flag ? 'input_div input_active' : 'input_div'" @click="fenlei(<?=$rs['id']?>, <?=$i?>)"> <?=$rs['name']?> </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
					    <?php }?>
						<div class="form-group">
                        <label class="col-sm-2 control-label">选择平台</label>
                        <div class="col-sm-9">
                           <form class="form-horizontal" id="form-update">
                              <template>
<el-select
id="select"
v-model="cid"
@change="tips(cid)"
filterable placeholder="直接输入名称即可搜索" 
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
									<div class="col-sm-9 col-xs-12">
										<input id="range_02">
										<small class="form-text text-muted">{{score_text}}</small>
									</div>
								</div>
								<div class="form-group" id="shic" style="display: none;">
									<label class="col-sm-2 control-label">时长设置</label>
									<div class="col-sm-9 col-xs-18">
										<input id="range_01">
										<small class="form-text text-muted">{{shichang_text}}</small>
									</div>
								</div>
						<div class="form-group">
						<label class="col-sm-2 control-label">信息填写</label>
						<div class="col-sm-9">
							<!--<input  class="layui-input" v-model="userinfo" required/> -->
							<el-input v-model="userinfo" placeholder="请输入下单信息" prefix-icon="el-icon-search"></el-input>
							<span class="help-block m-b-none" style="color:red;"><span v-html="content"></span>
						    </span>
						</div>
					</div>
						</div>
	
<div class="col-sm-offset-2">
				  	    	<el-button type="success" @click="get" icon="el-icon-search" round>查询课程</el-button>
				  	    	<el-button type="primary" @click="add" icon="el-icon-circle-check" round>立即提交</el-button>&nbsp;&nbsp;&nbsp;
<button class="btn btn-label btn-round btn-warning hide-on-mobile" type="reset" value="清空数据">
    <label><i class="mdi mdi-delete-empty"></i></label> 清空数据
</button>
				  	    </div>
				  	    </div>
			        </form>
		        </div>
	     </div>
	     </div>
	     <div class="layui-col-md60" v-show="show1">
	    <div class="panel panel-default" style="border-radius: 10px;">
		     <div class="panel-heading font-bold bg-white" style="border-radius: 10px;">
			    查询结果——建议第一次查询失败后去官网验证账号密码
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
								        <button type="button" id="copyButton" class="el-button el-button--primary is-plain el-button--mini" style="padding: 4px 10px;" @click="copyQueryInfo(rs.data)">复制</button>
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
		flag:''
	},
	methods:{
	    get:function(){
	    	if(this.cid=='' || this.userinfo==''){
	    		layer.msg("信息格式错误，请检查");
	    		return false;
	    	}
		    userinfo=this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");      	           	    
	   	    userinfo=userinfo.split('[br]');//分割
	   	    this.userinfo = this.userinfo.replace(/\r?\n|\r/g, " ");
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
	    			layer.alert(data.data.msg,{icon:1,title:"Venom提示"},function(){setTimeout(function(){window.location.href=""});});
	    		}else{
	    			layer.alert(data.data.msg,{icon:2,title:"Venom提示"});
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
	    fenlei:function(id,flag){
	        this.flag = flag;
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
            if (message == '43425' || message == '43425' || message == '43425'|| message == '43425') {
					this.scoresz(70, 100, 99);
					this.score_text = '设置的分数小于100分的，具有1-2分的弹性范围';
					this.scsz(1, 50, 25);
					this.shichang_text = '具有1-2小时的弹性范围，更具合理性，小节时长随机';
					$("#score").show();
					$("#shic").show();
					        this.scoresz(70, 100, 99);
    } else if (message == '469') {
        this.scoresz(1000, 5000, 1800);
        this.score_text = '设置的积分范围1000到5000，设置过多可能无法达到要求';
        $("#score").show();
        $("#shic").hide();
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
        },
        copyQueryInfo: function(data) {
            let selectedValues = [];
            data.forEach((res, index) => {
                if (res.checked) {
                    selectedValues.push(`【${index + 1}】${res.name.replace(/[^\u4e00-\u9fa5]/g, '')}`);
                }
            });

            if (selectedValues.length === 0) {
                data.forEach((res, index) => {
                    selectedValues.push(`【${index + 1}】${res.name.replace(/[^\u4e00-\u9fa5]/g, '')}`);
                });
            }

            const textToCopy = selectedValues.join('\n');
            const finalText = `请选择代看课程【回复数字即可】\n-----你当前的课程列表-----\n${textToCopy}\n---------------------`;

            const tempTextArea = document.createElement('textarea');
            tempTextArea.value = finalText;
            document.body.appendChild(tempTextArea);
            tempTextArea.select();

            try {
                document.execCommand('copy');
                const message = selectedValues.length > 0 ? '已复制选中项！' : '已复制所有项！';
                layer.msg(message);
            } catch (err) {
                console.error('无法复制文本: ', err);
            } finally {
                document.body.removeChild(tempTextArea);
            }
        }
	},
	mounted(){
		this.getclass();		
	}
	
	
});
</script>
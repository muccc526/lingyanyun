<?php
$title='提交订单';
include('./head.php');
$addsalt=md5(mt_rand(0,999).time());
$_SESSION['addsalt']=$addsalt;
?>





<script type="text/javascript">
    //禁止鼠标右键
document.oncontextmenu = function(){
    return false;
}
document.onkeydown = function(){
    var e = window.event || arguments[0];
    if(e.keyCode == 123){    //屏蔽F12
        return false;
    }if(e.ctrlKey && e.shiftKey && e.keyCode == 73){    //屏蔽Ctrl+Shift+I，等同于F12
        return false;
    }if(e.shiftKey && e.keyCode == 121){    //屏蔽Shift+F10，等同于鼠标右键
        return false;
    }if (event.ctrlKey && window.event.keyCode == 85) {
                        return false;
    }if (event.ctrlKey && window.event.keyCode==83){
    return false;
  }
}
</script>

</head>
<!--<body style="background-image: url('assets/11.png');height:115%; background-attachment: fixed; ">-->
<body>
<style>
    .lioverhide {
        width: 300px
    }
</style>
<div class="app-content-body ">
    
<script src="vue.min.js"></script>
<script src="vue-resource.min.js"></script>
<link rel="stylesheet" href="assets/css/element.css">
<!-- 引入样式 -->
<link rel="stylesheet" href="/index.css">
<link rel="stylesheet" href="/bootstrap-icons.css">

<!-- 引入组件库 -->
<script src="/index.js"></script>
<link rel="stylesheet" href="/be-icons.css">
<link rel="stylesheet" href="/be.css">

        <div class="wrapper-md control" id="add">
        <!--    <div class="row">	-->
        <!--<div class="col-sm-8">-->
        
            <!--<div class="layui-row layui-col-space10">-->
            
            <!--<div class="layui-col-md9">-->
                
              <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 15px;">
	       <!--<div class="panel panel-default" style="border-radius: 10px;">-->
	           
	           
		      <!--div class="panel-heading font-bold bg-white ">
			    填写信息&nbsp;&nbsp;<a href="#!" class="js-create-tab btn btn-xs btn-primary" data-title="单个提交" data-url="add">返回</a>
		     </div-->
		     
<div class="layui-card-header">
<span class="badge badge-dot-xl badge-dot bg-info"></span>&nbsp;&nbsp;<b>查课提交</b>&nbsp;&nbsp;<span class="el-tag el-tag--dark el-tag--medium"><b>剩余：{{ money }}币子</b></span> <!--&nbsp;&nbsp;-->
<div style="float: right; margin-right: 0px;">
    <!--<a href=" " onclick="clearCache()"><button type="button" class="btn btn-xs btn-info" style="border-radius: 4px;"><i class="mdi mdi-spin mdi-loading"></i>&nbsp;清除缓存</button></a>-->

<!--<a href="addpil" class="btn btn-xs btn-dark" style="border-radius: 4px;">无查课下单</a>-->
<!--&nbsp;&nbsp;-->
<!--<a href="http://lg.100king.asia/" target = "_blank" class="btn btn-xs btn-primary" style="border-radius: 4px;">客户查单页</a> -->
</div>
</div>



				<div class="panel-body" >
					<form class="form-horizontal devform">
					    					    
					    <div class="form-group">
					        
					        <!--滚动公告-->
<!--    <div style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 15px;"></div>-->
<!--<marquee scrollamount="10" loop="loop" ><h3>有重复课的把要刷的置顶，独家商品查不到课的用无查课下单！-->
<!--        </h3></marquee>-->
          <!--<marquee scrollamount="0" direction="left" align="Middle" style="line-height: 30px;font-size: 13px;color:#0080ff;background:#f0f0f0;width:100%;height:100%;font-weight:bold;"><h4>建议有重复课的把要刷的置顶，独家商品查不到课的用无查课下单！</h4></marquee></br></br>-->

					        <label class="col-sm-2 control-label">商品类别：</label>

					        <div class="col-sm-9">
					       
					            <!--<div class="col-xs-15">-->
					                <div class="example-box">
		
                 <!--<el-input type="radio" class="radio-group" name="e" checked="" @change="fenlei('');">全部</el-input>-->

			 <div  class="el-radio-group" >
			 <label class="el-radio-button el-radio-button--medium is-active" >
           <input type="radio" class="el-radio-button__orig-radio" name="e"  @change="fenlei('');">
          <span class="el-radio-button__inner" style="border-radius: 6px;">【全部】商品</span>
			 </label></div>
					                    
					                    <!--<label class="lyear-radio radio-inline radio-primary">-->
					                    <!--    <input type="radio" name="e" checked="" @change="fenlei('');"><span>全部</span>-->
					                    <!--</label>-->
					                    <?php
					                    $a=$DB->query("select * from qingka_wangke_fenlei where status=1  ORDER BY `sort` ASC");
					                    while($rs=$DB->fetch($a)){
					                    ?>
					                    					                    
			<div class="el-radio-group">
		    <label class="el-radio-button el-radio-button--medium is-active" >
            <input type="radio" class="el-radio-button__orig-radio" name="e" @change="fenlei(<?=$rs['id']?>);">
            <span class="el-radio-button__inner" style="border-radius: 6px;"><?=$rs['name']?></span>
			</label>
		
			</div>
					                   
					                   
				  <?php } ?>		                    
					                    					                    
		
					                    
					                    					           
					                    
					                </div>	
					            <!--</div>-->
					         </div>
						</div>
						
					    				    
					  <!--  	<div class="form-group">-->
							<!--<label class="col-sm-2 control-label">-->
							<!--    剩余币子：-->
							<!--    </label>-->
       <!--                     <div class="col-sm-9" >{{ money }}币子-->
       <!--                         </div></div>-->

      
						<div class="form-group">
							<label class="col-sm-2 control-label">
							    学习平台：
							    </label>
						<div class="col-sm-9" >
						<form class="form-horizontal" id="form-update" >

						<!--<el-select v-model="cid" @change="tips(cid);" style=" width:100%">-->
      <!--                  <el-option value="">选择搜索平台</el-option>-->
      <!--                  <el-option id="cid2" v-for="(class2,index) in class1_temp" :label="class2.name+' ➤ '+class2.price+'币子'" :value="class2.cid" :selected="index==0"><span style="float: left">{{ class2.name }}</span>-->
						<!--<span style="float: right; font-size: 13px;">{{ class2.price }}币子</span></el-option></el-select>-->
                                            
							<!--<el-select  v-model="cid"  @change="tips(cid)" placeholder="选择商品" style=" width:100%">-->
 
							  <el-select id="select" v-model="cid"  popper-class="lioverhide" @change="tips(cid)" filterable placeholder="点击搜索商品" style="width:100%;" >
  
							    <!--<ul class="el-select-group__wrap"><li class="el-select-group__title">普通类</li>-->
							    <!--商品分类 v-if == "class2.cid < 3" ||或者 &&并且 =!不等于 ==等于 >=大于等于 <=小于等于-->

                        <el-option  v-for="class2 in class1" :label="class2.name+' ➤ '+class2.price+'币子'" :value="class2.cid"> 
                                    
                                    
                                    
                                    
                        <div style="display: flex; justify-content: space-between; align-items: center; position: relative;">
                        <!--<span style="flex: 1; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">-->
                            <span style="overflow-x: auto; white-space: nowrap;">{{ class2.name }}</span>    
									<!--<span style="float: left; font-size: 13px;">{{ class2.name }}</span>-->
									<!--商品ID{{ class2.cid }}-->
																											<span style="float: right; font-size: 13px;">{{ class2.price }}币子</span>
																		
                                         <!-- 放在right后改字体颜色color: rgb(54, 154, 255);-->
                                         
                                      <!--v-for="class2 in class1"-->
                                      <!--:key="class2.cid"-->
                                      <!--:label="class2.name+'('+class2.price+'课时币)'"-->
                                      <!--:value="class2.cid">-->
                                      </div>
                                    </el-option>
                                  </el-select>
                                  </p>
                                                                                                       <a href="dingdan">
                                  <span class="el-tag el-tag--warning el-tag--dark el-tag--medium" style="border-radius: 4px;">商品质量查询</span></a>
                                  <button type="button" data-toggle="modal" data-target="#myModal2" class="el-tag el-tag--info el-tag--dark el-tag--medium" style="border-radius: 4px;">商品推荐+疑问解答</button>
                                  </p>
                                  <font color=red>重名课把要刷的置顶，独家商品查不出课的 <a href="addtj" ><span  class="el-tag el-tag--dark el-tag--medium">点我下单</span></a></font>
							</div>
						</div>
						
						
						<div class="form-group" 
						v-if=" cid == 3333333
						      ">
<!--单选版本-->		
                 
<!--选择框版本-->	
        <label class="col-sm-2 control-label">跑单地域：</label>
<div class="col-sm-9">
    <el-select style="width:100%;" v-model="selectedRegion" placeholder="请选择" :value="selectedRegion || '随机'">
        <el-option label="随机" value="随机"></el-option>
        <el-option label="南京" value="南京"></el-option>
        <el-option label="青岛" value="青岛"></el-option>
        <el-option label="拉萨" value="拉萨"></el-option>
        <el-option label="成都" value="成都"></el-option>
        <el-option label="重庆" value="重庆"></el-option>
        <el-option label="河北" value="河北"></el-option>
        <el-option label="佛山" value="佛山"></el-option>
        <el-option label="新疆" value="新疆"></el-option>
        <el-option label="芜湖" value="芜湖"></el-option>
        <el-option label="长沙" value="长沙"></el-option>
        <el-option label="长春" value="长春"></el-option>
        <el-option label="甘肃" value="甘肃"></el-option>
        <el-option label="山西" value="山西"></el-option>
        <el-option label="江西" value="江西"></el-option>
        <el-option label="黑龙江" value="黑龙江"></el-option>
    </el-select>
</div>
</div>
    

							
							<!--这里是让商品注释在学习平台下显示-->
							<div class="form-group">
							<label class="col-sm-2 control-label" v-if="content">商品介绍：</label>
							<div class="col-sm-9">
							    
<!--按钮版本看介绍-->							    
<!--<button type="button" data-toggle="modal" data-target="#myModal2024" class="el-tag el-tag--dark el-tag--medium">查看(不看是傻逼)
</button>-->

<!--el ui版本看介绍，不支持hr换行-->
	<!--<el-alert-->
 <!--   type="success"-->
 <!--   v-html="content"-->
 <!--   role="alert"-->
 <!--   >-->
 <!-- </el-alert>-->
					
<!--蓝色字体版本看介绍-->
<!--<span class="help-block m-b-none" style="color: rgb(54, 154, 255);"><b><span v-html="content"></b></span></span>-->
<!--恢复上边的也需要把下边的 div 和form恢复了-->

<!--光年v3版本看介绍-->
<!--<div class="alert alert-warning" role="alert" style="border-radius: 4px;" v-html="content"></div>-->
<!--用此版本不需要注释下方div和form-->
		
<!--光年v3版本看介绍-->
<div class="alert alert-warning" role="alert" style="border-radius: 4px;" v-if="content" v-html="content"></div>
<!--用此版本不需要注释下方div和form-->
							</div>

						</div>
						<div class="form-group">
						    
    <label class="col-sm-2 control-label" v-if="dockInfo">对接信息：</label>
    <div class="col-sm-9">

            <span class="help-block m-b-none" style="color: rgb(54, 154, 255);">
                 <b><span v-html="dockInfo"></span> </b>
            </span>
       
    </div>
</div>
						
						
						<div v-show="row">
						    <!--row改show就是隐藏信息栏-->
						<!--div class="form-group" v-if="activems==true">
							<label class="col-sm-2 control-label" for="checkbox1">是否秒刷</label>
							<div class="col-sm-9">
								<div class="checkbox checkbox-success"  @change="tips2">
        				            <input type="checkbox" v-model="miaoshua">
        				            	<label for="checkbox1" id="miaoshua"></label>
							    </div>
							</div>							
						</div-->
						
	<div class="form-group" id="score" style="display: none;">
    <label class="col-sm-2 control-label">分数设置：</label>
    <div class="col-sm-9">
        <input id="range_14">
        <small class="form-text text-muted">{{score_text}}</small>
    </div>
</div>


<div class="form-group" id="shic" style="display: none;">
    <label class="col-sm-2 control-label">时长设置：</label>
    <div class="col-sm-9">
        <input id="range_15">
        <small class="form-text text-muted">{{shichang_text}}</small>
    </div>
</div>


						<div class="form-group" >
							<label class="col-sm-2 control-label">登录信息：</label>
							<div class="col-sm-9">
							 <!--textarea 改成 input 就是单账号查课-->
	<el-input rows="5" type="textarea" v-model="userinfo"  placeholder="下单格式：学校（可为空） 账号 密码（用空格分隔）&#10多账号下单必须换行">
						    </el-input>
						    
						<!--    <font color=black>商品注释：</font>-->
						<!--  <span class="help-block m-b-none" id="warning">-->
						<!--        <span style="color:red;"  v-html="content"></span>-->
						<!--    </span>				-->
						<!--	</div>-->
						</div>
							</div>
							
								<!--这里是让商品注释在信息填写下显示-->
						<!--<div class="form-group">-->
						<!--	<label class="col-sm-2 control-label">商品介绍：</label>-->
						<!--	<div class="col-sm-9">-->
						<!--     <b>-->
						<!--    <span class="help-block m-b-none" style="color: rgb(54, 154, 255);"><span v-html="content"></span>-->
						<!--    </span>-->
						<!--    </b>-->
						<!--	</div>-->
						<!--</div>-->
						
				  	    <!--<div class="col-sm-offset-2 col-sm-12">-->
				  	        
<div class="col-sm-offset-5 col-sm-5">

</p>
<center>
    
<div style="display: flex; justify-content: center;">&nbsp;
<el-button style="margin-left: 6px; font-size: 13px; border-radius: 6px; width: 33%; display: flex; justify-content: center; align-items: center;" type="" plain @click="get" size="">查询课程</el-button>&nbsp;&nbsp;&nbsp;&nbsp;
	<!--<i class="bi bi-search"></i>&nbsp;-->

<el-button style="margin-left: 6px; font-size: 13px; border-radius: 6px; width: 33%; display: flex; justify-content: center; align-items: center;" type="primary" @click="add" value="立即提交" size="">开始看课</el-button>&nbsp;&nbsp;&nbsp;&nbsp;
<!--<i class="bi bi-send-fill"></i>&nbsp;-->

<button type="reset" style="margin-left: 6px; font-size: 13px; border-radius: 6px; width: 33%; display: flex; justify-content: center; align-items: center;" class="el-button el-button--info">重新输入</button>&nbsp;&nbsp;&nbsp;
    <!--<i class="bi bi-x-circle" style="margin-right: 4px; "></i>&nbsp;-->

	   
    </div>
</center>
</p>
<!--<br>-->
</div>
</div>
</form>
</div>
</div>
	     <!--以下div是上边space10打开后打开-->
	     <!--</div>-->
	     
	      <!--class="layui-col-md6" 放在下边就是显示一半-->
	     <div  v-show="show1" >
	         <!--<div class="layui-row layui-col-space10">-->
	    <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 15px;">
		     <div class="layui-card-header">
		          
		         <span class="badge badge-dot-xl badge-dot bg-success"></span><div style="display: inline-flex; align-items: center;">&nbsp;&nbsp;<b>查询结果</b>&nbsp;
<!--<el-button style="margin-left: 6px; font-size: 13px;" type="button" @click="selectAll()" class="el-button--success el-button--mini"/>全选课程</el-button>-->
	<!--<a class="el-button el-button--success is-plain el-button--mini" style="padding: 4px 10px;" id="checkboxAll" @click="selectAll()">全选课程</a>-->
	
	<!-- 使用开关控制课程ID显示 -->
        
            <label class="lyear-switch switch-solid switch-success" style="margin-right: 5px;">
                <input type="checkbox" v-model="kcidAllValue" true-value="1" false-value="0">
                课程ID: 关&nbsp;<span></span>&nbsp;开
            </label>
            
<!--<b>课程ID&nbsp;<el-switch-->
<!--  v-model="kcidAllValue"-->
<!--  active-text="开"-->
<!--  inactive-text="关">-->
<!--</el-switch></b>&nbsp;-->

            
            <!--<span>显示课程ID</span>&nbsp;-->
        <!-- 添加提示显示已选择的课程数量 -->
        <span style="color: #007bff; font-weight: bold; ">选中{{check_row.length}}门课</span>&nbsp;
	<!--<button type="button" @click="copyQueryInfo" class="el-button el-button--success el-button--mini">复制课程</button>-->
			    </div> </div>
			    
				<div class="panel-body">
					<form class="form-horizontal devform">		
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							  <div v-for="(rs,key) in row">
								  <div class="panel panel-default">
								    <div class="panel-heading" role="tab" id="headingOne">
								      <h4 class="panel-title" style="overflow-x: auto; white-space: nowrap;">
								          
								          <div style="display: flex;">	
					<button type="button" @click="copyQueryInfo" class="el-tag el-tag--success el-tag--dark"><b>复制课程</b></button>&nbsp;
								    <a role="button" data-toggle="collapse" data-parent="#accordion" :href="'#'+key" aria-expanded="true" >
								         <!--<b>{{rs.userName}}</b> {{rs.userinfo}}-->
								         <span class="el-tag el-tag--dark"><b>{{rs.userinfo}}</b></span>
								        <span v-if="rs.msg.includes('查询成功') || rs.msg.includes('查课成功') || rs.msg.includes('Success！') || rs.msg.includes('Success') || rs.msg.includes('success')"><span class="el-tag el-tag--success el-tag--dark"><b>{{rs.msg}}</b></span></span>
								         <span v-else-if="rs.msg!='查询成功'">
								         <span class="el-tag el-tag--danger el-tag--dark"><b>{{rs.msg}}</b></span></div>
								        </a>
								      </h4>
								    </div>
								    
<div :id="key" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
    <div class="panel-body" style="overflow-x: auto; white-space: nowrap;">
        <div v-for="(res, key) in rs.data" class="">
            <li>
                <el-checkbox 
                    :label="res.name"
                    @change="checkResources(rs.userinfo, rs.userName, rs.data, res.id, res.name)">
                    <span>{{ res.name }}
                        <span v-if="res.state === '已结课或者未开始'"><font color=red>【未开课/结课】</font></span>
                        <span v-if="res.state === '已结束或者未开始'"><font color=red>【未开课/结课】</font></span>
                        <span v-else-if="res.state === '未结束'">【开课】</span>
                        <b v-else-if="res.state !== ''"></b>
                         <!--{{ res.state }}-->
                        <span v-else>【开课】</span>
                    </span>
                    <span style="color:red;" v-if="vm.kcidAllValue==1">&nbsp;<b>课程ID：{{ res.id }}</b></span>
                </el-checkbox>
            </li>

								     <!--原版单选框-->
								    <!--<div :id="key" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">-->
								    <!--  <div class="panel-body">-->
								    <!--  	  <div v-for="(res,key) in rs.data" class="checkbox checkbox-success">-->
								      	      
								    <!--  	  	   <li><input type="checkbox" :value="res.name" @click="checkResources(rs.userinfo,rs.userName,rs.data,res.id,res.name)"><label for="checkbox1"></label>-->
								      	  	   
								    <!--  	  	    <span>{{ res.name }}<span v-if="res.state === '已结课或者未开始'">【结课】</span>-->
								    <!--  	  	    <span v-if="res.state === '已结束或者未开始'">【未开课/结课】</span>-->
								    <!--  	  	    <span v-else-if="res.state === '未结束'">【开课】</span>-->
            <!--                                    <b v-else-if="res.state !== ''"> {{ res.state }}</b><span v-else>【开课】</span>-->
            <!--        </span><!--<span>{{res.name}}</span>-->
            <!--        <span v-if="res.id!=''"><font color=red><b>课程ID：{{res.id}}</b></font>-->
								    <!--  	  	       </span>-->
								    <!--  	  	   </li>-->
								      	  	   
								      	  	   <!--全选版本-->
								      	  	    <!--<li><input :checked="checked" name="checkbox" type="checkbox" :value="res.name" @click="checkResources(rs.userinfo,rs.userName,rs.data,res.id,res.name)"><label for="checkbox1"></label><span>{{res.name}}{{res.state?"-"+res.state:"" }}{{res.progress?"-"+res.progress: "" }}</span><span v-if="res.id!=''"></span></li>-->
								      	  	   
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
	     

                 
	                 <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 15px;">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">小沐最爱你啦~</h4>
                      </div>
                      <div class="modal-body" >
                          
<!--<blockquote>                        -->
<!--<font color=black>直充500永久开启全站成本价！<br>联系VX客服：China7xgz<br>此按钮仅你可见，你代理看不到哒！</font>-->
<!--</blockquote>          
-->
<!--<blockquote class="layui-elem-quote">                        -->
<!--学习通专业课：独家/隐藏/呱呱。-->
<!--</blockquote>-->
<!--<blockquote class="layui-elem-quote">                        -->
<!--学习通考试：满分/满分2/独家/隐藏/呱呱。-->
<!--</blockquote>-->
<!--<blockquote class="layui-elem-quote">                        -->
<!--智慧树：独家/隐藏/满分。-->
<!--</blockquote>-->
<!--<blockquote class="layui-elem-quote">                        -->
<!--智慧职教：自由/独享/学委。-->
<!--</blockquote>-->
<!--<blockquote class="layui-elem-quote">                        -->
<!--U校园：所有渠道都没有问题。-->
<!--</blockquote>-->
<!--<blockquote class="layui-elem-quote">                        -->
<!--中国大学MOOC：独享/K自营/福利。-->
<!--</blockquote>-->
<!--<blockquote class="layui-elem-quote">                        -->
<!--<font color=red>需要的商品没有？向上反馈立马上架！</font>-->
<!--</blockquote>-->

<!--<el-collapse v-model="activeName" accordion>-->
<!--  <el-collapse-item title="一致性 Consistency" name="1">-->
<!--    <div>与现实生活一致：与现实生活的流程、逻辑保持一致，遵循用户习惯的语言和概念；</div>-->
<!--    <div>在界面中一致：所有的元素和结构需保持一致，比如：设计样式、图标和文本、元素的位置等。</div>-->
<!--  </el-collapse-item>-->
<!--  <el-collapse-item title="反馈 Feedback" name="2">-->
<!--    <div>控制反馈：通过界面样式和交互动效让用户可以清晰的感知自己的操作；</div>-->
<!--    <div>页面反馈：操作后，通过页面元素的变化清晰地展现当前状态。</div>-->
<!--  </el-collapse-item>-->
<!--  <el-collapse-item title="效率 Efficiency" name="3">-->
<!--    <div>简化流程：设计简洁直观的操作流程；</div>-->
<!--    <div>清晰明确：语言表达清晰且表意明确，让用户快速理解进而作出决策；</div>-->
<!--    <div>帮助用户识别：界面简单直白，让用户快速识别而非回忆，减少用户记忆负担。</div>-->
<!--  </el-collapse-item>-->
<!--  <el-collapse-item title="可控 Controllability" name="4">-->
<!--    <div>用户决策：根据场景可给予用户操作建议或安全提示，但不能代替用户进行决策；</div>-->
<!--    <div>结果可控：用户可以自由的进行操作，包括撤销、回退和终止当前操作等。</div>-->
<!--  </el-collapse-item>-->
<!--</el-collapse>-->


 <!--充值介绍-->
<div class="panel panel-dark">
              <div class="panel-heading" role="tab" id="headingOne" >
                <h4 class="panel-title" >
                                       </h4>
              </div>
              <!--<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">-->
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="" >
                <div class="panel-body" >
                     <b>
                                            </b>
                </div>
              </div>
            </div>

            <div class="panel panel-danger">
              <div class="panel-heading" role="tab" id="headingTwo">
                <h4 class="panel-title">
                                     </h4>
              </div>
              <!--点击开合-->
              <!--<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">-->
              
                   <!--一直开-->
<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true" style="">
        
                <div class="panel-body">
                     <b>
                   </b>
                </div>
              </div>
            </div>

                      <div class="modal-footer">
<button style="margin-left: 6px; font-size: 13px;" type="button" data-dismiss="modal" class="el-button el-button--primary"/>知道啦~</button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                
                
                 <!--开通过密价-->
                 <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 15px;">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">小沐最爱你啦~</h4>
                      </div>
                      <div class="modal-body">

<blockquote>                        
<font color=black>直充100开全站密价(不是最低包退款)。<br><font color=red>联系微信：China7xgz，转账开通！</font><br>此按钮和信息仅你可见，你代理看不到哒！</font>
</blockquote>
           <div class="modal-footer">
 <button style="margin-left: 6px; font-size: 13px;" type="button" data-dismiss="modal" class="el-button el-button--primary"/>知道啦~</button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                
                <!--商品介绍-->
                <div class="modal fade" id="myModal2024" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 15px;">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">小沐最爱你啦~</h4>
                      </div>
                      <div class="modal-body">
<blockquote>                        
<b><span v-html="content"></b></span>
</blockquote>
           <div class="modal-footer">
<button style="margin-left: 6px; font-size: 13px;" type="button" data-dismiss="modal" class="el-button el-button--primary"/>知道啦~</button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                
                 <!--疑问解答-->
                <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 15px;">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">小沐最爱你啦~</h4>
                      </div>
                      <div class="modal-body">
                          
<div class="tab-content" style="overflow: auto;height: 50vh;">
<!--<blockquote>-->
<el-collapse v-model="activeName" accordion>
<el-collapse-item title="有问题按格式用问题反馈上报。" name="5">
<div>格式：技术全名+商品全名 账号 密码 课名 问题详情。</div>
<div>先自己上号排查，没上号排查不答复。</div>
</el-collapse-item>
<el-collapse-item title="学习通不知道下啥？" name="19">
<div>选修课全包：爱坤。</div>
<div>专业课全包：隐藏、名著、独家、爱坤超能版。</div>
<div>专业课考试：隐藏、名著、独家、呱呱、龙龙、爱坤超能版。</div>
<div>收件箱/在线考试：隐藏、名著、独家、呱呱、龙龙、爱坤超能版。</div>
<div>作业：隐藏、独家、爱坤超能版。</div>
<div>以上技术支持闯关课、人脸课、解锁课，直播分、阅读分，</div>
<div>学习次数分只有爱坤、独家、隐藏、呱呱包，其余请下补次数,</div>
<div>仅APP+人脸考试已知：隐藏、呱呱、名著、龙龙、爱坤支持，其余自测。</div>
<div>秒刷反响不错的：呱呱、名著。</div>
</el-collapse-item>
<el-collapse-item title="国开不知道下啥？" name="30">
<div>无脑干程序就完事了！</div>
</el-collapse-item>
<el-collapse-item title="U校园AI版进度问题？" name="22">
<div>由于官方原因，时长和分数会延时到账，<br>
具体表现：平台显示0分0时长，上号学习记录页面也无分数时长，但任务点变绿，无需补刷，等待即可。</div>
</el-collapse-item>
<el-collapse-item title="U校园AI版班测分问题？" name="23">
<div>无脑下程序就完事了，官方答案100%满分，看不到分是老师没批阅。</div>
</el-collapse-item>
<el-collapse-item title="智慧职教搞不懂？" name="2">
<div>课在哪个地址里下对应商品，首选程序。</div>
<div>MOOC官网：https://mooc.icve.com.cn/</div>
<div>职教云/SPOC官网：https://zjy2.icve.com.cn/</div>
<div>资源库官网：https://zyk.icve.com.cn/</div>
</el-collapse-item>
<el-collapse-item title="继续教育学习通查不到课？" name="3">
<div>登录地址是jxjy.chaoxing这种的无法处理。</div>
</el-collapse-item>
<el-collapse-item title="学习通考试疑问？" name="6">
<div>课程里的考试下做考试，列表、收件箱和课程里有多个考试下对应商品。</div>
</el-collapse-item>
<el-collapse-item title="学习通特殊课程？" name="7">
<div>所有技术都可以处理人脸，闯关，逐一解锁课，其中闯关和逐一解锁的课部分老师会设置测验须及格或满分才能进行下一个任务，如有卡住自行上号给卡住的题过了在重刷就行了。</div>
</el-collapse-item>
<el-collapse-item title="学习通特殊课程秒刷不走进度？" name="8">
<div>闯关、逐一解锁课禁止下单秒刷，人脸课可以秒刷。</div>
</el-collapse-item>
<el-collapse-item title="学习通/智慧树是否自动考试？" name="9">
<div>只要你下单的时候号里有考试并且有显示开考时间到时间了系统自动考，急单或者时间变更或者试卷后期发的请自行重刷。</div>
</el-collapse-item>
<el-collapse-item title="智慧树翻转课和兴趣课？" name="10">
<div>翻转课只处理学习资源做不了题，兴趣课处理不了不要下单。</div>
</el-collapse-item>
<el-collapse-item title="智慧树智慧共享课和AI课？" name="31">
<div>爱坤、陈泽、独家支持智慧共享课，陈泽、泰达支持AI课。</div>
</el-collapse-item>
<el-collapse-item title="智慧树见面课和互动分？" name="11">
<div>结课前系统会统一秒完，漏秒的重刷就秒了，所有技术基本都是可以把分拿满，极个别情况下会差个几分。</div>
</el-collapse-item>
<el-collapse-item title="提速刷课异常？" name="12">
<div>不管是学习通还是智慧树只要加速刷课就会概率清进度，重刷到不清即可。</div>
</el-collapse-item>
<el-collapse-item title="国开进度条不满？" name="15">
<div>国开只处理包分项目不用看进度条，期末时期只处理题。</div>
</el-collapse-item>
<el-collapse-item title="U校园进度不满？" name="13">
<div>限制只取第一次作答记录或过期/未激活/未开放，如果不是以上问题重刷即可。</div>
</el-collapse-item>
<el-collapse-item title="雨课堂不走进度？" name="14">
<div>自行上号查看有课件么，直播/签到不包。</div>
</el-collapse-item>
<el-collapse-item title="智慧职教低分/没做？" name="16">
<div>低分的情况重刷即可满分，如果有部分试卷没做，自行上号打开任意试卷做几道题退出试卷后重刷即可。</div>
</el-collapse-item>
<el-collapse-item title="Welearn进度/时长不满？" name="17">
<div>上号自行排查，基本上就是单元未开放或者单元过期导致或课程未开放/过期的。</div>
 </el-collapse-item>
 
<!--</el-collapse>-->
    
                            
<!--<font color=black>-->
<!--<div class="tab-content" style="overflow: auto;height: 80vh;">-->
     
<!--<b style="color: rgb(227, 55, 55);">所有一切自己上号了还解决不了的问题用问题反馈页面上报。</b><br> -->
<!--格式：技术全名+商品全名 账号 密码 课名 问题详情，前提先自己上号排查，没上号排查不答复。<br><br>     -->

<!--<b style="color: rgb(227, 55, 55);">智慧职教搞不懂？</b><br> -->
<!--课在哪个地址里下对应商品。<br>-->
<!--MOOC官网：https://mooc.icve.com.cn/<br> -->
<!--职教云/SPOC官网：https://zjy2.icve.com.cn/<br> -->
<!--资源库官网：https://zyk.icve.com.cn/<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">继续教育学习通查不到课？</b><br> -->
<!--登录地址是jxjy.chaoxing这种的无法处理。<br><br> -->
                                
<!--<b style="color: rgb(227, 55, 55);">学习通考试</b><br> -->
<!--课程里的考试下做考试，列表、收件箱和课程里有多个考试下对应商品。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">学习通特殊课程</b><br>-->
<!--所有技术都可以处理人脸，闯关，逐一解锁课，其中闯关和逐一解锁的课部分老师会设置测验须及格或满分才能进行下一个任务，如有卡住自行上号给卡住的题过了在重刷就行了。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">学习通特殊课程秒刷不走进度</b><br>-->
<!--闯关、逐一解锁课禁止下单秒刷，人脸课可以秒刷。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">自动考试</b><br>-->
<!--只要你下单的时候号里有考试并且有显示开考时间到时间了系统自动考，急单或者时间变更或者试卷后期发的请自行重刷。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">智慧树翻转课和兴趣课</b><br>-->
<!--翻转课只处理学习资源做不了题，兴趣课处理不了不要下单。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">智慧树见面课</b><br>-->
<!--结课前系统会统一秒完，漏秒的重刷就秒了。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">智慧树互动分</b><br>-->
<!--所有技术基本都是可以把分拿满，极个别情况下会差个几分。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">提速刷课</b><br>-->
<!--不管是学习通还是智慧树只要加速刷课就会概率清进度，重刷到不清即可。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">U校园进度不满</b><br>-->
<!--限制只取第一次作答记录或过期/未激活/未开放，如果不是以上问题重刷即可。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">雨课堂不走进度</b><br>-->
<!--自行上号查看有可处理课件么，直播/签到不包。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">国开进度条满</b><br>-->
<!--国开只处理包分项目不用看进度条，期末时期只处理题。<br><br>-->

<!--<b style="color: rgb(227, 55, 55);">智慧职教低分/没做</b><br>-->
<!--低分的情况重刷即可满分，如果有部分试卷没做，自行上号打开任意试卷做几道题退出试卷后重刷即可。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">welearn进度不满</b><br>-->
<!--上号自行排查，基本上都是单元未开放或者单元过期导致的。<br><br> -->

<!--<b style="color: rgb(227, 55, 55);">词达人进度状态不变</b><br>-->
<!--不用看进度和状态，一个token建议刷3-5个任务，token获取后客户立马退出所有程序十分钟后上号查看即可。<br><br> -->

<!--                      </span></div>-->
<!--</blockquote>-->
</div>
           <div class="modal-footer">
<button style="margin-left: 6px; font-size: 13px;" type="button" data-dismiss="modal" class="el-button el-button--primary"/>知道啦~</button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                
                 <!--密价公告-->
                <div class="modal fade" id="myModal2000" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content" style="border-radius: 15px;">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">小沐最爱你啦~</h4>
                      </div>
                      <div class="modal-body">
<div class="tab-content" style="overflow: auto;height: 50vh;">
<el-collapse v-model="activeName" accordion>
    
<el-collapse-item title="2024/10/24 [信息]" name="2">
<div>价格下调:</div>
<div>【程序】智慧职教。</div>
<div>【隐藏】学习通全包。</div>
</el-collapse-item>

<el-collapse-item title="2024/10/28 [信息]" name="3">
<div>价格调整:</div>
<div>【小沐】新国家开放大学。</div>
</el-collapse-item>

<el-collapse-item title="2024/10/30 [信息]" name="4">
<div>价格下调:</div>
<div>
【龙龙】问思学习平台(考试)<br>
【龙龙】慕享<br>
【龙龙】亿学宝云<br>
【龙龙】思纽平台<br>
【龙龙】河北成人高等教育在线<br>
【小沐】U校园整本
【花卷】河南实验实训室安全技能考试平台
</div><br>
<div>商品上新：</div>
<div>【小沐】U校园AI版整本。</div>
</el-collapse-item>

<el-collapse-item title="2024/10/31 [信息]" name="5">
<div>价格上调：</div>   
<div>【名著】学习通。</div>
<div>【学委】学习通、智慧树。</div>
<div>【叮咚】学习通。</div>
<div>【泰达】智慧树。</div>
<div>【花卷】中国大学MOOC、河北省继续医学教育、四川开放大学成人教学一体化平台。</div>
<br>
<div>价格下调：</div>
<div>【盗贼】全部商品。</div>
<div>【程序】智慧职教。</div>
<div>【石油】全部商品。</div>
<div>【拾陆】全部商品。</div>
<div>【少年】全部商品。</div>
<div>【黑丝】全部商品。</div>
<div>【大猫】全部商品。</div>
<div>【东哥】全部商品。</div>
<div>【尼哥】全部商品。</div>
<div>【大炮】全部商品。</div>
<div>【回归】全部商品。</div>
<div>【陈泽】冷门商品。</div>
<div>【花卷】智慧职教MOOC做课件、河南实验实训室安全技能考试平台。</div>
<div>【白泽】全部商品。</div>
</el-collapse-item>

<el-collapse-item title="2024/11/01 [信息]" name="6">
<div>价格上调:</div>
<div>【新狗】智慧职教MOOC。</div>
<div>【大炮】新版国家开放大学。</div>
</el-collapse-item>

<el-collapse-item title="2024/11/03 [信息]" name="7">
<div>价格调整:</div>
<div>【网红】全部商品。</div>
</el-collapse-item>

<el-collapse-item title="2024/11/04 [信息]" name="8">
<div>价格调整:</div>
<div>【花卷】智慧职教MOOC。</div>
</el-collapse-item>

<el-collapse-item title="2024/11/05 [信息]" name="9">
<div>价格调整:</div>
<div>【花卷】全部商品。</div>
<div>【小沐】国开5天500次全包。</div>
<div>【森林】全部商品。</div>
</el-collapse-item>

<el-collapse-item title="2024/11/06 [信息]" name="10">
<div>价格调整:</div>
<div>【名著】全天全包/秒刷做章节。</div>
<div>【顶美】全部商品。</div>
</el-collapse-item>
 
</div>
           <div class="modal-footer">
                    <button style="margin-left: 6px; font-size: 13px;" type="button" data-dismiss="modal" class="el-button el-button--primary"/>知道啦~</button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>
                
                

                <!--下方公告-->
<!--	                 	      <div class="layui-col-md3">-->
<!--	         <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 15px;" >-->
<!--	             <div class="panel-heading font-bold bg-white"   style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 15px;">-->
	                  <!--下方公告-->
	                  
	             <!--<div class="panel-heading font-bold bg-white"  style="border-radius: 10px;" >-->
	             
	              <!--下方公告-->
<!--	                 <h4><i class="bi-volume-up-fill"></i>&nbsp; 独家查不到课商品用无查课提交。&nbsp;</h4>-->
<!--	                 <div style="float: right; margin-right: 0px;">-->
	                   <!--下方公告-->   
	                   
	       <!--<button type="button" class="btn btn-xs btn-dark" style="border-radius: 4px;" data-toggle="modal" data-target="#myModal">商品推荐-->
        <!--        </button>-->
        
<!--                </div>-->
<!--                 </div>-->

 <!--下方公告-->	                 
<!--<div class="panel-body"><ul class="layui-timeline">-->
     <!--下方公告-->
     
<!--<li class="layui-timeline-item"><i class="layui-icon layui-timeline-axis"></i><div class="layui-timeline-content layui-text"><p>-->
<!--提交前请<font color=red>仔细阅读商品介绍</font>再提交！-->
<!--</p></div></li>-->
<!--<li class="layui-timeline-item"><i class="layui-icon layui-timeline-axis"></i><div class="layui-timeline-content layui-text"><p>-->
<!--有重复课把重复的课移到文件夹内！-->
<!--</p></div></li>-->
<!--<li class="layui-timeline-item"><i class="layui-icon layui-timeline-axis"></i><div class="layui-timeline-content layui-text"><p>-->
<!--<font color=red>独家商品为人工录单，进度上号看！</font>-->
<!--</p></div></li>-->
<!--<li class="layui-timeline-item"><i class="layui-icon layui-timeline-axis"></i><div class="layui-timeline-content layui-text"><p>-->
<!--<font color=red>渠道商品为人工录单，进度上号看！</font>-->
<!--</p></div></li>-->

 <!--下方公告-->
<!--<div class="block">-->
     <!--下方公告-->
     
  <!--<el-timeline>-->
    <!--<el-timeline-item timestamp="" placement="top">-->
    
     <!--下方公告-->
<!--      <el-card style="border-radius: 10px;">-->
<!--        <h4>提交前请仔细阅读介绍再提交！</h4>-->
        <!--<p>提交前请仔细阅读商品介绍再提交！</p>-->
<!--      </el-card></p>-->
       <!--下方公告-->
      
    <!--</el-timeline-item>-->
    <!--<el-timeline-item timestamp="" placement="top">-->
    
     <!--下方公告-->
<!--      <el-card style="border-radius: 10px;">-->
<!--        <h4>有重复课把重复课移文件夹内！</h4>-->
        <!--<p>有重复课把重复的课移到文件夹内！</p>-->
<!--      </el-card></p>-->
       <!--下方公告-->
       
    <!--</el-timeline-item>-->
    <!--<el-timeline-item timestamp="" placement="top">-->
    
     <!--下方公告-->
<!--      <el-card style="border-radius: 10px;">-->
<!--        <h4>独家为人工提单，进度上号看！</h4>-->
        <!--<p>独家商品为人工录单，进度上号看！</p>-->
<!--      </el-card>-->
<!--</div>-->
 <!--下方公告-->
 
</ul>



<!--弹窗-->
 
 <script>
layer.close({
          type: 1, 
          title:'通知公告',
          content: '<div style="padding: 20px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300px;"><h4><font color=#ffffff><center>懒人和简易商品自动退款，<br>源头退款会在五分钟后退给你，<br>不要删除订单，删除不予退款！</div>' ,//这里content是一个普通的String
          time: 15000, 
          btn:'好的',
          btnAlign: 'c', //按钮居中
          shade: 0, //不显示遮罩
          area: ['300px']
          });
</script>




<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="js/ai.js"></script>
<script type="text/javascript" src="../index/assets/js/vue.min.js"></script>
<script type="text/javascript" src="../index/assets/js/vue-resource.min.js"></script>
<script type="text/javascript" src="assets/cdn/axios.min.js"></script>

<script src="./assets/js/element.js"></script>

<!--<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>-->
<!--<script src="perfect-scrollbar.min.js"></script>-->


<script>
var vm=new Vue({
	el:"#add",
	data:{	
	    row:[],
	    check_row:[],
		userinfo:'',
		cid:'',
		id:'',
		activeName: '1',
		miaoshua:'',
		class1:'',
		class1_temp: '',
        searchKeyword: '',
		class3:'',
		show: false,
		show1: false,
		content:'',
		content2:'',
		activems:false,
		score_text: '',
		shichang_text: '',
		checked:false,
		kcidAllValue: 0,
		dockInfo: '',
		money: 0, // 初始化余额为0
		selectedRegion:'随机',
	},
	watch: {
            sex(newVal) {
                // console.log(newVal)
            },
            searchKeyword(newVal) {
                if (newVal.length > 0) {
                    this.class1_temp = this.class1.filter(e => {
                        return e.name.indexOf(newVal) >= 0;
                    })
                } else {
                    this.class1_temp = JSON.parse(JSON.stringify(this.class1));
                }
                this.cid = this.class1_temp[0].cid;
            }
        },
     watch: {
    cid:function(newVal, oldVal) {//监听，同时执行tips和tips0
        this.tips(newVal);
        this.tips0(newVal);
    }
},
	methods:{
	      onFocus() {
        // 这里可以添加一些逻辑，确保输入法弹出
        // 例如，手动触发输入框的聚焦
        this.$nextTick(() => {
            const input = document.querySelector('#select .el-input__inner');
            if (input) {
                input.focus();
            }
        });
    },
	    get:function(){
	    	if(this.cid=='' || this.userinfo==''){
	    		layer.msg("你啥也没输入查尼玛！");
	    		return false;
	    	}
		    userinfo=this.userinfo.replace(/\r\n/g, "[br]").replace(/\n/g, "[br]").replace(/\r/g, "[br]");      	           	    
	   	    userinfo=userinfo.split('[br]');//分割
	   	    this.row=[];
	   	    this.check_row=[];    	
	   	    for(var i=0;i<userinfo.length;i++){	
	   	    	info=userinfo[i]
	   	    	var hash=getENC('<?php echo $addsalt; ?>');
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
	    		layer.msg("还没查课呢看尼玛！");
	    		return false;
	    	} 	
	    	if(this.check_row.length<1){
	    		layer.msg("您还未选择课程哦，如果选择了还提示请删除缓存或换个浏览器~");
	    		return false;
	    	}
	    	console.log(this.check_row);
	        var loading=layer.load(2);
	        score = $("#range_14").val();
            shichang = $("#range_15").val();
	    	this.$http.post("/apisub.php?act=add",{
	    	    cid:this.cid,
	    	    data:this.check_row,
	    	    shichang: shichang,
                score: score,
                region: this.selectedRegion
	    	},{emulateJSON:true}).then(function(data){
	    		layer.close(loading);
	    		if(data.data.code==1){
	    			this.row=[];
	    			this.check_row=[]; 
	    			 this.$message({
          message: '感谢老板支持，已为您加急看课！',
          type: 'success'
        });
	    			// layer.alert(data.data.msg,{icon:1,title:"温馨提示"},function(){setTimeout(function(){window.location.href=""});});
	    			// layer.alert(data.data.msg,{icon:1,title:"温馨提示"});
	    		}else{
	    			layer.alert(data.data.msg,{icon:2,title:"温馨提示"});
	    		}
	    	});
	    },
	    
	   // selectAll:function () {            
    //         if(this.cid==''){
	   // 		layer.msg("请先查课");
	   // 		return false;
	   // 	} 	
	   // 	this.checked=!this.checked;  
	   // 	if(this.check_row.length<1){
		  //  	for(i=0;i<vm.row.length;i++){
		  //  		console.log(i);
		  //  		userinfo=vm.row[i].userinfo
		  //  		userName=vm.row[i].userName
		  //  		rs=vm.row[i].data
		  //          for(a=0;a<rs.length;a++){
			 //   		aa=rs[a]
			 //   		data={userinfo,userName,data:aa}
			 //   		vm.check_row.push(data);
			 //       } 				    	
				// }     	          
    //         }else{
    //         	vm.check_row=[]
    //         }   	    
	   // 	console.log(vm.check_row);                            
    //     },
    
//U暗网全选        
// selectAll:function() { 
//  const allSelected = this.row.every(rs => rs.data.every(res => this.sex.includes(res))); 
//   if (allSelected) { 
//  // 如果全部选中，则取消全选 
//  this.sex = []; 
//  this.check_row = []; 
//  } else { 
//  // 否则，选中所有 
//  this.sex = []; 
//  this.check_row = []; 
//  for (let rs of this.row) { 
//  for (let res of rs.data) { 
//  this.checkResources(rs.userinfo, rs.userName, rs.data, res.id, res.name); 
//  this.sex.push(res); 
//  } 
//  } 
//  } 
//  }, 
 
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
				$("#range_15").ionRangeSlider({
					min: min,
					max: max,
					from: from,
					skin: "square",
				});
			},
			scoresz: function(min, max, from) {
				$("#range_14").ionRangeSlider({
					min: min,
					max: max,
					from: from,
					skin: "round",
				});
			},
			
	    getclass:function(){
		  var load=layer.load(2);
 			this.$http.post("/apisub.php?act=getclassjiade").then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.class1=data.body.data;
	          		 this.class1_temp = JSON.parse(JSON.stringify(this.class1));
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
	    	
	    },
	    tips0: function(message) {
    console.log("tips0 called with message: ", message);
    for(var i=0; this.class1.length>i; i++){
        console.log("Checking class1 element: ", this.class1[i]); 
        if(this.class1[i].cid === message){
            this.dockInfo = '【商品ID：' + this.class1[i].cid + '】'+'【分类ID：' + this.class1[i].fenlei + '】';
            console.log("dockInfo updated: ", this.dockInfo); 
            return;
        }
    }
   },
   
getUserInfo() {//调用主页的用户信息接口
    this.$http.get('/apisub.php?act=userinfo').then(response => {
        if(response.body.code === 1) {
            this.money = response.body.money; // 更新余额
        } else {
            console.error("获取用户信息失败:", response.body.msg);
        }
    }).catch(error => {
        console.error("请求用户信息接口失败", error);
    });
},

copyQueryInfo: function() {
    let infoToCopy = "发送课程数字，确认后为您安排！\n" +
                     "例：课程1 2 3确认！\n" +
                     "------------------------\n";
                     
    
    let courseNumber = 1;

    // 如果有选中的课程，只复制选中的课程
    this.check_row.forEach((selectedCourse) => {
        infoToCopy += `课程${courseNumber}：${selectedCourse.data.name}\n`;
        courseNumber++;
    });

    // 如果没有选中的课程，复制所有课程
    this.row.forEach((rs) => {
        rs.data.forEach((course) => {
            infoToCopy += `课程${courseNumber}：${course.name}\n`;
            courseNumber++;
        });
    });

    infoToCopy += "------------------------";
    
    // 创建一个临时的 textarea 元素来复制文本
    var tempTextArea = document.createElement('textarea');
    tempTextArea.value = infoToCopy;
    document.body.appendChild(tempTextArea);
    tempTextArea.select();
    document.execCommand('copy');
    document.body.removeChild(tempTextArea);

    this.$message({
  message: '复制成功',
  type: 'success',
});
},
        tips: function (message) {
            if (message == '1128' || message == '1129' || message == '1130' || message == '1221' || message == '1601' || message == '6548' || message == '6549' || message == '6677' || message == '6749' || message == '1621' || message == '1622') {
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
        	 	    this.content2 = this.class1[i].content2;
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
        	 
        	 tips3: function (message) {
        	 for(var i=0;this.class1.length>i;i++){
        	 	if(this.class1[i].cid==message){
        	 	    this.show = true;
        	 	    this.content1 = this.class1[i].content1;
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
        	layer.tips('开启秒刷将额外收0.05的费用', '#miaoshua');      	  
		  
        }    
	},
	
	kcidAll: function() {
                if(this.row.length < 1) {
                    layer.msg("请先查课");
                    return false;
                }
                if(this.kcidAllValue == 0) {
                    this.kcidAllValue = 1
                } else {
                    this.kcidAllValue = 0
                }
            },
	
	mounted(){
		this.getclass();	
		this.getUserInfo(); // 在页面加载时调用getUserInfo方法来获取并显示余额
	 
	}
	
	
	
});

//此代码是解决ios输入法无法弹出问题
shanchu=function (){
    document.getElementById('select').removeAttribute('readOnly');
}
var timer = setInterval("shanchu()","500");

</script>

  <script>
        // 清理缓存函数
        function clearCache() {
            // 使用layui的弹窗提示用户操作结果
            layui.layer.msg('缓存已清理', {icon: 1, time: 5000});

            // 清理浏览器缓存的具体逻辑，可以根据需求进行调整
            // 以下是一个简单的示例，使用location.reload()重新加载页面来清除缓存
            location.reload(true);
        }
    </script>
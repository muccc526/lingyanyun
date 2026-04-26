<?php
$mod='blank';
$title='订单列表';
require_once('head.php');
?>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
        <link rel="stylesheet" href="new/js/bootstrap.min.css">
        <link rel="stylesheet" href="new/css/apps.css" type="text/css"/>
        <link rel="stylesheet" href="new/css/app.css" type="text/css"/>
        <link rel="stylesheet" href="new/layui/css/layui.css" type="text/css"/>
        <link href="new/js/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="new/LightYear/js/bootstrap-multitabs/multitabs.min.css">
        <link href="new/LightYear/css/bootstrap.min.css" rel="stylesheet">
        <link href="new/LightYear/css/style.min.css" rel="stylesheet">
        <link href="new/LightYear/css/materialdesignicons.min.css" rel="stylesheet">
        <script src="new/js/jquery.min.js"></script>
        <script src="layer/3.1.1/layer.js"></script>
    </head>
    <body>
       

            <head>
                <!-- Stylesheets -->
                <link rel="stylesheet" href="new/css/index.css">
                <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
                <link rel="stylesheet" href="new/css/apps.css" type="text/css"/>
                <link rel="stylesheet" href="new/css/app.css" type="text/css"/>
                <link rel="stylesheet" href="new/layui/css/layui.css" type="text/css"/>
                <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
                <link rel="stylesheet" href="new/LightYear/js/bootstrap-multitabs/multitabs.min.css">
                <link rel="stylesheet" href="new/LightYear/css/bootstrap.min.css">
                <link rel="stylesheet" href="new/LightYear/css/style.min.css">
                <link rel="stylesheet" href="new/LightYear/css/materialdesignicons.min.css">
                <!-- Scripts -->
                <script src="new/css/vue@2.6.14"></script>
                <script src="new/css/index.js"></script>
                <script src="new/js/xlsx.full.min.js"></script>
                <script src="new/js/jquery.min.js"></script>
                <script src="layer/3.1.1/layer.js"></script>
            </head>
        </html>
        <body>
     
            <div class="wrapper-md control">
                <div class="panel panel-default" id="orderlist">
                    <div class="panel-heading font-bold bg-white">任务列表 (状态同步不及时，有时需手动更新)</div>
                    <div class="panel-body">
                        <div class="form-horizontal devform">
                            <div class="form-group layui-col-space15">
                                <div class="col-sm-1 col-xs-4" style="width: 50%;">
                                    <el-select v-model="cx.cid" placeholder="点击可搜索平台" style="background: url('../index/arrow.png') no-repeat scroll 99%;width: 100%;" filterable>
                                       <el-option label="点击可搜索平台" value=""></el-option>
                                        <?php
					                	     	$a=$DB->query("select * from qingka_wangke_class where status=1 ");
												while($row=$DB->fetch($a)){
							                      echo '<el-option label="'.$row['name'].'" value="'.$row['cid'].'"></el-option>';
												}
                                            ?>  
                                    </el-select>
                                </div>
                                <div class="col-sm-1 col-xs-4" style="width: 50%;">
                                    <el-select v-model="cx.status_text" placeholder="任务状态" style="background: url('../index/arrow.png') no-repeat scroll 99%;width: 100%;">
                                        <el-option label="任务状态" value=""></el-option>
                                        <el-option label="待处理" value="待处理"></el-option>
                                        <el-option label="待重刷" value="待重刷"></el-option>
                                        <el-option label="进行中" value="进行中"></el-option>
                                        <el-option label="习惯分" value="习惯分"></el-option>
                                        <el-option label="待开课" value="待开课"></el-option>
                                        <el-option label="队列中" value="队列中"></el-option>
                                        <el-option label="待考试" value="待考试"></el-option>
                                        <el-option label="已完成" value="已完成"></el-option>
                                        <el-option label="上号中" value="上号中"></el-option>
                                        <el-option label="补刷中" value="补刷中"></el-option>
                                        <el-option label="重刷中" value="重刷中"></el-option>
                                        <el-option label="待更新" value="待更新"></el-option>
                                        <el-option label="异常" value="异常"></el-option>
                                        <el-option label="异常中" value="异常中"></el-option>
                                        <el-option label="已取消" value="已取消"></el-option>
                                        <el-option label="已退款" value="已退款"></el-option>
                                    </el-select>
                                </div>
                                <div class="col-sm-1 col-xs-4" style="width: 50%;">
                                    <el-select v-model="dc2.gs" placeholder="选择导出格式" style="background: url('../index/arrow.png') no-repeat scroll 99%;width: 100%;">
                                        <el-option label="选择导出格式" value=""></el-option>
                                        <el-option label="学校+账号+密码+课程名字" value="1"></el-option>
                                        <el-option label="账号+密码+课程名字" value="2"></el-option>
                                        <el-option label="学校+账号+密码" value="3"></el-option>
                                        <el-option label="账号+密码" value="4"></el-option>
                                    </el-select>
                                </div>
                                <div class="col-sm-1 col-xs-4" style="width: 50%;">
                                    <el-select v-model="cx.limit" placeholder="每页订单数量，默认25条" style="background: url('../index/arrow.png') no-repeat scroll 99%;width: 100%;">
                                        <el-option label="每页订单数量" value=""></el-option>
                                        <el-option label="25条" value="25"></el-option>
                                        <el-option label="50条" value="50"></el-option>
                                        <el-option label="100条" value="100"></el-option>
                                        <el-option label="200条" value="200"></el-option>
                                        <el-option label="500条" value="500"></el-option>
                                        <el-option v-if="row.uid==1" label="1000条" value="1000"></el-option>
                                    </el-select>
                                </div>
                                <div class="col-sm-1 col-xs-4" style="width: 50%;" v-if="row.uid==1">
                                    <el-select v-model="cx.dock" placeholder="处理状态" style="background: url('../index/arrow.png') no-repeat scroll 99%;width: 100%;">
                                        <el-option label="选择处理状态" value=""></el-option>
                                        <el-option label="待处理" value="0"></el-option>
                                        <el-option label="处理成功" value="1"></el-option>
                                        <el-option label="处理失败" value="2"></el-option>
                                        <el-option label="重复下单" value="3"></el-option>
                                        <el-option label="已取消" value="4"></el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="layui-row">
                                    <div class="col-sm-1 col-xs-4" style="width: 100%;">
                                        <el-input placeholder="模糊查询" v-model="cx.mh" class="input-with-select">
                                            <el-select v-model="cx.search" style="width:100px" placeholder="条件" slot="prepend">
                                                <el-option label="所有" value=""></el-option>
                                                <el-option label="UID" value="uid" v-if="row.uid === 1"></el-option>
                                                <el-option label="订单ID" value="oid" v-if="row.uid === 1"></el-option>
                                                <el-option label="学校" value="school"></el-option>
                                                <el-option label="账号" value="user"></el-option>
                                                <el-option label="密码" value="pass"></el-option>
                                                <el-option label="课程名称" value="kcname"></el-option>
                                                <el-option label="进度条" value="process"></el-option>
                                                <el-option label="详细进度" value="remarks"></el-option>
                                            </el-select>
                                            <el-button slot="append" icon="el-icon-search" @click="get(1)">搜索</el-button>
                                        </el-input>
                                        <div style="height:5px"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <el-collapse v-if="row.uid==1">
                            <el-collapse-item title="任务状态">
                                <el-button size="small" type="primary" @click="selectAll()" style="margin-right: 5px; margin-bottom: 5px;">全选</el-button>
                                <el-button size="small" type="info" @click="status_text('待处理')" style="margin-right: 5px; margin-bottom: 5px;">待处理</el-button>
                                <el-button size="small" type="success" @click="status_text('已完成')" style="margin-right: 5px; margin-bottom: 5px;">已完成</el-button>
                                <el-button size="small" type="warning" @click="status_text('进行中')" style="margin-right: 5px; margin-bottom: 5px;">进行中</el-button>
                                <el-button size="small" type="danger" @click="status_text('异常')" style="margin-right: 5px; margin-bottom: 5px;">异常</el-button>
                                <el-button size="small" type="danger" @click="status_text('密码错误')" style="margin-right: 5px; margin-bottom: 5px;">密码错误</el-button>
                                <el-button size="small" type="dark" @click="status_text('已退单')" style="margin-right: 5px; margin-bottom: 5px;">已退单</el-button>
                                <el-button size="small" type="default" @click="status_text('已取消')" style="margin-right: 5px; margin-bottom: 5px;">已取消</el-button>
                                <el-button size="small" type="danger" @click="status_text('未授权')" style="margin-right: 5px; margin-bottom: 5px;">未授权</el-button>
                                <el-button size="small" type="danger" @click="status_text('待验证')" style="margin-right: 5px; margin-bottom: 5px;">待验证</el-button>
                                <span style="margin-top: 10px;">注：勾选订单后才能修改任务状态或处理状态，会后端执行</span>
                            </el-collapse-item>
                            <el-collapse-item title="处理状态">
                                <el-button size="small" type="info" @click="dock(0)" style="margin-right: 5px; margin-bottom: 5px;">待处理</el-button>
                                <el-button size="small" type="success" @click="dock(1)" style="margin-right: 5px; margin-bottom: 5px;">已完成</el-button>
                                <el-button size="small" type="danger" @click="dock(2)" style="margin-right: 5px; margin-bottom: 5px;">处理失败</el-button>
                                <el-button size="small" type="warning" @click="dock(3)" style="margin-right: 5px; margin-bottom: 5px;">重复下单</el-button>
                                <el-button size="small" type="default" @click="dock(4)" style="margin-right: 5px; margin-bottom: 5px;">取消</el-button>
                                <el-button size="small" type="default" @click="del(sex)" style="margin-right: 5px; margin-bottom: 5px;">删除</el-button>
                                <el-button size="small" type="default" @click="dock(99)" style="margin-right: 5px; margin-bottom: 5px;">我的</el-button>
                                <el-button size="small" type="danger" @click="tk(sex)" style="margin-right: 5px; margin-bottom: 5px;">退款</el-button>
                            </el-collapse-item>
                        </el-collapse>
                        <div class="bg-gradient-tron">
                            批量操作:<br/>
                            <template>
                                <div>
                                    <!-- 批量更新按钮 -->
                                    <el-tooltip content="批量更新订单进度和详细备注" placement="top">
                                        <el-button size="small" type="primary" @click="plzt(sex)">批量更新</el-button>
                                    </el-tooltip>
                                    <!-- 批量补刷按钮 -->
                                    <el-tooltip content="批量补刷，漏刷/卡单/异常时使用，勿频繁点击" placement="top">
                                        <el-button size="small" type="success" @click="plbs(sex)">批量补刷</el-button>
                                    </el-tooltip>
                                    <?php if($userrow['uid']==1){ ?>
                                    <!-- 批量删除按钮 -->
                                    <el-tooltip content="批量删除" placement="top">
                                        <el-button size="small" type="danger" @click="pldel(sex)">批量删除</el-button>
                                    </el-tooltip>
                                    <?php }?>
                                    <!-- 导出订单按钮 -->
                                    <el-tooltip content="点击导出订单，支持文本导出和表格导出" placement="top">
                                        <el-button size="small" type="warning" @click="showExportDialog">导出订单</el-button>
                                    </el-tooltip>
                                </div>
                            </template>
                            <br>
                            <p style="color: red; font-size: 14px; font-weight: bold;">注：勾选订单后才能进行批量操作，操作后订单会加入后端排队执行
                        </p>
                        </div>
                     		      <div class="layui-table table-responsive" lay-size="sm" >
		        <table class="table table-striped">
		          <thead><tr>
		              <th ><input type="checkbox" id="checkboxAll" @click="selectAll()" /></th>
		              <th>ID</th>
		              <th>平台</th>
		              <th>学校&nbsp;账号&nbsp;密码</th>
		              <th>课程名</th>
		              <th>金额</th>
		              <th>任务状态</th>
		              <th>刷新</th>
		              <th>补刷</th>
		              <th>取消</th>
		              <th>进度</th>
		              <th>备注</th>
		              <th>提交时间</th>
		              <th v-if="row.uid==1">处理状态</th>
		              <th>详情</th>
		              <th v-if="row.uid==1">UID</th>
		              </tr></thead>
		          <tbody>
		            <tr v-for="res in row.data">		            					
								  <td  > 
								  	<span class="checkbox checkbox-success"   >
			              <input type="checkbox" id="checkboxAll" :value="res.oid" v-model="sex"><label for="checkbox1"></label></span>
								  </td>
		            	<td>{{res.oid}}</td>
		            	<td>{{res.ptname}}<span v-if="res.miaoshua=='1'" style="color: red;">&nbsp;秒刷</span></td>	            	      	
		            	<td>{{res.school}}
		                     {{res.user}}
		            	     {{res.pass}}
		            	</td>
		            	<td>{{res.kcname}}</td>
		            	
		            	<td>{{res.fees}}</td>
		            	
	            	<td>
                        <el-button style="color: green; border: 1px solid green;" @click="ddinfo(res)" size="mini" v-if="res.status=='已完成'">{{res.status}}</el-button>
                        <el-button style="color: blue; border: 1px solid blue;" @click="ddinfo(res)" size="mini" v-else-if="res.status=='待处理'">{{res.status}}</el-button>
                        <el-button style="color: red; border: 1px solid red;" @click="ddinfo(res)" size="mini" v-else-if="res.status=='异常'">{{res.status}}</el-button>
                        <el-button style="color: orange; border: 1px solid orange;" @click="ddinfo(res)" size="mini" v-else-if="res.status=='进行中'">{{res.status}}</el-button>
                        <el-button style="color: purple; border: 1px solid purple;" @click="ddinfo(res)" size="mini" v-else>{{res.status}}</el-button>
	            	</td> 
	            	<td><el-button type="primary"  plain size="mini"  @click="up(res.oid)">更新</el-button></td>
                    <td><el-button type="warning"  plain  size="mini" @click="bs(res.oid)">补刷</el-button></td>
                    <br><button @click="feedback(res.oid)" class="btn btn-xs btn-warning">反馈</button>&nbsp;
                     
                    <td><el-button type="danger" plain size="mini" @click="quxiao(res.oid)">删除</el-button></td>
<td style="text-align: center;">{{res.process}}
		            	<div class="progress reverse-progress">
      <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" class="progress-bar progress-bar-blue progress-bar-success active progress-bar-striped rounded" role="progressbar" v-bind:style="'width:'+(res.process)+';' "></td>
		            <td>
    <div v-if="res.cid=='513'">
        <a :href="'http://exam.hm86.xyz/jietu/exam.hm86.cn/zhengshu.php?username=' + res.user" target="_blank" class="btn btn-xs btn-info">查看证书</a>
        <a :href="'http://exam.hm86.xyz/jietu/exam.hm86.cn/examination.php?username=' + res.user" target="_blank" class="btn btn-xs btn-info">截图分数</a>
    </div>
     <div v-if="res.cid=='512'">
        <a :href="'http://exam.hm86.online/zhengshu/exam.hm86.cn/examination.php?username=' + res.user" target="_blank" class="btn btn-xs btn-info">查看证书</a>
        <a :href="'http://exam.hm86.online/jietu/exam.hm86.cn/examination.php?username=' + res.user" target="_blank" class="btn btn-xs btn-info">截图分数</a>
    </div>
    <div v-else>
        {{res.remarks}}
    </div>
</td>
       	
		            	<td>{{res.addtime}}</td>
		            	    <td style="white-space:nowrap" v-if="row.uid==1">
		            		<span @click="duijie(res.oid)" v-if="res.dockstatus==0" class="el-button el-button--warning el-button--mini">等待</span>
		            		<span v-if="res.dockstatus==1" class="el-button el-button--success el-button--mini">成功</span>
		            		<span @click="duijie(res.oid)" v-if="res.dockstatus==2" class="el-button el-button--danger el-button--mini">失败</span>
		            		<span v-if="res.dockstatus==3" class="el-button el-button--info el-button--mini">重复</span>
		            		<span v-if="res.dockstatus==4" class="el-button el-button--default is-plain el-button--mini">取消</span>
		            		<span v-if="res.dockstatus==99" class="el-button el-button--default is-plain el-button--mini">自营</span></td> 
		            		<td><span class="btn btn-xs btn-primary" @click="ddinfo(res)"><i class="layui-icon layui-icon-set-fill"></i> </span></td>
		            		<td v-if="row.uid==1">{{res.uid}}</td>
		            <!--td v-if="res.status!='已取消'"><button @click="ms(res.oid)" v-if="res.miaoshua==0" class="btn btn-xs btn-danger">秒刷</button>&nbsp;<button @click="up(res.oid)" class="btn btn-xs btn-success">更新状态</button>&nbsp;<button @click="bs(res.oid)" class="btn btn-xs btn-primary">补刷</button>&nbsp;<button @click="quxiao(res.oid)"  class="btn btn-xs btn-info">取消</button></td--> 
		            </tr>
                        
		          </tbody>
		        </table>
		      </div>
  <ul class="pagination pagination-circle" v-if="row.last_page>1"> 
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
   <div id="ddinfo2" style="display: none;"><!--订单详情-->                    
			       <li class="list-group-item">
			       	<b>课程类型：</b>{{ddinfo3.info.ptname}}<span v-if="ddinfo3.info.miaoshua=='1'" style="color: red;">&nbsp;秒刷</span></li>
			       	<li class="list-group-item" style="word-break:break-all;"><b>账号信息：</b>{{ddinfo3.info.school}}&nbsp;{{ddinfo3.info.user}}&nbsp;{{ddinfo3.info.pass}}</li>
			       	<li class="list-group-item"><b>课程名字：</b>{{ddinfo3.info.kcname}}</li>
			       	<li class="list-group-item" v-if="ddinfo3.info.name!='null'"><b>学生姓名：</b>{{ddinfo3.info.name}}</li>
			       	<li class="list-group-item"><b>下单时间：</b>{{ddinfo3.info.addtime}}</li>
			       	<li class="list-group-item" v-if="ddinfo3.info.courseStartTime"><b>课程开始时间：</b>{{ddinfo3.info.courseStartTime}}</li>
			       	<li class="list-group-item" v-if="ddinfo3.info.courseEndTime"><b>课程结束时间：</b>{{ddinfo3.info.courseEndTime}}</li>
			       	<li class="list-group-item" v-if="ddinfo3.info.examStartTime"><b>考试开始时间：</b>{{ddinfo3.info.examStartTime}}</li>
			       	<li class="list-group-item" v-if="ddinfo3.info.examEndTime"><b>考试结束时间：</b>{{ddinfo3.info.examEndTime}}</li>
			       	<li class="list-group-item"><b>订单状态：</b><span style="color: red;">{{ddinfo3.info.status}}</span>&nbsp;<button v-if="ddinfo3.info.dockstatus!='99'" @click="up(ddinfo3.info.oid)" class="btn btn-xs btn-success">刷新</button>&nbsp;</li>
			       	<li class="list-group-item"><b>进度：</b>{{ddinfo3.info.process}}<div class="progress">
		            	        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" v-bind:style="'width:'+(ddinfo3.info.process)+';' ">
		            	        </div>
		            	    </div></li>
			       	<li class="list-group-item" v-if="ddinfo3.info.remarks"><b>备注：</b>{{ddinfo3.info.remarks}}</li>
			       	<li class="list-group-item" v-if="ddinfo3.info.status!='已取消'"><b>操作：</b><button @click="ms(ddinfo3.info.oid)" v-if="false" class="btn btn-xs btn-danger">秒刷</button>&nbsp;<button v-if="false" @click="layer.msg('更新中，近期开放')" class="btn btn-xs btn-info">修改密码</button>&nbsp;<button @click="bs(ddinfo3.info.oid)" class="btn btn-xs btn-primary">补刷</button>&nbsp;<button @click="feedback(ddinfo3.info.oid)" class="btn btn-xs btn-primary">反馈</button>&nbsp;<button @click="tuisong(ddinfo3.info.oid)" class="btn btn-xs btn-primary">推送</button>&nbsp;<button @click="quxiao(ddinfo3.info.oid)"  class="btn btn-xs btn-default">取消</button></li>		       	  
		      </div>
</div></div></div></div></div><script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script type="text/javascript" src="assets/LightYear/js/jquery.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/bootstrap.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="assets/LightYear/js/main.min.js"></script>
<script src="assets/js/aes.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/vue-resource.min.js"></script>
<script src="js/axios.min.js"></script>
<script src="assets/layui/layui.js"></script>
<script src="assets/js/element.js"></script>
<script type="text/javascript">
    var uidFromPHP = null;
    vm = new Vue({
        el: "#orderlist",
        data: {
            row: null,
            phone: '',
            sex: [],
            ddinfo3: {
                status: false,
                info: []
            },
            dc: [],
            dc2: {
                gs: ''
            },
            cx: {
                status_text: '',
                dock: '',
                qq: '',
                mh: '',
                search: '',
                oid: '',
                uid: '',
                school: '',
                kcname: '',
                cid: '',
                limit: ''
            },
            platforms: [],
        },
        methods: {
           get:function(page){
		  var load=layer.load(2);
		  data={cx:this.cx,page}
 			this.$http.post("/apisub.php?act=neworderlist",data,{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.row=data.body;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
		},
            
            del: function(sex) {
                layer.confirm('此操作会删除选中的订单,金额不会退回,请谨慎操作！', {
                    btn: ['确定', '取消'],
                    title: '删除确认',
                    icon: 3
                }, function(index) {
                    var load = layer.load();
                    $.post("/apisub.php?act=delorder", {
                        sex: sex
                    }, {
                        emulateJSON: true
                    }).then(function(data) {
                        layer.close(load);
                        if (data.code == 1) {
                            vm.selectAll();
                            vm.get(vm.row.current_page);
                            layer.msg(data.msg, {
                                icon: 1
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                            });
                        }
                    });
                });
            },
            	tuisong:function(oid){
          console.log(oid)
						layer.prompt({title: '请输入客户的SPT_token', formType: 3}, function(tuisongtoken, index){
						  var load=layer.load();
			              $.post("/apisub.php?act=kehutuisong",{oid:oid,token:tuisongtoken},function (data) {
					 	         layer.close(load);
				             if(data.code==1){
				             	  layer.close(index);
				             	  $("#ddinfo2").hide();
				             	  vm.get(vm.row.current_page);		
				                layer.alert(data.msg,{icon:1});
				             }else{
				                layer.msg(data.msg,{icon:2});
				             }
			              });		    		    
					  });
		 
	},feedback: function(oid) {
    var self = this;
    layer.prompt({
        title: '请用简短的一句话描述问题，只需要输入问题！',
        formType: 2,
        placeholder: '请输入问题描述...'
    }, function(feedbackText, index) {
        layer.close(index);
        feedbackText = feedbackText.trim();

        if (feedbackText === '') {
            layer.msg('反馈内容不能为空', {icon: 2});
            return;
        }
        if (/\d|[a-zA-Z]/.test(feedbackText)) {
            layer.msg('反馈内容不能包含数字和字母', {icon: 2});
            return;
        }

        var load = layer.load();
        $.get("/gd.php?act=feedback&oid=" + oid, { feedback: feedbackText }, function(data) {
            layer.close(load);
            if (data.code === 1) {
                layer.msg('反馈成功，请在我的反馈中查看', {icon: 1});
            } else {
                layer.msg('反馈失败: ' + data.msg, {icon: 2});
            }
        });
    });
},
            bs: function(oid) {
                layer.confirm('建议漏看或者进度被重置的情况下使用。<br>频繁点击补刷会出现不可预测的结果<br>请问是否补刷所选的任务？', {
                    title: '温馨提示',
                    icon: 3,
                    btn: ['确定补刷', '取消']//按钮
                }, function() {
                    var load = layer.load(2);
                    $.get("/apisub.php?act=bs&oid=" + oid, function(data) {
                        layer.close(load);
                        if (data.code == 1) {
                            vm.get(vm.row.current_page);
                            layer.alert(data.msg, {
                                icon: 1
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                            });
                        }
                    });
                });
            },
            up: function(oid) {
                var load = layer.load(2);
                layer.msg("正在努力获取中....", {
                    icon: 3
                });
                $.get("/apisub.php?act=uporder&oid=" + oid, function(data) {
                    layer.close(load);
                    if (data.code == 1) {
                        vm.get(vm.row.current_page);
                        setTimeout(function() {
                            for (i = 0; i < vm.row.data.length; i++) {
                                if (vm.row.data[i].oid == oid) {
                                    vm.ddinfo3.info = vm.row.data[i];
                                    console.log(vm.row.data[i].oid);
                                    console.log(vm.row.data[i].status);
                                    console.log(vm.ddinfo3.info.status);
                                    return true;
                                }
                            }
                        }, 1800);
                        layer.msg(data.msg, {
                            icon: 1
                        });
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                        //	                layer.alert(data.msg,{icon:2,btn:'立即跳转'},function(){
                        //	                	window.location.href=data.url
                        //	                });
                    }
                });
            },
            duijie: function(oid) {
                layer.confirm('确定处理么?', {
                    title: '温馨提示',
                    icon: 3,
                    btn: ['确定', '取消']//按钮
                }, function() {
                    var load = layer.load(2);
                    $.get("/apisub.php?act=duijie&oid=" + oid, function(data) {
                        layer.close(load);
                        if (data.code == 1) {
                            vm.get(vm.row.current_page);
                            layer.alert(data.msg, {
                                icon: 1
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                            });
                        }
                    });
                });
            },
            ms: function(oid) {
                layer.confirm('提交秒刷将扣除0.05元服务费', {
                    title: '温馨提示',
                    icon: 3,
                    btn: ['确定', '取消']//按钮
                }, function() {
                    var load = layer.load(2);
                    $.get("/apisub.php?act=ms_order&oid=" + oid, function(data) {
                        layer.close(load);
                        if (data.code == 1) {
                            vm.get(vm.row.current_page);
                            layer.alert(data.msg, {
                                icon: 1
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                            });
                        }
                    });
                });
            },
            quxiao: function(oid) {
                layer.confirm('取消订单将无法退款，确定取消吗', {
                    title: '温馨提示',
                    icon: 3,
                    btn: ['确定', '取消']//按钮
                }, function() {
                    var load = layer.load(2);
                    $.get("/apisub.php?act=qx_order&oid=" + oid, function(data) {
                        layer.close(load);
                        if (data.code == 1) {
                            vm.get(vm.row.current_page);
                            layer.alert(data.msg, {
                                icon: 1
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                            });
                        }
                    });
                });
            },
         plzt: function(sex) {
			    if(this.sex==''){layer.msg("请先选择订单！");return false;}
			    layer.confirm('是否确认批量同步', {title: '温馨提示',icon: 3,btn: ['确认', '取消']}, function() {
    				var load = layer.load();
    				$.post("/apisub.php?act=plzt",{sex: sex}, {emulateJSON: true}).then(function(data) {
    					layer.close(load);
    					if (data.code == 1) {
    						vm.selectAll();
    						vm.get(vm.row.current_page);
    						layer.msg(data.msg, {icon: 1});
    					} else {
    						layer.msg(data.msg, {
    							icon: 2
    						});
    					}
    				});
				});
			},
         plbs: function(sex) {
			    if(this.sex==''){layer.msg("请先选择订单！");return false;}
			    layer.confirm('是否确认入队补刷，入队后等待执行即可，禁止一直重复补刷！', {title: '温馨提示',icon: 3,btn: ['确认', '取消']}, function() {
    				var load = layer.load();
    				$.post("/apisub.php?act=plbs",{sex: sex}, {emulateJSON: true}).then(function(data) {
    					layer.close(load);
    					if (data.code == 1) {
    						vm.selectAll();
    						vm.get(vm.row.current_page);
    						layer.msg(data.msg, {icon: 1});
    					} else {
    						layer.msg(data.msg, {
    							icon: 2
    						});
    					}
    				});
				});
			},
		
		pldel: function(sex) {
			    if(this.sex==''){layer.msg("请先选择订单！");return false;}
			    layer.confirm('是否批量删除？', {title: '温馨提示',icon: 3,btn: ['确认', '取消']}, function() {
    				var load = layer.load();
    				$.post("/apisub.php?act=pldel",{sex: sex}, {emulateJSON: true}).then(function(data) {
    					layer.close(load);
    					if (data.code == 1) {
    						vm.selectAll();
    						vm.get(vm.row.current_page);
    						layer.msg(data.msg, {icon: 1});
    					} else {
    						layer.msg(data.msg, {
    							icon: 2
    						});
    					}
    				});
				});
			},
            status_text: function(a) {
                var load = layer.load(2);
                $.post("/apisub.php?act=status_order&a=" + a, {
                    sex: this.sex,
                    type: 1
                }, {
                    emulateJSON: true
                }).then(function(data) {
                    layer.close(load);
                    if (data.code == 1) {
                        vm.selectAll();
                        vm.get(vm.row.current_page);
                        layer.msg(data.msg, {
                            icon: 1
                        });
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
            },
            dock: function(a) {
                var load = layer.load(2);
                $.post("/apisub.php?act=status_order&a=" + a, {
                    sex: this.sex,
                    type: 2
                }, {
                    emulateJSON: true
                }).then(function(data) {
                    layer.close(load);
                    if (data.code == 1) {
                        vm.selectAll();
                        vm.get(vm.row.current_page);
                        layer.msg(data.msg, {
                            icon: 1
                        });
                    } else {
                        layer.msg(data.msg, {
                            icon: 2
                        });
                    }
                });
            },
            selectAll: function() {
                if (this.sex.length == 0) {
                    for (i = 0; i < vm.row.data.length; i++) {
                        vm.sex.push(this.row.data[i].oid)
                    }
                } else {
                    this.sex = []
                }
            },
            ddinfo: function(a) {
                this.ddinfo3.info = a;
                var load = layer.load(2, {
                    time: 300
                });
                setTimeout(function() {
                    layer.open({
                        type: 1,
                        title: '订单详情操作',
                        skin: 'layui-layer-demo',
                        closeBtn: 1,
                        anim: 2,
                        shadeClose: true,
                        content: $('#ddinfo2'),
                        end: function() {
                            $("#ddinfo2").hide();
                        }
                    });
                }, 100);

            },
            tk: function(sex) {
                if (this.sex == '') {
                    layer.msg("请先选择订单！");
                    return false;
                }
                layer.confirm('确定要退款吗？陛下，三思三思！！！', {
                    title: '温馨提示',
                    icon: 3,
                    btn: ['确定', '取消']
                }, function() {
                    var load = layer.load();
                    $.post("/apisub.php?act=tk", {
                        sex: sex
                    }, {
                        emulateJSON: true
                    }).then(function(data) {
                        layer.close(load);
                        if (data.code == 1) {
                            vm.selectAll();
                            vm.get(vm.row.current_page);
                            layer.msg(data.msg, {
                                icon: 1
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                            });
                        }
                    });
                });
            },
            dd_passwd: function(oid) {
                console.log(oid)
                layer.prompt({
                    title: '请输入新备注',
                    formType: 3
                }, function(password, index) {
                    var load = layer.load();
                    $.post("/apisub.php?act=dd_passwd", {
                        oid: oid,
                        pwd: password
                    }, function(data) {
                        layer.close(load);
                        if (data.code == 1) {
                            layer.close(index);
                            $("#ddinfo2").hide();
                            vm.get(vm.row.current_page);
                            layer.alert(data.msg, {
                                icon: 1
                            });
                        } else {
                            layer.msg(data.msg, {
                                icon: 2
                            });
                        }
                    });
                });

            },
            showExportDialog: function() {
                // 弹出导出对话框
                this.$confirm('请选择导出格式', '导出', {
                    confirmButtonText: 'xlsx格式',
                    cancelButtonText: '直接弹出',
                    cancelButtonClass: 'direct-export-btn',
                    // 添加直接弹出按钮的样式类
                    type: 'warning'
                }).then(()=>{
                    // 用户点击xlsx格式按钮时执行导出操作
                    this.daochu();
                }
                ).catch(()=>{
                    // 用户点击直接弹出按钮时执行导出操作
                    this.daochu1();
                }
                );
            },
            daochu1: function() {
                if (this.dc2.gs == '') {
                    layer.msg("请先选择格式", {
                        icon: 2
                    });
                    return false;
                }
                if (!this.sex[0]) {
                    layer.msg("请先选择订单", {
                        icon: 2
                    });
                    return false;
                }
                for (i = 0; i < this.sex.length; i++) {
                    oid = this.sex[i];
                    for (x = 0; x < this.row.data.length; x++) {
                        if (this.row.data[x].oid == oid) {
                            school = this.row.data[x].school;
                            user = this.row.data[x].user;
                            pass = this.row.data[x].pass;
                            kcname = this.row.data[x].kcname;
                            if (this.dc2.gs == '1') {
                                a = school + ' ' + user + ' ' + pass + ' ' + kcname;
                            } else if (this.dc2.gs == '2') {
                                a = user + ' ' + pass + ' ' + kcname;
                            } else if (this.dc2.gs == '3') {
                                a = school + ' ' + user + ' ' + pass;
                            } else if (this.dc2.gs == '4') {
                                a = user + ' ' + pass;
                            }
                            this.dc.push(a)
                        }
                    }
                }
                layer.alert(this.dc.join("<br>"));
                this.dc = [];
            },
            daochu: function() {
                if (this.dc2.gs == '') {
                    layer.msg("请先选择格式", {
                        icon: 2
                    });
                    return false;
                }
                if (!this.sex[0]) {
                    layer.msg("请先选择订单", {
                        icon: 2
                    });
                    return false;
                }

                // 构建 Excel 数据
                const excelData = [];
                const header = [];

                // 根据用户选择的格式构建表头
                if (this.dc2.gs == '1') {
                    header.push('学校', '用户名', '密码', '课程名');
                } else if (this.dc2.gs == '2') {
                    header.push('用户名', '密码', '课程名');
                } else if (this.dc2.gs == '3') {
                    header.push('学校', '用户名', '密码');
                } else if (this.dc2.gs == '4') {
                    header.push('用户名', '密码');
                }

                excelData.push(header);

                // 构建表格数据
                for (let i = 0; i < this.sex.length; i++) {
                    const oid = this.sex[i];
                    for (let x = 0; x < this.row.data.length; x++) {
                        if (this.row.data[x].oid == oid) {
                            const rowData = [];

                            // 根据用户选择的格式构建表格数据
                            if (this.dc2.gs == '1') {
                                rowData.push(this.row.data[x].school, this.row.data[x].user, this.row.data[x].pass, this.row.data[x].kcname);
                            } else if (this.dc2.gs == '2') {
                                rowData.push(this.row.data[x].user, this.row.data[x].pass, this.row.data[x].kcname);
                            } else if (this.dc2.gs == '3') {
                                rowData.push(this.row.data[x].school, this.row.data[x].user, this.row.data[x].pass);
                            } else if (this.dc2.gs == '4') {
                                rowData.push(this.row.data[x].user, this.row.data[x].pass);
                            }

                            excelData.push(rowData);
                        }
                    }
                }

                // 设置列宽和行高
                const wscols = [{
                    wpx: 100
                }, // 学校列宽度
                {
                    wpx: 100
                }, // 用户名列宽度
                {
                    wpx: 100
                }, // 密码列宽度
                {
                    wpx: 150
                }, // 课程名列宽度
                ];

                const wshrows = [{
                    hpx: 30
                }];
                // 设置表头行高

                // 设置表格中每一行的行高
                for (let i = 0; i < excelData.length; i++) {
                    wshrows.push({
                        hpx: 30
                    });
                }

                // 弹出确认导出对话框
                layer.confirm('确认导出为xlsx文件？', {
                    btn: ['确认', '取消'],
                    icon: 3,
                    title: '提示'
                }, (index)=>{
                    // 用户点击确认按钮时执行导出操作
                    const ws = XLSX.utils.aoa_to_sheet(excelData);

                    // 设置列宽和行高
                    ws['!cols'] = wscols;
                    ws['!rows'] = wshrows;

                    const wb = XLSX.utils.book_new();
                    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
                    XLSX.writeFile(wb, '订单数据.xlsx');

                    // 关闭确认对话框
                    layer.close(index);
                }
                , (index)=>{
                    // 用户点击取消按钮时执行的操作
                    // 关闭确认对话框
                    layer.close(index);
                }
                );
            }
        },
        mounted() {
            this.get(1);
        }
    });
</script>

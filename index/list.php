<?php
$mod='blank';
$title='订单列表';
require_once('head.php');
?>
     <div class="app-content-body ">
        <div class="wrapper-md control">
	    <div class="panel panel-default" id="orderlist" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
		    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">订单列表</div>
				 <div class="panel-body" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">
				 	<div class="form-horizontal devform">	
				 		   <div class="el-form layui-row layui-col-space10">
				              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6">	
				 		   				<el-select id="select" v-model="cx.cid" filterable placeholder="请选择状态" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
				 		   				    <el-option label="请选择商品分类" value=""></el-option>
				 		   				    <?php
					                	     	$a=$DB->query("select * from qingka_wangke_class where status=1 ");
												while($row=$DB->fetch($a)){
							                      echo '<el-option label="'.$row['name'].'" value="'.$row['cid'].'"></el-option>';
												}
                                            ?>
				 		   				</el-select>	 
				              </div>
				              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6">	
				 		   				<el-select id="select" v-model="cx.status_text" filterable placeholder="请选择订单状态" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
				 		   				    <el-option label="请选择订单状态" value=""></el-option>
				 		   				    <el-option label="待处理" value="待处理"></el-option>
				 		   				    <el-option label="待重刷" value="待重刷"></el-option>
				 		   				    <el-option label="已提交" value="已提交"></el-option>
				 		   				    <el-option label="进行中" value="进行中"></el-option>
				 		   					<el-option label="队列中" value="队列中"></el-option>
				 		   					<el-option label="考试中" value="考试中"></el-option>
				 		   				    <el-option label="平时分" value="平时分"></el-option>
				 		   				    <el-option label="已完成" value="已完成"></el-option>
				 		   				    <el-option label="补刷中" value="补刷中"></el-option>
				 		   				    <el-option label="异常" value="异常"></el-option>
				 		   				    <el-option label="已取消" value="已取消"></el-option>
				 		   				    <el-option label="已退款" value="已退款"></el-option>
				 		   				</el-select>	 
				              </div>
				              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6" v-if="row.uid==1">	
				 		   				<el-select id="select" v-model="cx.dock" filterable placeholder="请选择处理状态" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
				 		   				    <el-option label="请选择处理状态" value=""></el-option>
				 		   				    <el-option label="待处理" value="0"></el-option>
				 		   				    <el-option label="处理成功" value="1"></el-option>
				 		   				    <el-option label="处理失败" value="2"></el-option>
				 		   				    <el-option label="重复下单" value="3"></el-option>
				 		   				    <el-option label="已取消" value="4"></el-option>
				 		   				    <el-option label="我的" value="99"></option>
				 		   				</el-select>	 
				                </div> 
				                <div class="layui-col-md2 layui-col-sm3 layui-col-xs6">	
				 		   				<el-select id="select" v-model="cx.pagesize" filterable placeholder="请选择每页订单数量" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
				 		   				    <el-option label="请选择每页订单数量" value="25"></el-option>
				 		   				    <el-option label="50/页" value="50"></el-option>
				 		   				    <el-option label="100/页" value="100"></el-option>
				 		   				    <el-option label="200/页" value="200"></el-option>
				 		   				    <el-option label="500/页" value="500"></el-option>
				 		   				    <el-option label="1000/页" value="1000"></el-option>
				 		   				</el-select>	 
				                    </div> 
				                <div class="layui-formlayui-col-md2 layui-col-sm3 layui-col-xs6">	
				 		   				<el-select id="select" v-model="dc2.gs" filterable placeholder="请选择导出格式" style="background: url('../index/arrow.png') no-repeat scroll 99%;width:100%">
				 		   				    <el-option label="请选择导出格式" value="0"></el-option>
				 		   				    <el-option label="学校+账号+密码+课程名字" value="1"></el-option>
				 		   				    <el-option label="账号+密码+课程名字" value="2"></el-option>
				 		   				    <el-option label="学校+账号+密码" value="3"></el-option>
				 		   				    <el-option label="账号+密码" value="4"></el-option>
				 		   				</el-select>	 
				                    </div> 
			                </div>
                        <div class="form-horizontal devform">	
				 	          <div class="layui-row layui-col-space10">
				 	              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6">
				 	                  <el-input v-model="cx.oid" placeholder="请输入订单ID"></el-input>
				 	              </div>
				 	              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6">
				 	                  <el-input v-model="cx.qq" placeholder="请输入下单账号"></el-input>
				 	              </div>
				 	              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6">
				 	                  <el-input v-model="cx.status_text" placeholder="请输入状态关键字" ></el-input>
				 	              </div>
				 	              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6">
				 	                  <el-input v-model="cx.kcname" placeholder="请输入下单课程名称"></el-input>
				 	              </div>
				 	              <div class="layui-col-md2 layui-col-sm3 layui-col-xs6" v-if="row.uid==1">
				 	                  <el-input v-model="cx.uid" placeholder="请输入用户UID"></el-input>
				 	              </div>
				 	               
				 	              <div class="layui-col-md2 layui-col-sm3  layui-col-xs6" >
                                    <el-button type="primary" size="medium" icon="el-icon-search" value="查询" @click="get(1)" ></el-button>&nbsp;
                                    <el-button type="primary" size="medium" icon="el-icon-printer" value="导出" @click="daochu()" ></el-button>
        			             </div>
			             
			             </div>
			             </div>	
			          </div>
			          <br>
                        <div v-if="row.uid==1">
                            <el-collapse>
                                <el-collapse-item>
                                    <template slot="title"><i class="header-icon el-icon-edit"></i>&nbsp;任务状态操作</template>
                                    <div>
                                    <el-button type="warning" size="mini" icon="el-icon-time" @click="status_text('待处理')">待处理</el-button>
                                    <el-button type="success" size="mini" icon="el-icon-circle-check" @click="status_text('已完成')">已完成</el-button>
                                    <el-button type="success" size="mini" icon="el-icon-circle-check" @click="status_text('已考试')">已考试</el-button>
                                    <el-button type="primary" size="mini" icon="el-icon-loading" @click="status_text('进行中')">进行中</el-button>
                                    <el-button type="primary" size="mini" icon="el-icon-loading" @click="status_text('队列中')">队列中</el-button>
                                    <el-button type="danger" size="mini" icon="el-icon-warning-outline" @click="status_text('异常')">异常</el-button>
                                    <el-button size="mini" icon="el-icon-circle-close" @click="status_text('已取消')">已取消</el-button>
                                </div>
                              </el-collapse-item>
                              </el-collapse-item>
                              <el-collapse-item>
                                    <template slot="title"><i class="header-icon el-icon-edit"></i>&nbsp;处理状态操作</template>
                                        <div>
                                            <el-button type="warning" size="mini" @click="dock(0)">待处理</el-button>
                                            <el-button type="success" size="mini" @click="dock(1)">处理成功</el-button>
                                            <el-button type="danger" size="mini" @click="dock(2)">处理失败</el-button>
                                            <el-button type="info" size="mini" @click="dock(3)">重复下单</el-button>
                                            <el-button type="default" size="mini" @click="dock(4)">已取消</el-button>
                                            <el-button type="default" size="mini" @click="dock(99)">自营订单</el-button>
                                            <el-button type="danger" size="mini" @click="tk(sex)">订单退款</el-button><br><br>
                                            <el-button type="danger" size="mini" @click="sc(sex)">订单删除</el-button>
                                        </div>
                                </el-collapse-item>
                            </el-collapse>
                        </div>
                        <el-collapse accordion>
                          <el-collapse-item>
                            <template slot="title"><i class="header-icon el-icon-copy-document">&nbsp;批量操作</i>
                            </template>
                            <div>
                                <el-button size="mini" type="success" id="checkboxAll" @click="selectAll()" icon="el-icon-finished">订单全选</el-button>
                                <el-button size="mini" type="primary" @click="plzt(sex)" icon="el-icon-sort">批量同步</el-button>
                                <el-button size="mini" type="primary" @click="plbs(sex)" icon="el-icon-edit-outline">批量补刷</el-button>
                                
                            </div>
                          </el-collapse-item>
                        </el-collapse>
			          <br>
		      <div class="el-table-column-fixed  table-responsive table-condensed" lay-size="sm" >
		        <table class="table table-striped">
		          <thead style="white-space:nowrap"><tr>
		          	<th><label class="lyear-checkbox checkbox-inline checkbox-info">
                           <input type="checkbox" id="checkboxAll"  @click="selectAll()"><span>ID</span>
                       </label>
					</th>
		          	<th>操作</th>
		          	<th>任务状态</th>
		          	<th>平台</th>
		          	<th>学校&nbsp;账号&nbsp;密码</th>
		          	<th>课程名</th>
		          	<th v-if="row.uid==1">商品金额</th>
		          	<th>进度</th>
		          	<th>备注</th>
		          	<th>提交时间</th>
		          	<th v-if="row.uid==1">处理状态</th>
		          	<th v-if="row.uid==1">UID</th>
		          	</tr></thead>
		          	
		          <tbody>
		            <!--<a class="btn btn-xs btn-dark purplek"@click="plbs('待重刷')" >批量重刷</a>-->
		            <tr v-for="res in row.data">		            					
								  <!--<td>
								  	<span class="checkbox checkbox-success">
			              <input type="checkbox" id="checkboxAll" :value="res.oid" v-model="sex"><label for="checkbox1"></label></span>
								  </td>-->
				 
		         <td style="white-space:nowrap" >
		            <label class="lyear-checkbox checkbox-inline checkbox-info">
                    <input type="checkbox" id="checkboxAll" :value="res.oid" v-model="sex"><span v-if="row.uid==1">{{res.oid}}</span><span v-else>-</span>
						    </label>
					   </td>	
					   
				       <td style="white-space:nowrap">
							<div>	
                        	<button @click="up(res.oid)" class="btn btn-xs btn-success">更新</button>&nbsp;
                        	<button @click="bs(res.oid)" class="btn btn-xs btn-primary">补刷</button>
                        	<br><button @click="feedback(res.oid)" class="btn btn-xs btn-warning">反馈</button>&nbsp;
                        	<button circle @click="ddinfo(res)" v-if="res.miaoshua==0" class="btn btn-xs btn-danger">详情</button>
							</div>		
						</td>
						<td style="white-space:nowrap">
		            		<el-button v-if="res.status=='待处理'" type="warning" size="mini" icon="el-icon-time">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='待上号'" type="warning" size="mini" icon="el-icon-time">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='排队中'" type="warning" size="mini" icon="el-icon-time">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='已暂停'" type="warning" size="mini" icon="el-icon-video-pause">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='已完成'" type="success" size="mini" icon="el-icon-circle-check">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='已考试'" type="success" size="mini" icon="el-icon-circle-check">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='异常'" type="danger" size="mini" icon="el-icon-warning-outline">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='失败'" type="danger" size="mini" icon="el-icon-warning-outline">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='密码错误'" type="danger" size="mini" icon="el-icon-warning-outline">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='已提取'" type="primary" size="mini" icon="el-icon-upload">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='已提交'" type="primary" size="mini" icon="el-icon-upload">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='进行中'" type="primary" size="mini" icon="el-icon-loading">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='上号中'" type="primary" size="mini" icon="el-icon-monitor">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='考试中'" type="primary" size="mini" icon="el-icon-edit-outline">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='队列中'" type="primary" size="mini" icon="el-icon-time">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='待考试'" type="primary" size="mini" icon="el-icon-time">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='正在考试'" type="primary" size="mini" icon="el-icon-loading">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='平时分'" type="primary" size="mini" icon="el-icon-loading">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='作业中'" type="primary" size="mini" icon="el-icon-loading">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='补刷中'" type="info" size="mini" icon="el-icon-loading">{{res.status}}</el-button>
		            		<el-button v-else-if="res.status=='已退单'" type="info" size="mini" icon="el-icon-circle-close">{{res.status}}</el-button>
		            		<el-button  v-else style="color: white;"  type="info" size="mini" >{{res.status}}</el-button>
		            	</td>
					   <td style="white-space:nowrap">{{res.ptname}}
					   <span v-if="res.miaoshua=='1'" style="color: red;">&nbsp;秒单</span>
					   </td>	            	      	
<td style="white-space:nowrap, width: 225"><span v-if="res.school=='自动识别'">{{res.user}} {{res.pass}}</span><span  v-else>{{res.school}} <br> {{res.user}} <br> {{res.pass}}</span></td>
		            	<td style="white-space:nowrap, width: 225">{{res.kcname}}</td>
		            	<td style="white-space:nowrap" v-if="row.uid==1">{{res.fees}}</td>
		            	
		            	<td>{{res.process}}
		            	    <div class="layui-progress layui-progress-big" lay-showpercent="true">
		            	        <div class="layui-progress-bar layui-bg-blue"  lay-percent="res.process" v-bind:style="'width:'+(res.process)+';' ">
		            	        </div>
		            	    </div>
		            	</td> 

		            	    
		            	<td style="white-space:nowrap, width: 225">{{res.remarks}}</td>         	
		            	<td style="white-space:nowrap">{{res.addtime}}</td>
		            	<td style="white-space:nowrap" v-if="row.uid==1">
		            		<span @click="duijie(res.oid)" v-if="res.dockstatus==0" class="el-button el-button--warning el-button--mini">等待处理</span>
		            		<span v-if="res.dockstatus==1" class="el-button el-button--success el-button--mini">处理成功</span>
		            		<span @click="duijie(res.oid)" v-if="res.dockstatus==2" class="el-button el-button--danger el-button--mini">处理失败</span>
		            		<span v-if="res.dockstatus==3" class="el-button el-button--info el-button--mini">重复下单</span>
		            		<span v-if="res.dockstatus==4" class="el-button el-button--default is-plain el-button--mini">已取消</span>
		            		<span v-if="res.dockstatus==99" class="el-button el-button--default is-plain el-button--mini">自营订单</span></td>   
		            
                        <td v-if="row.uid==1">{{res.uid}}</td>
                        </tr>
		          </tbody>
		        </table>
		      </div>
		      
			     <ul class="pagination no-border" v-if="row.last_page>1"> 
			         <li><a @click="get(1)">首页</a></li>
			         <li><a @click="row.current_page>1?get(row.current_page-1):''">&laquo;</a></li>
		             <li  @click="get(row.current_page-3)" v-if="row.current_page-3>=1"><a>{{ row.current_page-3 }}</a></li>
					 <li  @click="get(row.current_page-2)" v-if="row.current_page-2>=1"><a>{{ row.current_page-2 }}</a></li>
					 <li  @click="get(row.current_page-1)" v-if="row.current_page-1>=1"><a>{{ row.current_page-1 }}</a></li>
					 <li :class="{'active':row.current_page==row.current_page}" @click="get(row.current_page)" v-if="row.current_page"><a>{{ row.current_page }}</a></li>
					 <li  @click="get(row.current_page+1)" v-if="row.current_page+1<=row.last_page"><a>{{ row.current_page+1 }}</a></li>
					 <li  @click="get(row.current_page+2)" v-if="row.current_page+2<=row.last_page"><a>{{ row.current_page+2 }}</a></li>
					 <li  @click="get(row.current_page+3)" v-if="row.current_page+3<=row.last_page"><a>{{ row.current_page+3 }}</a></li>		       			     
			         <li><a @click="row.last_page>row.current_page?get(row.current_page+1):''">&raquo;</a></li>
			         <li><a @click="get(row.last_page)">尾页</a></li>	    
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
			       	<li class="list-group-item"><b>订单状态：</b><span style="color: red;">{{ddinfo3.info.status}}</span>&nbsp;<button v-if="ddinfo3.info.dockstatus!='99'" @click="up(ddinfo3.info.oid)" class="el-button el-button--success is-plain el-button--mini"><li class="el-icon-refresh"></li>刷新</button>&nbsp;</li>
			       	<li class="list-group-item"><b>进度：</b>{{ddinfo3.info.process}}<div class="progress">
		            	        <div aria-valuemax="100" aria-valuemin="0" aria-valuenow="60" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" v-bind:style="'width:'+(ddinfo3.info.process)+';' ">
		            	        </div>
		            	    </div></li>
			       	<li class="list-group-item" v-if="ddinfo3.info.remarks"><b>备注：</b>{{ddinfo3.info.remarks}}</li>
			       	<li class="list-group-item"><b>下单价格：</b>{{ddinfo3.info.fees}} 元</li>
			       	<li class="list-group-item"><b>补刷次数：</b>{{ddinfo3.info.bsnum}} 次</li>
			       	<li class="list-group-item"><b>下单人IP：</b>{{ddinfo3.info.ip}} (UID:{{ddinfo3.info.uid}})</li>
			       	<li class="list-group-item" v-if="ddinfo3.info.status!='已取消'">
			       	<b>操作：</b>
			       	<button @click="feedback(ddinfo3.info.oid)" class="btn btn-xs btn-primary">反馈</button>&nbsp;
			       	<button @click="bs(ddinfo3.info.oid)" class="btn btn-xs btn-warning">补刷</button>&nbsp;
			       	 <button @click="tuisong(ddinfo3.info.oid)" class="btn btn-xs btn-primary">推送</button>&nbsp;
			       	 <button @click="quxiao(ddinfo3.info.oid)"  class="btn btn-xs btn-danger">取消</button>
			       	<button @click="ms(ddinfo3.info.oid)" v-if="ddinfo3.info.cid == 355 || ddinfo3.info.cid == 397 || ddinfo3.info.cid == 353" class="btn btn-xs btn-danger">秒刷</button>&nbsp; 
                    <button v-if="ddinfo3.info.cid == 355 || ddinfo3.info.cid == 397 || ddinfo3.info.cid == 353" @click="xgmm(ddinfo3.info.oid)" class="btn btn-xs btn-info">修改密码</button>&nbsp;
                    <button v-if="ddinfo3.info.cid == 355 || ddinfo3.info.cid == 397 || ddinfo3.info.cid == 353"  @click="zt(ddinfo3.info.oid)" class="btn btn-xs btn-vibrant-blue">暂停</button>
	                </li>
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
vm=new Vue({
	el:"#orderlist",
	data:{
		  row:[],
		  phone:'',
		  list:'',
		  sex:[],
		  ddinfo3:{
		  	status:false,
		  	info:[]
		  },
		  dc:[],
		  dc2:{
		  	gs:'0'
		  },
		  cx:{
		  	status_text:'',
		  	dock:'',
		  	qq:'',
		  	oid:'',
		  	uid:'',
		  	cid:'',
		  	kcname:'',
		  	pagesize:'25',
		  },
		  
	},
	methods:{
		get:function(page){
		  var load=layer.load(2);
		  data={cx:this.cx,page}
 			this.$http.post("/apisub.php?act=orderlist",data,{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.row=data.body;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
		},removepercent:function(text){
            function isNumeric(value) {
      return !isNaN(parseFloat(value)) && isFinite(value) && typeof value !== 'boolean';
    }
            if (isNumeric(text.split('%').join(""))){
                return text.split('%').join("");
            }
            return false;
        },getclass:function(){
		  var load=layer.load();
 			this.$http.post("/apisub.php?act=getclass").then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){			                     	
	          		this.class1=data.body.data;			             			                     
	          	}else{
	                layer.msg(data.data.msg,{icon:2});
	          	}
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
},tuisong:function(oid){
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
		 
	},getname:function(oid){
				var load=layer.load(2);
          $.get("/apisub.php?act=getname&oid="+oid,function (data) {
		 	     layer.close(load);
	             if (data.code==1){	             		             	 
	                layer.msg(data.msg,{icon:1});	                
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
         });			
		 },bs:function(oid){
		 	 		 	layer.confirm('建议漏看或者进度被重置的情况下使用。<br>频繁点击补刷会出现不可预测的结果<br>请问是否补刷所选的任务？', {title:'温馨提示',icon:3,
							  btn: ['确定补刷','取消'] //按钮
							}, function(){
		 			     var load=layer.load(2);
		          $.get("/apisub.php?act=bs&oid="+oid,function (data) {
				 	     layer.close(load);
			             if (data.code==1){
			             	  vm.get(vm.row.current_page);		             	 
			                layer.alert(data.msg,{icon:1});	                
			             }else{
			                layer.msg(data.msg,{icon:2});
			             }	              
		         });
         });
		 },up:function(oid){
				var load=layer.load(2);
				layer.msg("正在同步....",{icon:6});
          $.get("/apisub.php?act=uporder&oid="+oid,function (data) {
		 	     layer.close(load);
	             if (data.code==1){
	             	  vm.get(vm.row.current_page);  
	             	  setTimeout(function() {
	             	  	for(i=0;i<vm.row.data.length;i++){           	
					            	 if(vm.row.data[i].oid==oid){
					            	 	  vm.ddinfo3.info=vm.row.data[i];
					            	 	  console.log(vm.row.data[i].oid);
					            	 	  console.log(vm.row.data[i].status);
					            	 	  console.log(vm.ddinfo3.info.status);
					            	 	  return true;
					            	 } 
					            } 
	             	  },1800);   	             	  		             	 
	                layer.msg(data.msg,{icon:1});	                               
	             }else{
	              	layer.msg(data.msg,{icon:2});	
//	                layer.alert(data.msg,{icon:2,btn:'立即跳转'},function(){
//	                	window.location.href=data.url
//	                });
	             }	              
         });			
		 },plzt: function(sex) {
				if (this.sex == '') {
					layer.msg("请先选择订单！");
					return false;
				}
				layer.confirm('是否确认入队，入队后等待线程执行即可，禁止一直重复入队！20分钟内订单禁止入队，切记', {
					title: '温馨提示',
					icon: 3,
					btn: ['确认', '取消']
				}, function() {
					var load = layer.load();
					$.post("/apisub.php?act=plzt", {
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
			},plbs: function(sex) {
				if (this.sex == '') {
					layer.msg("请先选择订单！");
					return false;
				}
				layer.confirm('是否确认入队补刷，入队后等待线程执行即可，禁止一直重复入队！20分钟内订单禁止入队，切记', {
					title: '温馨提示',
					icon: 3,
					btn: ['确认', '取消']
				}, function() {
					var load = layer.load();
					$.post("/apisub.php?act=plbs", {
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
			},duijie:function(oid){
		 	layer.confirm('确定处理么?', {title:'温馨提示',icon:3,
							  btn: ['确定','取消'] //按钮
							}, function(){
		 			     var load=layer.load(2);
		          $.get("/apisub.php?act=duijie&oid="+oid,function (data) {
				 	     layer.close(load);
			             if (data.code==1){
			             	  vm.get(vm.row.current_page);		             	 
			                layer.alert(data.msg,{icon:1});	                
			             }else{
			                layer.msg(data.msg,{icon:2});
			             }	              
		         });
         });
		 },getname:function(oid){
				var load=layer.load(2);
          $.get("/apisub.php?act=getname&oid="+oid,function (data) {
		 	     layer.close(load);
	             if (data.code==1){	             		             	 
	                layer.msg(data.msg,{icon:1});	                
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
         });			
		 },xgmm:function (oid) {
    layer.prompt(
        { title: "修改密码", formType: 3 },
        function (xgmm, index) {
            layer.close(index);
            var load = layer.load();
            $.get("/apisub.php?act=xgmm&oid="+oid, { xgmm }, function (data) {
                layer.close(load);
                if (data.code == 1) {
                     
    						vm.get(vm.row.current_page);
    						layer.msg(data.msg, {icon: 1});
                } else {
                    layer.msg(data.msg, { icon: 2 });
                }
            });
        }
    );
},ms:function(oid){
			 	layer.confirm('提交秒刷将扣除0.05元服务费', {title:'温馨提示',icon:3,
								  btn: ['确定','取消'] //按钮
								}, function(){
			 			     var load=layer.load();
			          $.get("/apisub.php?act=ms_order&oid="+oid,function (data) {
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
		 zt:function(oid){
				var load=layer.load();
				layer.msg("正在暂停中....",{icon:3});
          $.get("/apisub.php?act=zt&oid="+oid,function (data) {
		 	     layer.close(load);
	             if (data.code==1){
	             	  vm.get(vm.row.current_page);  
	             	  setTimeout(function() {
	             	  	for(i=0;i<vm.row.data.length;i++){           	
					            	 if(vm.row.data[i].oid==oid){
					            	 	  vm.ddinfo3.info=vm.row.data[i];
					            	 	  console.log(vm.row.data[i].oid);
					            	 	  console.log(vm.row.data[i].status);
					            	 	  console.log(vm.ddinfo3.info.status);
					            	 	  return true;
					            	 } 
					            } 
	             	  },1800);   	             	  		             	 
	                layer.msg(data.msg,{icon:1});	                               
	             }else{
	              	layer.msg(data.msg,{icon:2});	
	             }	              
         });			
		 },quxiao:function(oid){
		 	 		 	layer.confirm('取消订单将无法退款，确定取消吗', {title:'温馨提示',icon:3,
							  btn: ['确定','取消'] //按钮
							}, function(){
		 			     var load=layer.load(2);
		          $.get("/apisub.php?act=qx_order&oid="+oid,function (data) {
				 	     layer.close(load);
			             if (data.code==1){
			             	  vm.get(vm.row.current_page);		             	 
			                layer.alert(data.msg,{icon:1});	                
			             }else{
			                layer.msg(data.msg,{icon:2});
			             }	              
		         });
         });
		 },status_text:function(a){
				var load=layer.load(2);
          $.post("/apisub.php?act=status_order&a="+a,{sex:this.sex,type:1},{emulateJSON:true}).then(function(data){
		 	     layer.close(load);
	             if (data.code==1){
	              	vm.selectAll();   
	             	  vm.get(vm.row.current_page);		             	            	 
	                layer.msg(data.msg,{icon:1});	                
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
         });	        
		 },dock:function(a){
				var load=layer.load(2);
          $.post("/apisub.php?act=status_order&a="+a,{sex:this.sex,type:2},{emulateJSON:true}).then(function(data){
		 	     layer.close(load);
	             if (data.code==1){
	              	vm.selectAll();   
	             	  vm.get(vm.row.current_page);		             	            	 
	                layer.msg(data.msg,{icon:1});	                
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }	              
         });	        
		 },selectAll: function () {
            if(this.sex.length==0) {
	          	for(i=0;i<vm.row.data.length;i++){           	
	            	vm.sex.push(this.row.data[i].oid)
	            }    	     	
          	}else{
          		this.sex=[]
          	}                           
      },ddinfo: function(a){  
      	    this.ddinfo3.info=a;
      	    var load=layer.load(2,{time:300});
      	    setTimeout(function() {
	             layer.open({
							  type: 1,
							  title:'订单详情操作',
							  skin: 'layui-layer-demo',
							  closeBtn: 1,
							  anim: 2,
							  shadeClose: true,
							  content: $('#ddinfo2'),
							  end: function(){ 
							    $("#ddinfo2").hide();
							  }
							});  
            }, 100); 
            
      },tk: function(sex) {
			    if(this.sex==''){layer.msg("请先选择订单！");return false;}
			    layer.confirm('确定要退款吗？陛下，三思三思！！！', {title: '温馨提示',icon: 3,btn: ['确定', '取消']}, function() {
    				var load = layer.load();
    				$.post("/apisub.php?act=tk",{sex: sex}, {emulateJSON: true}).then(function(data) {
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
			},sc: function(sex) {
			    if(this.sex==''){layer.msg("请先选择订单！");return false;}
			    layer.confirm('确定要删除此订单信息？', {title: '温馨提示',icon: 3,btn: ['确定', '取消']}, function() {
    				var load = layer.load();
    				$.post("/apisub.php?act=sc",{sex: sex}, {emulateJSON: true}).then(function(data) {
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
			},ikunbs: function(sex) {
			    if(this.sex==''){layer.msg("请先选择订单！");return false;}
			    layer.confirm('确定要重新入队上号？', {title: '温馨提示',icon: 3,btn: ['确定', '取消']}, function() {
    				var load = layer.load();
    				$.post("/apisub.php?act=kbs",{sex: sex}, {emulateJSON: true}).then(function(data) {
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
			},daochu:function(){
      	     if(this.dc2.gs=='0'){
      	     	  layer.msg("请先选择格式",{icon:2});
      	     	  return false;
      	     }     	 
      	     if(!this.sex[0]){
      	     	  layer.msg("请先选择订单",{icon:2});
      	     	  return false;
      	     }     
      	     for(i=0;i<this.sex.length;i++){
      	        	oid=this.sex[i];
      	        	for(x=0;x<this.row.data.length;x++){
	      	        	 if(this.row.data[x].oid==oid){
	      	        	 	  school=this.row.data[x].school;
	      	     	    	  user=this.row.data[x].user;
	      	     	    	  pass=this.row.data[x].pass;
	      	     	    	  kcname=this.row.data[x].kcname;
	      	     	    	  if(this.dc2.gs=='1'){
	      	     	    	  	 a=school+' '+user+' '+pass+' '+kcname; 
	      	     	    	  }else if(this.dc2.gs=='2'){
	      	     	    	  	 a=user+' '+pass+' '+kcname; 
	      	     	    	  }else if(this.dc2.gs=='3'){
	      	     	    	  	 a=school+' '+user+' '+pass;
	      	     	    	  }else if(this.dc2.gs=='4'){
	      	     	    	  	 a=user+' '+pass;
	      	     	    	  }
	      	     	    	  this.dc.push(a)
	      	     	    }
      	        	}  
      	     }   	     
      	     layer.alert(this.dc.join("<br>"));
      	     this.dc=[];        
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
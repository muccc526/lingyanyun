<?php
$mod='blank';
$title='课程ID对比';
require_once('head.php');
?>
<div class="app-content-body">
	    <div class="wrapper-md control">		
			<div class="row">
				<div class="col-sm-12">
				    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">课程ID对比</div>
		          <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">    
         		      <div class="table-responsive"> 
				        <table class="layui-hide" id="kcidlist"></table>
                        <script type="text/html" id="kcidfy">
				      </div>
		          </div>		
		        </div>
				
            </div>
       </div>
    </div>
</div>


<script src="assets/js/aes.js"></script>

<script src="assets/layui/layui.js"></script>
<script>
layui.use('table', function(){
  var table = layui.table;
  var inst = table.render({
    elem: '#kcidlist',
    url:'../apisub.php?act=kcidlist',
    
    response: {
      statusCode: 1 // 重新规定成功的状态码为 200，table 组件默认为 0
    },
    // 将原始数据解析成 table 组件所规定的数据格式
    parseData: function(res){
      return {
        "code": "1", //解析接口状态
        "msg": "", //解析提示文本
        "count": res.count, //解析数据长度
        "data": res.data //解析数据列表
      };
    },
    page: {
      layout: ['prev', 'page', 'next','limit'], //自定义分页布局
      //curr: 5, //设定初始在第 5 页
      groups: 5, //只显示 1 个连续页码
      first: '首页', //不显示首页
      last: '尾页', //不显示尾页
      limits: [20, 50, 100],
      theme: '#1E9FFF',
      limit: 20 // 每页默认显示的数量
    },
    pagebar: '#kcidfy', // 分页栏模板
    cols: [[ //标题栏
      //{checkbox: true, fixed: true},
      {field: 'oid', title: '订单ID', width: 75,},
      {field: 'ptname', title: '商品名称', width: 240},
      {field: 'user', title: '下单账号', width: 150, minWidth: 100},
      {field: 'kcname', title: '课程名称', width: 300},
      {field: 'kcid', title: '课程ID', width: 600},
      {field: 'addtime', title: '提交时间', width: 250},
      {field: 'status', title: '订单状态', width: 250}
      
    ]],
  });
});
</script>
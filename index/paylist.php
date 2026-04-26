<?php
$mod='blank';
$title='支付列表';
require_once('head.php');
if($userrow['uid']!=1){
	alert("你来错地方了","index.php");
}
?>
<div class="app-content-body">
	    <div class="wrapper-md control">		
			<div class="row">
				<div class="col-sm-12">
				    <div class="panel-heading font-bold bg-white">支付记录</div>
		          <div class="panel panel-default">    
         		      <div class="table-responsive"> 
				        <table class="layui-hide" id="paylist"></table>
                        </script>
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
<script>
layui.use('table', function(){
  var table = layui.table;
  
  // 已知数据渲染
  var inst = table.render({
    elem: '#paylist',
    url:'../apisub.php?act=paylist',
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
    pagebar: '#paylistfy', // 分页栏模板
    cols: [[ //标题栏
      {checkbox: true, fixed: true},
      {field: 'oid', title: 'ID', width: 80, sort: true},
      {field: 'out_trade_no', title: '订单ID', width: 200},
      {field: 'uid', title: '用户UID', width: 100},
      {field: 'name', title: '商品名称', width: 180},
      {field: 'type', title: '支付方式', width: 100, minWidth: 100},
      {field: 'addtime', title: '订单创建时间', width: 220},
      {field: 'endtime', title: '支付时间', width: 220},
      {field: 'ip', title: '操作IP', width: 150},
      {field: 'status', title: '支付状态', width: 120, sort: true}
      
    ]],
    //skin: 'line', // 表格风格
    
    theme: '#1E9FFF',
    even: true, // 是否开启隔行换色
    page: true, // 是否显示分页
    limits: [30, 50, 100],
    limit: 15 // 每页默认显示的数量*/
    
  });
});
</script>
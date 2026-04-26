<?php
include('head.php');
?>
     <div class="app-content-body ">
        <div class="wrapper-md control" id="charge">
				          <div class="card" class="">
				             <div class="card-header">	
				             上级信息
				             </div>	
				             
				            <li class="list-group-item">
				           <div class="edit-avatar">
                  <img src="http://q2.qlogo.cn/headimg_dl?dst_uin=<?=$sj['user'];?>&spec=100" alt="..." class="img-avatar">
                  <div class="avatar-divider"></div>
                  <div class="edit-avatar-content">
                        <span style="color:black;">上级联系方式：<?php echo $sj['user']?></span><br> 
                        <span style="color:red;">上级邀请码：<?php echo $sj['yqm']?></span><br> 	
					    <span style="color:green">上级余额：<?=$sj['money'];?></span>		
                  </div>
                </div>			              
			              
				            </li>   		          	          
				          </div>
				          
	<div class="col-sm-12" id="pay2" style="display: none;">
    	<form action="/epay/epay.php" method="post">
    		<div><center style="margin-top:15px;"><h3>￥{{money}}</h3></center></div>
    		<input type="hidden" name="out_trade_no" v-model="out_trade_no"/><br>
			<button type="radio" name="type" value="alipay" class="btn btn-primary btn-block" >支付宝</button><br>
			<button type="radio" name="type" value="qqpay" class="btn btn-danger btn-block">QQ</button><br>
			<button type="radio" name="type" value="wxpay" class="btn btn-info btn-block">微信</button><br>
		</form>	
    </div>   
				        <div style="margin-top: 20px;">
				          <div class="card" class="">
				             <div class="card-header">	
				             	我设置的公告&nbsp;<button class="btn btn-xs btn-success" @click="szgg">添加</button>
				             </div>			             
				            <li class="list-group-item">				            	
                                 <span> <?php echo $userrow['notice'];?> </span>
				            </li>   
				          
				          </div>
			             </div>	
				         
				         
				         <div style="margin-top: 20px;">
				          <div class="card" class="">
				             <div class="card-header">	
				             	上级公告
				             </div>			             
				            <li class="list-group-item">				            	
                                 <span><?php
				                        	echo $sj['notice'];
				                        ?>
				                 </span>
				            </li>   
				          
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
<script>
$("pay2").hide();
new Vue({
	el:"#charge",
	data:{
       money:'',
       out_trade_no:''
	},
	methods:{
		pay:function(page){
		    var load=layer.load(2);
 			this.$http.post("/apisub.php?act=pay",{money:this.money},{emulateJSON:true}).then(function(data){	
	          	layer.close(load);
	          	if(data.data.code==1){	
	          		$("pay2").show();
	          		this.out_trade_no=data.data.out_trade_no;	
	          		layer.msg(data.data.msg,{icon:1});		  
 					layer.open({
					  type: 1,
					  title: '请选择支付方式',
					  closeBtn: 0,
					  area: ['250px', '300px'],
					  skin: 'layui-bg-gray', //没有背景色
					  shadeClose: true,
					  content: $('#pay2'),
			  		  end: function(){ 
					    $("#pay2").hide();
					  }
					});          		                   	          			             			                     
	          	}else{	          		
	                layer.msg(data.data.msg,{icon:2});
	          	}
	        });	
		},szgg:function(){
		    	  		layer.prompt({title: '设置代理公告，您的代理可看到', formType: 2}, function(notice, index){
						  layer.close(index);
						  var load=layer.load(2);
			              $.post("/apisub.php?act=user_notice",{notice},function (data) {
					 	     layer.close(load);
				             if (data.code==1){  
				                layer.msg(data.msg,{icon:1});
				                window.location.href=""
				             }else{
				                layer.msg(data.msg,{icon:2});
				             }
			              });		    		    
					  });   	  	
		    	  }
	},
	mounted(){
		
	}
});
</script>

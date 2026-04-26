<?php
$mod='blank';
$title='修改密码';
require_once('head.php');
?> 
        <div class="wrapper-md control">
	       <div class="panel panel-default" id="add">
		      <div class="panel-heading font-bold bg-white ">修改密码</div>
			        <div class="panel-body">
			          <form action="" method="post" class="form-horizontal" role="form">
			            <div class="input-group">
			              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
			              <input type="text" v-model="oldpass" value="" class="form-control" placeholder="旧密码" required="required"/>
			            </div><br/>
			            <div class="input-group">
			              <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
			              <input type="text" v-model="newpass" class="form-control" placeholder="新密码" required="required"/>
			            </div><br/>
			            <!--<div class="form-group">
			              <div class="col-xs-12"><input type="button" @click="passwd" name="submit" value="修改" class=" layui-btn"/></div>
			            </div>-->
			            <div class="form-group">
			              <div class="col-xs-12"><input type="button" @click="passwd" name="submit" value="修改" class="btn btn-dark form-control"/></div>
			            </div>
			          </form>
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
	new Vue({
		el:"#add",
		data:{
			oldpass:'',
			newpass:''
		},
		methods:{
			passwd:function(){
			  var load=layer.load(2);
              $.post("/apisub.php?act=passwd",{oldpass:this.oldpass,newpass:this.newpass},function (data) {
		 	     layer.close(load);
	             if (data.code==1){	   
	                layer.alert(data.msg,{icon:1});
	             }else{
	                layer.msg(data.msg,{icon:2});
	             }
              });
			}
		}
	});
	
</script>
<?php
include('head.php');
?>
     <div class="app-content-body ">
        <div class="wrapper-md control" id="charge">
				          <div class="card" class="">
				             <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">卡密充值</div>
				            <li class="list-group-item">
				           <div class="edit-avatar">
                  <img src="http://q2.qlogo.cn/headimg_dl?dst_uin=<?=$userrow['user'];?>&spec=100" alt="..." class="img-avatar">
                  <div class="avatar-divider"></div>
                  <div class="edit-avatar-content">
                       <div class="h5 m-t-xs"><?=$userrow['name'];?> 欢迎您！</div>
                    <span style="color:red;">账号: <?=$userrow['user'];?></span><br> 	
							    <span style="color:green">余额:<?=$userrow['money'];?></span>		
                  </div>
                </div>
				            </li>
				            <div class="card-body">
						      <div class="form-group" style="overflow:hidden">									
				                        <input style="width: 150px; float: left;" type="text" class="layui-input" placeholder="请输入充值卡密" v-model="km"/>
				                    <button style="float: left;margin-left: 5px;" class="layui-btn" @click="paycard">立即充值</button>
							  </div>
							   1.正常情况下请联系上家进行充值。</b><br />
					        	2.充值卡不定时作为福利发放。</b><br />
				               </div>
				             <div class="card-header">充值卡查询</div>	
				             <div class="card-body">
							  <div class="form-group" style="overflow:hidden">									
				                    <input style="width: 150px; float: left;" type="text" class="layui-input" placeholder="请输入查询卡密" v-model="querykm"/>
				                    <button style="float: left;margin-left: 5px;" class="layui-btn" @click="querycard">立即查询</button>
							  </div>
                  <p>充值卡号：{{kminfo.content}}<p>
                  <p>卡密金额：&yen; {{kminfo.money}}<p>
                  <p>卡密状态：<font :class="{'text-success':kminfo.status == 0,'text-danger':kminfo.status == 1}">{{kminfo.status == 1 ?"已使用":"未使用"}}</font><p>
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
const chargeVm = new Vue({
  el: '#charge',
  data: {
    money: '',
    km: '',
    querykm: '',
    kminfo: {
      content: '请先查询',
      money: '0',
      status: '',
    },
    out_trade_no: '',
  },
  methods: {
  pay: function () {
  var load = layer.load(2);
  this.$http
    .post(
      '/apisub.php?act=pay',
      { money: this.money },
      { emulateJSON: true }
    )
    .then(function (data) {
      layer.close(load);
      if (data.data.code == 1) {
        $('pay2').show();
        this.out_trade_no = data.data.out_trade_no;
        layer.msg(data.data.msg, { icon: 1, time: 2000, anim: 0 });
        layer.open({
          type: 1,
          title: '请选择支付方式',
          closeBtn: 0,
          area: ['250px', '300px'],
          skin: 'layui-bg-gray', //没有背景色
          shadeClose: true,
          content: $('#pay2'),
          end: function () {
            $('#pay2').hide();
          },
        });
      } else {
        layer.msg(data.data.msg, { icon: 2, time: 2000, anim: 6 });
      }
    })
},
 paycard: function () {
  var load = layer.load(2)
  this.$http
    .post('/km.php?act=paykm', { content: this.km }, { emulateJSON: true })
    .then(function (data) {
      layer.close(load)
      if (data.data.code == -1) {  // 修改code为-1
        layer.msg(data.data.msg, { icon: 2, time: 2000, shift: 3 }) // 使用 layun 提示框
      } else {
        layer.msg(data.data.msg, { icon: 1, time: 2000, shift: 1 }) // 使用 layun 提示框
        setTimeout(function () {
          location.reload()
        }, 1000)
      }
    })
},
   querycard: function () {
  var load = layer.load(2)
  this.$http
    .post(
      '/km.php?act=querykm',
      { content: this.querykm },
      { emulateJSON: true }
    )
    .then(function (data) {
      layer.close(load)
      if (data.data.code == 1) {
        this.kminfo = data.data.data[0]
        layer.msg(data.data.msg, { icon: 1, time: 2000, anim: 3 })
      } else {
        layer.msg(data.data.msg, { icon: 2, time: 2000, anim: 1 })
      }
    })
},
    szgg: function () {
      layer.prompt(
        { title: '设置代理公告，您的代理可看到', formType: 2 },
        function (notice, index) {
          layer.close(index)
          var load = layer.load(2)
          $.post('/apisub.php?act=user_notice', { notice }, function (data) {
            layer.close(load)
            if (data.code == 1) {
              iziToast.success({
                title: data.msg,
                position: 'topRight',
              })
              window.location.href = ''
            } else {
              iziToast.error({
                title: data.msg,
                position: 'topRight',
              })
            }
          })
        }
      )
    },
  },
  mounted() {
    $('.preloader').fadeOut('slow')
  },
})

</script>
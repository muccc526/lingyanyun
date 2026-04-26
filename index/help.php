<?php
$mod='blank';
$title='课程说明';
require_once('head.php');
?>
	<div class="app-content-body">
	    <div class="wrapper-md control">		
			<div class="row">
				<div class="col-sm-12">
				    <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">【商品/价格/说明】 此处不显示密价！ 如有密价请以实际为准！ （Ctrl+F搜索）<br> 【CID就是查询参数和对接参数】</div>
		            <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">    
          <div class="card-body">
            <div class="row">
                <div class="col-xs-6 col-sm-3">
                    <input type="text" id="searchkeyword" class="form-control" placeholder="输入关键词进行筛选">
                </div>
                <div class="col-xs-6 col-sm-2">
                    <button id="daochubtn" class="btn btn-info ">导出当前价格表</button>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table" id="priceTable">
                <thead>
                  <tr>
                    <th scope="col" style="width: 90px;">分类ID</th>
                    <th scope="col" style="width: 90px;">商品CID</th>
                    <th scope="col">课程名称</th>
                    <th scope="col">价格</th>
                    <th scope="col">课程说明</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $a=$DB->query("select * from qingka_wangke_class where status=1 order by fenlei asc");
                    while($rs=$DB->fetch($a)){
                      echo "<tr>
                        <td>".$rs['fenlei']."</td>
                        <td>".$rs['cid']."</td>
                        <td>".$rs['name']."</td>
                        <td>".($rs['price']*$userrow['addprice'])."</td>
                        <td>".$rs['content']."</td></tr>"; 
                    }
                  ?>
                </tbody>
              </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<script>
$(document).ready(function() {
    $('#daochubtn').click(function() {
        var keyword = $("#searchkeyword").val();
        var fileName = keyword + "项目价格表.xlsx";
        var wb = XLSX.utils.table_to_book(document.getElementById('priceTable'), {sheet:"商品价格表"});
        XLSX.writeFile(wb, fileName);
    });

    $("#searchkeyword").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#priceTable tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
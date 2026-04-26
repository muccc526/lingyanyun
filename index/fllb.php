<?php
$mod = 'blank';
$title = '分类列表';
require_once('head.php');
?>
<div class="app-content-body">
    <div class="wrapper-md control">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 7px;">【课程分类列表】 分类 ID 用于一键分类对接！（Ctrl+F 搜索）<br> 
【分类 ID 就是分类的 ID】</div>
                <div class="panel panel-default" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6; border-radius: 7px;">
                    <div class="card-body">
                        <div class="row">
                            
                            <div class="col-xs-8 col-sm-4">
                                <div class="input-group" style="overflow: visible;">
                                    <input type="text" id="searchInput" class="form-control" placeholder="输入分类名称或分类 ID 进行搜索" style="width: 100%; box-sizing: border-box;">
                                    <span class="input-group-btn">
                                        <button id="searchBtn" class="btn btn-info btn-round" style="width: 100%;">搜索</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-2">
                                <button id="exportBtn" class="btn btn-info btn-round" style="width: 100%;">导出分类列表</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <div class="col-sm-4">
                                <table id="table1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">分类 ID</th>
                                            <th scope="col">分类名称</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a = $DB->query("
                                            SELECT 
                                                qwf.id, 
                                                qwf.name, 
                                                (SELECT COUNT(*) FROM qingka_wangke_class WHERE fenlei = qwf.id) AS product_count
                                            FROM 
                                                qingka_wangke_fenlei qwf
                                            WHERE 
                                                qwf.status = 1 
                                            ORDER BY 
                                                qwf.sort DESC 
                                            LIMIT 0, 14
                                        ");

                                        while ($rs = $DB->fetch($a)) {
                                            echo "<tr>
                                                    <td>{$rs['id']}</td>
                                                    <td>{$rs['name']} 共 {$rs['product_count']}个商品</td>
                                                  </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <table id="table2" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">分类 ID</th>
                                            <th scope="col">分类名称</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a = $DB->query("
                                            SELECT 
                                                qwf.id, 
                                                qwf.name, 
                                                (SELECT COUNT(*) FROM qingka_wangke_class WHERE fenlei = qwf.id) AS product_count
                                            FROM 
                                                qingka_wangke_fenlei qwf
                                            WHERE 
                                                qwf.status = 1 
                                            ORDER BY 
                                                qwf.sort DESC 
                                            LIMIT 14, 14
                                        ");

                                        while ($rs = $DB->fetch($a)) {
                                            echo "<tr>
                                                    <td>{$rs['id']}</td>
                                                    <td>{$rs['name']} 共 {$rs['product_count']}个商品</td>
                                                  </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-4">
                                <table id="table3" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">分类 ID</th>
                                            <th scope="col">分类名称</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $a = $DB->query("
                                            SELECT 
                                                qwf.id, 
                                                qwf.name, 
                                                (SELECT COUNT(*) FROM qingka_wangke_class WHERE fenlei = qwf.id) AS product_count
                                            FROM 
                                                qingka_wangke_fenlei qwf
                                            WHERE 
                                                qwf.status = 1 
                                            ORDER BY 
                                                qwf.sort DESC 
                                            LIMIT 28, 100
                                        ");

                                        while ($rs = $DB->fetch($a)) {
                                            echo "<tr>
                                                    <td>{$rs['id']}</td>
                                                    <td>{$rs['name']} 共 {$rs['product_count']}个商品</td>
                                                  </tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
$(document).ready(function() {
    $('#exportBtn').click(function() {
        var tableIds = ['table1', 'table2', 'table3'];
        var wb = XLSX.utils.book_new();
        var ws = XLSX.utils.aoa_to_sheet([]);
        tableIds.forEach(function(tableId, index) {
            var tableElement = document.getElementById(tableId);
            var tableData = XLSX.utils.table_to_sheet(tableElement);
            XLSX.utils.sheet_add_dom(ws, tableElement, { origin: -1 });
        });
        XLSX.utils.book_append_sheet(wb, ws, '分类列表');
        XLSX.writeFile(wb, '渠道分类表.xlsx');
    });

    // 监听搜索按钮的点击事件
    $('#searchBtn').click(function() {
        var searchText = $('#searchInput').val().toLowerCase();
        var tableIds = ['table1', 'table2', 'table3'];
        tableIds.forEach(function(tableId) {
            var table = document.getElementById(tableId);
            var rows = table.getElementsByTagName('tr');
            for (var i = 1; i < rows.length; i++) { // 从第 1 行开始，跳过表头
                var cells = rows[i].getElementsByTagName('td');
                var found = false;
                for (var j = 0; j < cells.length; j++) {
                    var cellText = cells[j].textContent.toLowerCase();
                    if (cellText.indexOf(searchText) > -1) {
                        found = true;
                        break;
                    }
                }
                if (found) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        });
    });
});
</script>
<style>
    /* 添加按钮悬浮效果 */
   .btn-round:hover {
        background-color: #007bff;
        color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
    }
</style>
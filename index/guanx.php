<?php
$title='卡密管理';
require_once('head.php');
if($userrow['uid']!=1){exit("<script language='javascript'>window.location.href='login.php';</script>");}
$uid=$_GET['uid'];
?>
    <div class="app-content-body">
  <div class="wrapper-md control" id="card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center mb-4 gap-3">
          <div class="panel-heading font-bold layui-bg-blue" style="box-shadow: 3px 3px 8px #d1d9e6, -3px -3px 8px #d1d9e6;border-radius: 7px;">卡密列表</div>
                      <div class="panel-body">
              <div class="form-inline">
  <div class="form-group">
    <input type="text" class="form-control" v-model="searchKeyword" placeholder="输入卡密关键词">
  </div>
<button class="btn btn-primary ms-2" @click="search()">搜索</button>
  <div class="form-group">
    <label for="shangjiastatus">状态</label>
    <select class="form-control" v-model="statusFilter">
    <option value="">全部</option>
    <option value="0">未使用</option>
    <option value="1">已使用</option>
    </select>
  </div>
  <button class="btn btn-primary" @click="filterByStatus()">查询</button>
<button class="btn btn-primary px-4 me-2" data-toggle="modal" data-target="#modal-add">添加卡密</button>
<button class="btn btn-primary px-4 me-2" @click="daochu()">导出选中</button>
<button class="btn btn-danger px-4" @click="deleteSelected()">删除选中</button>
  <div class="form-group ms-3">
    <label for="pageSizeSelect">每页显示数量</label>
    <select class="form-control" v-model="pageSize" @change="changePageSize">
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="50">50</option>
    </select>
  </div>
</div>

        </div>
        <div class="table-responsive">
          <table class="table mb-0">
            <thead>
              <tr>
                <th scope="col"><input type="checkbox" @change="checkAll($event)"></th>
                <th scope="col">ID</th>
                <th scope="col">卡号</th>
                <th scope="col">卡密金额</th>
                <th scope="col">使用者ID</th>
                <th scope="col">添加时间</th>
                <th scope="col">使用时间</th>
                <th scope="col">状态</th>
                <th scope="col">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="res in filteredData">
                <td><input type="checkbox" v-model="selectedIds" :value="res.id"></td>
                <td>{{res.id}}</td>
                <td>{{res.content}}</td>
                <td>{{res.money}}</td>
                <td>{{res.uid}}</td>
                <td>{{res.addtime}}</td>
                <td>{{res.usedtime}}</td>
                <td><span class="btn btn-success" v-if="res.status==1">已使用</span><span class="btn btn-danger" v-else-if="res.status==0">未使用</span></td>
                <td>
                  <a href="javascript:void(0);" class="btn btn-danger btn-action" @click="del(res.id)">删除</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
              <a class="page-link" href="#" @click.prevent="prevPage" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
              </a>
            </li>
            <!-- 显示页码范围 -->
            <li v-if="currentPage > 2" class="page-item">
              <a class="page-link" href="#" @click.prevent="get(1)">1</a>
            </li>
            <li v-if="currentPage > 3" class="page-item">
              <span class="page-link">...</span>
            </li>
            <li v-for="page in pageRange" :key="page" class="page-item" :class="{ active: page === currentPage }">
              <a class="page-link" href="#" @click.prevent="get(page)">{{ page }}</a>
            </li>
            <li v-if="currentPage < totalPages - 2" class="page-item">
              <span class="page-link">...</span>
            </li>
            <li v-if="currentPage < totalPages - 1" class="page-item">
              <a class="page-link" href="#" @click.prevent="get(totalPages)">{{ totalPages }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === totalPages }">
              <a class="page-link" href="#" @click.prevent="nextPage" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
  <div class="modal fade primary" id="modal-add">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">生成卡密</h4>
        </div>

        <div class="modal-body">
          <form class="form-horizontal" id="form-add">
            <input type="hidden" name="action" value="add"/>
            <div class="form-group">
              <label class="col-sm-3 control-label">添加卡密</label>
              <div class="col-sm-9">
                <input type="text" v-model="addm.num" class="form-control" placeholder="请输入卡密数量">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">卡密金额</label>
              <div class="col-sm-9">
                <input type="text" v-model="addm.money" class="form-control" placeholder="请输入卡密金额">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">自定义前缀</label>
              <div class="col-sm-9">
                <input type="text" v-model="addm.prefix" class="form-control" placeholder="请输入自定义卡密前缀">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">取消</button>
          <button type="button" class="btn btn-success" data-dismiss="modal" @click="add()">确定</button>
        </div>
      </div>
    </div>
  </div>

<?php require_once("footer.php");?>	
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
<script>
const cardVm = new Vue({
  el: '#card',
  data: {
    row: {},
    addm: {
      num: '',
      money: '',
      prefix: ''
    },
    selectedIds: [],
    searchKeyword: '',
    statusFilter: '',
    filteredData: [],
    currentPage: 1,
    pageSize: 15,
    totalPages: 1
  },
  computed: {
    // 计算显示的页码范围
    pageRange() {
      let start = Math.max(this.currentPage - 2, 1);
      let end = Math.min(start + 4, this.totalPages);
      if (end - start < 4) {
        start = Math.max(end - 4, 1);
      }
      return Array.from({ length: end - start + 1 }, (_, i) => start + i);
    }
  },
  methods: {
    get: function (page = 1) {
      this.$http.post(`/km.php?act=kmlist&page=${page}&pageSize=${this.pageSize}&keyword=${this.searchKeyword}&status=${this.statusFilter}`).then(function (data) {
        if (data.data.code == 1) {
          this.row = data.body;
          this.filteredData = this.row.data;
          this.totalPages = Math.ceil(this.row.total / this.pageSize);
          this.currentPage = page; // 更新当前页码
          this.$nextTick(function () {
            $('.preloader').fadeOut('slow')
          })
        } else {
          iziToast.error({
            title: data.data.msg,
            position: 'topRight',
          })
        }
      }.bind(this))
    },
    add: function () {
      function generateComplexKey() {
        const totalLength = 18; 
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let key = '';
        for (let i = 0; i < totalLength; i++) {
          const randomIndex = Math.floor(Math.random() * characters.length);
          key += characters.charAt(randomIndex);
        }
        return key; 
      }

      for (let i = 0; i < this.addm.num; i++) {
        var load = layer.load(2);
        let content = generateComplexKey();
        if (this.addm.prefix) {
          content = this.addm.prefix + '_' + content;
        }
        this.$http
          .post(
            '/km.php?act=addkm',
            { content: content, money: this.addm.money, batch_id: this.addm.batch_id },
            { emulateJSON: true }
          )
          .then((response) => {
            layer.close(load);
            if (response.data.code == 1) {
              $('#modal-add').modal('hide');
              cardVm.get();
              layer.msg(response.data.msg, { icon: 1, time: 2000, offset: 't' });
            } else {
              layer.msg(response.data.msg, { icon: 2, time: 2000, offset: 't' });
            }
          }, (error) => {
            layer.close(load);
            layer.msg('发生错误，请稍后再试', { icon: 2, time: 2000, offset: 't' });
          });
      }
    },
    del: function (id) {
      layer.open({
        content: '您确定要删除该卡密吗？',
        title: '谨慎操作',
        icon: 3,
        btn: ['确认', '关闭'],
        yes: function (index, layero) {
          var load = layer.load(2);
          cardVm.$http
            .post('/km.php?act=deletekm', { id: id }, { emulateJSON: true })
            .then(function (data) {
              layer.close(load);
              if (data.data.code == 1) {
                cardVm.get();
                layer.close(index);
                layer.msg(data.data.msg, { icon: 1, time: 2000, offset: 'auto' });
              } else {
                layer.msg(data.data.msg, { icon: 2, time: 2000, offset: 't' });
              }
            });
        }
      });
    },
    checkAll: function (event) {
      if (event.target.checked) {
        this.selectedIds = this.filteredData.map(item => item.id);
      } else {
        this.selectedIds = [];
      }
    },
    deleteSelected: function () {
      if (this.selectedIds.length === 0) {
        layer.msg('请选择要删除的卡密', { icon: 2, time: 2000, offset: 't' });
        return;
      }
      layer.open({
        content: '您确定要删除选中的卡密吗？',
        icon: 3,
        title: '谨慎操作',
        btn: ['确认', '关闭'],
        yes: function (index, layero) {
          var load = layer.load(2);
          cardVm.$http
            .post('/km.php?act=deleteSelectedKm', { ids: cardVm.selectedIds }, { emulateJSON: true })
            .then(function (data) {
              layer.close(load);
              if (data.data.code == 1) {
                cardVm.get();
                cardVm.selectedIds = [];
                layer.close(index);
                layer.msg(data.data.msg, { icon: 1, time: 2000, offset: 'auto' });
              } else {
                layer.msg(data.data.msg, { icon: 2, time: 2000, offset: 't' });
              }
            });
        }
      });
    },
    daochu() {
      if (this.selectedIds.length === 0) {
        layer.msg("请先选择卡密", { icon: 2 });
        return;
      }
      let exportContent = "";
      this.selectedIds.forEach((id) => {
        let row = this.filteredData.find((item) => item.id === id);
        if (row) {
          exportContent += `${row.content}\n`;
        }
      });
      layer.open({
        type: 1,
        title: '导出卡密',
        content: `
            <div class="export-container" style="display: flex; flex-direction: column; height: 100%;">
                <pre id="export-content" style="flex: 1; overflow-y: auto; width: 100%; text-align: center; margin: 0; white-space: pre-wrap;">${exportContent}</pre>
                <div class="button-container" style="padding: 10px; background-color: white; text-align: center;">
                    <button class="btn btn-primary" id="copy-btn" data-clipboard-target="#export-content">一键复制</button>
                    &nbsp; &nbsp; <button class="btn btn-success" id="download-btn">下载 TXT</button>
                </div>
            </div>
        `,
        area: ['250px', '400px'],
        btn: [],
        closeBtn: 1,
        success: function (layero, index) {
          const clipboard = new ClipboardJS('#copy-btn');
          clipboard.on('success', function (e) {
            layer.msg('已成功复制到剪贴板', { icon: 1, time: 2000, offset: 'auto' });
            e.clearSelection();
          });
          $('#download-btn').on('click', function () {
            const blob = new Blob([exportContent], { type: 'text/plain;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = '卡密.txt';
            a.click();
            URL.revokeObjectURL(url);
          });
        }
      });
    },
    delSelected() {
      if (this.selectedIds.length === 0) {
        layer.msg("请先选择卡密", { icon: 2 });
        return;
      }
      this.selectedIds.forEach((id) => {
        this.del(id);
      });
    },
    search() {
      this.get(1); // 搜索时回到第一页
    },
    filterByStatus() {
      this.get(1); // 筛选状态时回到第一页
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
        this.get(this.currentPage);
      }
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
        this.get(this.currentPage);
      }
    },
    changePageSize() {
      this.get(1); // 更改每页显示数量后回到第一页
    }
  },
  created() {
    this.get()
  },
})
</script>    
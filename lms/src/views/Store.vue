<template>
  <div class="store">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>图书管理</span>
        <div style="float: right">
          <!-- 关键字搜索 -->
          <el-input
            v-model="search"
            @input="showSearch()"
            size="mini"
            style="width: 200px"
            suffix-icon="el-icon-search"
            placeholder="输入关键字搜索"
          ></el-input>

          <!-- 图书入库 -->
          <!-- 名称、总量 -->
          <el-button
            type="success"
            style="margin-left: 10px"
            size="mini"
            @click="create = true"
            >添加</el-button
          >
          <el-dialog title="图书入库" :visible.sync="create" width="400px">
            <el-form ref="createForm" :model="createForm" label-width="100px">
              <el-form-item label="名称: ">
                <el-autocomplete
                  v-model="createForm.name"
                  style="width: 200px"
                  :fetch-suggestions="querySearch"
                  placeholder="请输入书名"
                  @select="getBookId"
                ></el-autocomplete>
              </el-form-item>
              <el-form-item label="总量: ">
                <el-input
                  v-model="createForm.total"
                  style="width: 200px"
                ></el-input>
              </el-form-item>
            </el-form>

            <div slot="footer" class="dialog-footer" align="center">
              <el-button type="success" @click="createStore()">提 交</el-button>
              <el-button @click="create = false">取 消</el-button>
            </div>
          </el-dialog>
        </div>
      </div>
      <div>
        <template>
          <!-- id、名称、总量、已借数量 -->
          <el-table stripe :data="tableData" style="width: 100%">
            <el-table-column
              label="id"
              prop="id"
              align="center"
            ></el-table-column>
            <el-table-column
              label="名称"
              prop="name"
              align="center"
            ></el-table-column>
            <el-table-column
              label="总量"
              prop="total"
              align="center"
            ></el-table-column>
            <el-table-column
              label="库存"
              prop="current"
              align="center"
            ></el-table-column>
             <el-table-column
              label="书架位置"
              prop="position"
              align="center"
            ></el-table-column>
            <el-table-column
              fixed="right"
              label="操作"
              width="150px"
              align="center"
            >
              <template slot-scope="scope">
                <el-button
                  @click="
                    detailMsg = true;
                    editForm = { ...scope.row };
                  "
                  size="small"
                  type="primary"
                  >编辑</el-button
                >
                <el-popover
                  style="padding-left: 10px"
                  placement="top"
                  width="160"
                  :ref="scope.$index"
                >
                  <p>确定删除该条数据吗？</p>
                  <div style="text-align: right; margin: 0">
                    <el-button
                      size="mini"
                      type="text"
                      @click="scope._self.$refs[scope.$index].doClose()"
                      >取消</el-button
                    >
                    <el-button
                      type="primary"
                      size="mini"
                      @click="
                        scope._self.$refs[scope.$index].doClose();
                        del(scope.row);
                      "
                      >确定</el-button
                    >
                  </div>
                  <el-button slot="reference" type="danger" size="mini"
                    >删除</el-button
                  >
                </el-popover>
              </template>
            </el-table-column>
          </el-table>

          <el-dialog title="编辑信息" :visible.sync="detailMsg" width="500px">
            <template v-if="editForm !== null">
              <el-form ref="editForm" :model="editForm" label-width="120px">
                <el-form-item label="id: ">
                  <span>{{ editForm.id }}</span>
                </el-form-item>
                <el-form-item label="名称: ">
                  <span>{{ editForm.name }}</span>
                </el-form-item>
                <el-form-item label="总量: ">
                  <el-input
                    v-model="editForm.total"
                    style="width: 250px"
                  ></el-input>
                </el-form-item>
                <el-form-item label="库存: ">
                  <el-input
                    v-model="editForm.current"
                    style="width: 250px"
                  ></el-input>
                </el-form-item>
              </el-form>
            </template>
            <div slot="footer" class="dialog-footer" align="center">
              <el-button type="primary" @click="edit">提 交</el-button>
              <el-button @click="detailMsg = false">关 闭</el-button>
            </div>
          </el-dialog>
        </template>
      </div>
      <div class="block" align="center">
        <el-pagination
          layout="prev, pager, next"
          :page-count="maxPage"
          @current-change="currentChange"
          :current-page.sync="currentPage"
          style="padding-top: 20px"
        ></el-pagination>
      </div>
    </el-card>
  </div>
</template>
<script>
import qs from "qs";
export default {
  data() {
    return {
      search: "",
      searchTitle: "",
      bookTitle: null,
      create: false,
      currentPage: 1,
      pageSize: 10,
      maxPage: null,
      detailMsg: false,
      responseType: 'blob',
      createForm: {
        id: "",
        name: "",
        total: "",
      },
      tableData: null,
      editForm: null,
      bookList: [],
    };
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      let _this = this;
      this.$axios
        .get(
          "http://localhost/lms_api/getStoreInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize
        )
        .then(function (data) {
          // console.log(data.data[0].data);
          _this.tableData = data.data[0].data; // 返回的数据
          _this.maxPage = data.data[0].total; // 返回的页数
        });
    },
    // 获取当前页码的数据
    currentChange(currentPage) {
      this.currentPage = currentPage;
      let _this = this;
      this.$axios
        .get(
          "http://localhost/lms_api/getStoreInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize +
            "&search=" +
            _this.search
        )
        .then(function (data) {
          _this.tableData = data.data[0].data; // 返回的数据
        })
        .catch((err) => {
          console.log(err);
        });
    },
    showSearch() {
      let _this = this;
      this.currentPage = 1;
      this.$axios
        .get(
          "http://localhost/lms_api/getStoreInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize +
            "&search=" +
            _this.search
        )
        .then(function (data) {
          _this.tableData = data.data[0].data;
          _this.maxPage = data.data[0].total; // 返回的页数
        });
    },
    edit() {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/editStoreInfo.php",
          qs.stringify({
            id: _this.editForm.id,
            total: _this.editForm.total,
            current: _this.editForm.current,
          })
        )
        .then((res) => {
          if (res.data === "success") {
            _this.$message.success("修改成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            console.log("修改失败");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    del(row) {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/delStore.php",
          qs.stringify({
            id: row.id,
          })
        )
        .then((res) => {
          if (res.data === "success") {
            _this.$message.success("删除书籍成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            console.log("删除书籍失败");
          }
        });
    },
    querySearch(queryString, cb) {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/getBookTitle.php",
          qs.stringify({
            name: queryString,
          })
        )
        .then((res) => {
          if (res.data.length) {
            for (var i = 0; i < res.data.length; i++) {
              res.data[i].value = res.data[i].name;
            }
            cb(res.data);
          } else {
            cb([]);
          }
        });
    },
    getBookTitle() {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/getBookTitle.php",
          qs.stringify({
            name: _this.searchTitle,
          })
        )
        .then((res) => {
          // console.log(res.data);
          if (res.data.length) {
            for (var i = 0; i < res.data.length; i++) {
              res.data[i].value = res.data[i].name;
            }
            cb(res.data);
          } else {
            cb([]);
          }
        });
    },
    getBookId(item) {
      this.createForm.id = item.id;
      // console.log(this.createForm);
    },
    createStore() {
      // console.log(this.createForm);
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/createStore.php",
          qs.stringify({
            id: _this.createForm.id,
            name: _this.createForm.name,
            total: _this.createForm.total,
          })
        )
        .then((res) => {
          // console.log(res.data);
          if (res.data === "success") {
            _this.$message.success("图书入库成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else if (res.data === "existed") {
            _this.$message.warning("已存在该记录", 500);
          } else if (res.data === "failed") {
            _this.$message.error("图书入库失败", 500);
          }
        });
    },
  },
};
</script>
<style scoped>
.el-form-item span {
  padding-left: 15px;
}
</style>
<template>
  <div class="borrow">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>图书借阅</span>
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

          <!-- 新增借阅 -->
          <!-- 用户名username、书名bookname、借阅时间borrowdate、应归还时间shouldreturndate -->
          <el-button
            type="success"
            style="margin-left: 10px"
            size="mini"
            @click="create = true"
            >添加</el-button
          >
          <el-dialog title="新增借阅信息" :visible.sync="create" width="400px">
            <el-form ref="createForm" :model="createForm" label-width="100px">
              <el-form-item label="用户名: ">
                <el-input
                  v-model="createForm.username"
                  style="width: 200px"
                ></el-input>
              </el-form-item>
              <el-form-item label="书名: ">
                <el-autocomplete
                  v-model="createForm.bookname"
                  style="width: 200px"
                  :fetch-suggestions="querySearch"
                  placeholder="请输入书名"
                  @select="getBookId"
                ></el-autocomplete>
                <!-- <el-input v-model="createForm.bookname" style="width: 200px"></el-input> -->
              </el-form-item>
              <el-form-item label="借阅时间: ">
                <!-- <el-input v-model="createForm.borrowdate" style="width: 200px"></el-input> -->
                <el-date-picker
                  v-model="createForm.borrow_date"
                  type="date"
                  :editable="false"
                  placeholder="选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                  style="width: 200px"
                ></el-date-picker>
              </el-form-item>
              <el-form-item label="归还时间: ">
                <el-date-picker
                  v-model="createForm.should_return_date"
                  type="date"
                  :editable="false"
                  placeholder="选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                  style="width: 200px"
                ></el-date-picker>
              </el-form-item>
            </el-form>

            <div slot="footer" class="dialog-footer" align="center">
              <el-button type="success" @click="createBorrow()"
                >提 交</el-button
              >
              <el-button @click="create = false">取 消</el-button>
            </div>
          </el-dialog>
        </div>
      </div>
      <div>
        <template>
          <!-- 用户名username、书名bookname、借阅时间borrowdate、应归还时间shouldreturndate -->
          <el-table
            :data="tableData"
            style="width: 100%"
            :row-class-name="isOutOfDate"
          >
            <el-table-column
              label="id"
              prop="id"
              align="center"
            ></el-table-column>
            <el-table-column
              label="用户名"
              prop="username"
              align="center"
            ></el-table-column>
            <el-table-column
              label="书名"
              prop="bookname"
              align="center"
            ></el-table-column>
            <el-table-column
              label="借阅时间"
              prop="borrow_date"
              align="center"
            ></el-table-column>
            <el-table-column
              label="应归还时间"
              prop="should_return_date"
              align="center"
            ></el-table-column>
            <el-table-column
              fixed="right"
              label="操作"
              width="150px"
              align="center"
            >
              <template slot-scope="scope">
                <!-- <el-button size="mini">编辑</el-button> -->
                <el-button
                  @click="
                    editMsg = true;
                    editForm = { ...scope.row };
                  "
                  size="mini"
                  type="primary"
                  >修改</el-button
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
                <!-- <el-button size="small" type="danger">删除</el-button> -->
              </template>
            </el-table-column>
          </el-table>

          <el-dialog title="编辑借阅信息" :visible.sync="editMsg" width="500px">
            <template v-if="editForm !== null">
              <el-form ref="editForm" :model="editForm" label-width="150px">
                <el-form-item label="id: ">
                  <span>{{ editForm.id }}</span>
                </el-form-item>
                <el-form-item label="用户名: ">
                  <el-input
                    v-model="editForm.username"
                    style="width: 200px"
                  ></el-input>
                </el-form-item>
                <el-form-item label="书名: ">
                  <el-autocomplete
                    v-model="editForm.bookname"
                    style="width: 200px"
                    :fetch-suggestions="querySearch"
                    placeholder="请输入书名"
                    @select="getBookId"
                  ></el-autocomplete>
                </el-form-item>
                <el-form-item label="借阅时间: ">
                  <el-date-picker
                    v-model="editForm.borrow_date"
                    type="date"
                    :editable="false"
                    placeholder="选择日期"
                    format="yyyy 年 MM 月 dd 日"
                    value-format="yyyy-MM-dd"
                    style="width: 200px"
                  ></el-date-picker>
                </el-form-item>
                <el-form-item label="应归还时间: ">
                  <el-date-picker
                    v-model="editForm.should_return_date"
                    type="date"
                    :editable="false"
                    placeholder="选择日期"
                    format="yyyy 年 MM 月 dd 日"
                    value-format="yyyy-MM-dd"
                    style="width: 200px"
                  ></el-date-picker>
                </el-form-item>
              </el-form>
            </template>
            <div slot="footer" class="dialog-footer" align="center">
              <el-button type="success" @click="revert()">归 还</el-button>
              <el-button type="primary" @click="edit()">提 交</el-button>
              <el-button @click="editMsg = false">关 闭</el-button>
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
      create: false,
      currentPage: 1,
      pageSize: 10,
      maxPage: null,
      editMsg: false,
      editForm: null,
      createForm: {
        username: "",
        bookname: "",
        borrow_date: "",
        should_return_date: "",
      },
      tableData: null,
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
          "http://localhost/lms_api/getBorrowInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize
        )
        .then(function (data) {
          // console.log(data.data);
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
          "http://localhost/lms_api/getBorrowInfo.php?currentPage=" +
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
    // 关键字检索
    showSearch() {
      let _this = this;
      this.currentPage = 1;
      this.$axios
        .get(
          "http://localhost/lms_api/getBorrowInfo.php?currentPage=" +
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
    // cleanCreate() {
    //   this.username = "";
    //   this.name = "";
    //   this.telephone = "";
    //   this.maxborrow = null;
    //   this.sex = "";
    //   this.age = null;
    // },
    // 编辑信息
    // 用户名要存在
    // 书名要存在
    // 借阅时间不能比当前日期晚
    edit() {
      let _this = this;
      // console.log(this.editForm);
      this.$axios
        .post(
          "http://localhost/lms_api/editBorrow.php",
          qs.stringify({
            id: _this.editForm.id,
            username: _this.editForm.username,
            bookname: _this.editForm.bookname,
            borrow_date: _this.editForm.borrow_date,
            should_return_date: _this.editForm.should_return_date,
          })
        )
        .then(function (data) {
          if (data.data === "success") {
            _this.$message.success("编辑信息成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else if (data.data === "no user or no book") {
            _this.$message.error("请检查该用户/书籍是否存在");
            // setTimeout(() => {
            //   window.location.reload();
            // }, 500);
          } else {
            console.log("编辑信息失败");
          }
        });
    },
    revert() {
      // console.log(this.editForm);
      var date = new Date();
      var year = date.getFullYear();
      var month = date.getMonth() + 1;
      var date = date.getDate();
      if (month < 10) {
        month = "0" + month;
      }
      var today = year + "-" + month + "-" + date;
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/revertBook.php",
          qs.stringify({
            id: _this.editForm.id,
            username: _this.editForm.username,
            bookname: _this.editForm.bookname,
            borrow_date: _this.editForm.borrow_date,
            should_return_date: _this.editForm.should_return_date,
            actual_return_date: today,
          })
        )
        .then(function (data) {
          console.log(data);
          if (data.data === "success") {
            _this.$message.success("编辑信息成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            console.log("编辑信息失败");
          }
        });
    },
    // 是否过期
    // 1. 今天日期 > 应归还日期 => 已过期
    // 2. 今天日期 <= 应归还日期 => 未过期
    isOutOfDate({ row, rowIndex }) {
      row.index = rowIndex;
      // 今天的日期
      var today = new Date();
      // 应该归还的日期
      var sDate = new Date(row.should_return_date);
      if (today.getTime() > sDate.getTime()) {
        return "danger-row";
      } else {
        return "success-row";
      }
    },
    // 删除记录
    del(row) {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/delBorrow.php",
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
    getBookId(item) {
      this.createForm.id = item.id;
      // console.log(this.createForm);
    },
    createBorrow() {
      // console.log(this.createForm);
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/createBorrow.php",
          qs.stringify({
            username: _this.createForm.username,
            bookname: _this.createForm.bookname,
            borrow_date: _this.createForm.borrow_date,
            should_return_date: _this.createForm.should_return_date,
          })
        )
        .then((res) => {
          // console.log(res.data);
          if (res.data === "success") {
            _this.$message.success("创建借阅记录成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else if (res.data === "no user or no book") {
            _this.$message.warning("请检查该用户/书籍是否存在", 500);
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
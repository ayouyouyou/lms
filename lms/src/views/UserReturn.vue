<template>
  <div class="return">
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
          <!-- 新增归还记录 -->
          <!-- 用户名username、书名bookname、借阅时间borrow_date、应归还时间should_return_date、实归还时间actual_return_date -->       
          <!-- <el-input v-model="createForm.borrowdate" style="width: 200px"></el-input> -->
        </div>
      </div>
      <div>
        <template>
          <!-- 用户名username、书名bookname、借阅时间borrow_date、应归还时间should_return_date、实归还时间actual_return_date -->
          <el-table
            :data="tableDataFilter"
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
              label="实归还时间"
              prop="actual_return_date"
              align="center"
            ></el-table-column>
      
              
          </el-table>

       
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
      user: null,
      search: "",
      create: false,
      currentPage: 1,
      pageSize: 10,
      maxPage: null,
      editForm: null,
      createForm: {
        username: "",
        bookname: "",
        borrow_date: "",
        should_return_date: "",
        actual_return_date: "",
      },
      editMsg: false,
      tableData: null,
      tableDataFilter:null,
    };
  },
  created() {
    this.getList();
    this.showSession();
  },
  methods: {
    getList() {
      let _this = this;
      this.$axios
        .get(
          "http://localhost/lms_api/getRevertInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize
        )
        .then(function (data) {
          // console.log(data.data);
          _this.tableData = data.data[0].data; // 返回的数据
           _this.maxPage = data.data[0].total; // 返回的页数

          console.log(data)
          // 筛选数据
           _this.tableDataFilter=_this.tableData.filter(item=>item.username==_this.user.username)
          console.log(_this.tableDataFilter);

         
        });
    },
    // 获取当前页码的数据
    currentChange(currentPage) {
      this.currentPage = currentPage;
      let _this = this;
      this.$axios
        .get(
          "http://localhost/lms_api/getRevertInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize +
            "&search=" +
            _this.search
        )
        .then(function (data) {
          _this.tableData = data.data[0].data; // 返回的数据

               // 筛选数据
           _this.tableDataFilter=_this.tableData.filter(item=>item.username==_this.user.username)
        })
        .catch((err) => {
          console.log(err);
        });
    },
    showSearch() {
      // console.log(this.search);
      let _this = this;
      this.currentPage = 1;
      this.$axios
        .get(
          "http://localhost/lms_api/getRevertInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize +
            "&search=" +
            _this.search
        )
        .then(function (data) {
          _this.tableData = data.data[0].data;
          _this.maxPage = data.data[0].total; // 返回的页数

               // 筛选数据
           _this.tableDataFilter=_this.tableData.filter(item=>item.username==_this.user.username)

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
          "http://localhost/lms_api/editRevert.php",
          qs.stringify({
            id: _this.editForm.id,
            username: _this.editForm.username,
            bookname: _this.editForm.bookname,
            borrow_date: _this.editForm.borrow_date,
            should_return_date: _this.editForm.should_return_date,
            actual_return_date: _this.editForm.actual_return_date,
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
    // 是否过期
    // 1. 应归还日期 >= 实际归还日期 => 未过期
    // 2. 应归还日期 < 实际归还日期 => 已过期
    isOutOfDate({ row, rowIndex }) {
      row.index = rowIndex;
      // 应归还日期
      var sDate = new Date(row.should_return_date);

      // 实际归还日期
      var aDate = new Date(row.actual_return_date);

      if (sDate.getTime() >= aDate.getTime()) {
        return "success-row";
      } else {
        return "danger-row";
      }
    },
    // 删除记录
    del(row) {
      // console.log(row.id);
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/delRevert.php",
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
    createRevert() {
      // console.log(this.createForm);
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/createRevert.php",
          qs.stringify({
            username: _this.createForm.username,
            bookname: _this.createForm.bookname,
            borrow_date: _this.createForm.borrow_date,
            should_return_date: _this.createForm.should_return_date,
            actual_return_date: _this.createForm.actual_return_date,
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
// 获取用户信息
  showSession() {
      this.user = JSON.parse(window.sessionStorage.getItem("User"));
      console.log(this.user.username);
    },
  },
};
</script>

<style scoped>
</style>
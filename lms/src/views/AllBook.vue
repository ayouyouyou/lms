<template>
  <div class="book">
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

        </div>
      </div>
      <div>
        <template>
          <!-- 表格信息 -->
          <el-table stripe :data="tableData" style="width: 100%">
            <el-table-column label="id" prop="id" align="center"></el-table-column>
            <el-table-column label="名称" prop="name" align="center"></el-table-column>
            <el-table-column label="作者" prop="author" align="center"></el-table-column>
            <el-table-column label="出版商" prop="publisher" align="center"></el-table-column>
            <el-table-column label="出版日期" prop="publish_date" align="center"></el-table-column>
            <el-table-column label="书架位置" prop="position" align="center"></el-table-column>
            <el-table-column label="标签" prop="tag" width="150px" align="center">
              <template slot-scope="scope">
                <el-tag v-for="item in scope.row.tag" :key="item" size="small">{{item}}</el-tag>
              </template>
            </el-table-column>
          
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
      // 输入新标签
      tagInput: false,
      // 新标签开启编辑模式
      inputVisible: false,
      // 新标签输入值
      inputValue: "",
      // 搜索
      search: "",
      // 是否显示创建页面
      create: false,
      currentPage: 1,
      pageSize: 10,
      maxPage: null,
      // 详细信息
      detailMsg: false,
      // 表格数据
      tableData: null,
      editForm: {
        id: "",
        name: "",
        author: "",
        publisher: "",
        publish_date: "",
        position:"",
        tag: "",
      },
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
          "http://localhost/lms_api/getBookInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize
        )
        .then(function (data) {
          _this.tableData = data.data[0].data; // 返回的数据
          _this.maxPage = data.data[0].total; // 返回的页数
          // 解析标签
                 console.log(_this.tableData);
          for (let i = 0; i < _this.tableData.length; i++) {
            _this.tableData[i].tag = _this.tableData[i].tag.split(" ");
          }
        });
    },
    // 获取当前页码的数据
    currentChange(currentPage) {
      this.currentPage = currentPage;
      let _this = this;
      this.$axios
        .get(
          "http://localhost/lms_api/getBookInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize +
            "&search=" +
            _this.search
        )
        .then(function (data) {
          _this.tableData = data.data[0].data; // 返回的数据
          // 解析标签
          for (let i = 0; i < _this.tableData.length; i++) {
            _this.tableData[i].tag = _this.tableData[i].tag.split(" ");
          }
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
          "http://localhost/lms_api/getBookInfo.php?currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize +
            "&search=" +
            _this.search
        )
        .then(function (data) {
          _this.tableData = data.data[0].data;
          if (data.data[0].data !== undefined) {
            for (let i = 0; i < _this.tableData.length; i++) {
              _this.tableData[i].tag = _this.tableData[i].tag.split(" ");
            }
          }
          _this.maxPage = data.data[0].total; // 返回的页数
        });
    },
    // ===创建表单标签===
    // 关闭标签
    closeCreateTag(tag) {
      this.createForm.tag.splice(this.createForm.tag.indexOf(tag), 1);
    },

    // ===编辑表单标签===
    // 关闭标签
    closeEditTag(rowData, tag) {
      rowData.tag.splice(rowData.tag.indexOf(tag), 1);
    },

    // ===公共方法===
    showInput() {
      this.inputVisible = true;
      this.$nextTick((_) => {
        this.$refs.saveTagInput.$refs.input.focus();
      });
    },
  },
};
</script>
<style scoped>
.el-tag {
  margin: 2px 2px;
}
.button-new-tag {
  margin-left: 10px;
  height: 32px;
  line-height: 30px;
  padding-top: 0;
  padding-bottom: 0;
}
.input-new-tag {
  width: 90px;
  margin-left: 10px;
  vertical-align: bottom;
}
.el-form-item span {
  padding-left: 15px;
}
</style>
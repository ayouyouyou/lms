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

          <!-- 新增书刊 -->
          <!-- id、名称、作者、出版商、书架位置、标签 -->
          <el-button type="success" style="margin-left: 10px" size="mini" @click="create = true">添加</el-button>
          <el-dialog title="新增书刊" :visible.sync="create" width="400px">
            <el-form ref="createForm" :model="createForm" label-width="100px">
              <el-form-item label="名称: ">
                <el-input v-model="createForm.name" style="width: 200px" placeholder="请输入名称"></el-input>
              </el-form-item>
              <el-form-item label="作者: ">
                <el-input v-model="createForm.author" style="width: 200px" placeholder="请输入作者"></el-input>
              </el-form-item>
              <el-form-item label="出版商: ">
                <el-input v-model="createForm.publisher" style="width: 200px" placeholder="请输入出版商"></el-input>
              </el-form-item>
              <el-form-item label="出版日期: ">
                <el-date-picker
                  v-model="createForm.publish_date"
                  type="date"
                  :editable="false"
                  placeholder="请选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                  style="width: 200px"
                ></el-date-picker>
              </el-form-item>
              <el-form-item label="书架位置: ">
                <el-input v-model="createForm.position" style="width: 200px" placeholder="请输入书架位置"></el-input>
              </el-form-item>
              <el-form-item label="标签: ">
                <el-tag
                  v-for="item in createForm.tag"
                  :key="item"
                  closable
                  :disable-transitions="false"
                  @close="closeCreateTag(item)"
                >{{item}}</el-tag>
                <el-input
                  class="input-new-tag"
                  v-if="inputVisible"
                  v-model="inputValue"
                  ref="saveTagInput"
                  size="small"
                  @keyup.enter.native="createTagInCreate()"
                  @blur="createTagInCreate()"
                ></el-input>
                <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
                <!-- <el-input v-model="createForm.tag" style="width: 200px" placeholder="请输入标签"></el-input> -->
              </el-form-item>
            </el-form>

            <div slot="footer" class="dialog-footer" align="center">
              <el-button type="success" @click="createBook">提 交</el-button>
              <el-button @click="create = false">取 消</el-button>
            </div>
          </el-dialog>
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
            <el-table-column fixed="right" label="操作" width="150px" align="center">
              <template slot-scope="scope">
                <el-button
                  @click="detailMsg = true;editForm = { ...scope.row }"
                  size="small"
                  type="primary"
                >编辑</el-button>
                <!-- 删除用户 -->
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
                    >取消</el-button>
                    <el-button
                      type="primary"
                      size="mini"
                      @click="scope._self.$refs[scope.$index].doClose();del(scope.row)"
                    >确定</el-button>
                  </div>
                  <el-button slot="reference" type="danger" size="mini">删除</el-button>
                </el-popover>
                <!-- <el-button size="small" type="danger">删除</el-button> -->
              </template>
            </el-table-column>
          </el-table>

          <el-dialog title="编辑信息" :visible.sync="detailMsg" width="500px">
            <template v-if="editForm !== null">
              <el-form ref="editForm" :model="editForm" label-width="120px">
                <el-form-item label="id: ">
                  <span>{{editForm.id}}</span>
                  <!-- <el-input v-model="editForm.id" style="width: 150px"></el-input> -->
                </el-form-item>
                <el-form-item label="名称: ">
                  <el-input v-model="editForm.name" style="width: 250px"></el-input>
                </el-form-item>
                <el-form-item label="作者: ">
                  <el-input v-model="editForm.author" style="width: 250px"></el-input>
                </el-form-item>
                <el-form-item label="出版商: ">
                  <el-input v-model="editForm.publisher" style="width: 250px"></el-input>
                </el-form-item>
                <el-form-item label="出版日期: ">
                  <el-date-picker
                    v-model="editForm.publish_date"
                    type="date"
                    :editable="false"
                    placeholder="选择日期"
                    format="yyyy 年 MM 月 dd 日"
                    value-format="yyyy-MM-dd"
                    style="width: 200px"
                  ></el-date-picker>
                </el-form-item>
                <el-form-item label="书架位置: ">
                  <el-input v-model="editForm.position" style="width: 250px"></el-input>
                </el-form-item>
                <el-form-item label="标签: ">
                  <el-tag
                    v-for="item in editForm.tag"
                    :key="item"
                    closable
                    :disable-transitions="false"
                    @close="closeEditTag(editForm, item)"
                  >{{item}}</el-tag>
                  <el-input
                    class="input-new-tag"
                    v-if="inputVisible"
                    v-model="inputValue"
                    ref="saveTagInput"
                    size="small"
                    @keyup.enter.native="createTagInEdit(editForm)"
                    @blur="createTagInEdit(editForm)"
                  ></el-input>
                  <el-button v-else class="button-new-tag" size="small" @click="showInput">+ New Tag</el-button>
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
      // 创建表单
      createForm: {
        id: "",
        name: "",
        author: "",
        publisher: "",
        publish_date: "",
        position:"",
        tag: [],
      },
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
    // 新建书籍信息
    createBook() {
      // 标签转成字符串形式
      var createFormTag = "";
      // 检查一共有几个标签
      var tagCount = this.createForm.tag.length;
      if (tagCount > 1) {
        for (var i = 0; i < tagCount - 1; i++) {
          createFormTag = this.createForm.tag[i] + " ";
        }
        createFormTag = createFormTag + this.createForm.tag[i];
      } else {
        createFormTag = this.createForm.tag.toString();
      }

      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/createBook.php",
          qs.stringify({
            name: _this.createForm.name,
            author: _this.createForm.author,
            publisher: _this.createForm.publisher,
            publish_date: _this.createForm.publish_date,
            position:_this.createForm.position,
            tag: createFormTag,
          })
        )
        .then((res) => {
          if (res.data === "success") {
            _this.$message.success("新增书籍完成", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
            // console.log("新增成功");
          } else {
            console.log("新增失败");
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
          "http://localhost/lms_api/delBook.php",
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
    edit() {
      let _this = this;
      let saveTag = "";
      for (var i = 0; i < this.editForm.tag.length - 1; i++) {
        saveTag = saveTag + this.editForm.tag[i] + " ";
      }
      saveTag = saveTag + this.editForm.tag[i];
      this.$axios
        .post(
          "http://localhost/lms_api/editBookInfo.php",
          qs.stringify({
            id: _this.editForm.id,
            name: _this.editForm.name,
            author: _this.editForm.author,
            publisher: _this.editForm.publisher,
            publish_date: _this.editForm.publish_date,
            position:_this.createForm.position,
            tag: saveTag,
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
    // ===创建表单标签===
    // 关闭标签
    closeCreateTag(tag) {
      this.createForm.tag.splice(this.createForm.tag.indexOf(tag), 1);
    },
    // 创建标签
    createTagInCreate() {
      let inputValue = this.inputValue;
      if (inputValue) {
        this.createForm.tag.push(inputValue);
      }
      this.inputVisible = false;
      this.inputValue = "";
    },
    // ===编辑表单标签===
    // 关闭标签
    closeEditTag(rowData, tag) {
      rowData.tag.splice(rowData.tag.indexOf(tag), 1);
    },
    // 创建标签
    createTagInEdit(rowData) {
      var tagData = rowData.tag;
      let inputValue = this.inputValue;
      if (inputValue) {
        rowData.tag.push(inputValue);
      }
      // 上传数据 tagData
      tagData = tagData.toString().replace(/,/g, " ");
      // console.log(tagData);
      this.inputVisible = false;
      this.inputValue = "";
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
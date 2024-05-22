<template>
  <div class="student">
    <el-card class="box-card">
      <div slot="header" class="clearfix">
        <span>教师管理</span>
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

          <!-- 新增学生 -->
          <el-button
            type="success"
            style="margin-left: 10px"
            size="mini"
            @click="cleanInput();create = true"
          >添加</el-button>
          <el-dialog title="详细信息" :visible.sync="create" width="400px">
            <el-form ref="createForm" :model="createForm" label-width="120px">
              <el-form-item label="用户名: ">
                <el-input v-model="createForm.username" style="width: 200px" placeholder="请输入用户名"></el-input>
              </el-form-item>
              <el-form-item label="姓名: ">
                <el-input v-model="createForm.name" style="width: 200px" placeholder="请输入姓名"></el-input>
              </el-form-item>
              <el-form-item label="昵称: ">
                <el-input v-model="createForm.nickname" style="width: 200px" placeholder="请输入昵称"></el-input>
              </el-form-item>
              <el-form-item label="年龄: ">
                <el-input v-model="createForm.age" style="width: 200px" placeholder="请输入年龄"></el-input>
              </el-form-item>
              <el-form-item label="联系电话: ">
                <el-input v-model="createForm.telephone" style="width: 200px" placeholder="请输入电话"></el-input>
              </el-form-item>
              <el-form-item label="最大借书量: ">
                <el-input v-model="createForm.maxborrow" style="width: 200px" placeholder="请输入借书量"></el-input>
              </el-form-item>
              <el-form-item label="性别: ">
                <el-radio v-model="createForm.sex" label="男">男</el-radio>
                <el-radio v-model="createForm.sex" label="女">女</el-radio>
                <el-radio v-model="createForm.sex" label="保密">保密</el-radio>
              </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer" align="center">
              <el-button @click="createStudent()">提 交</el-button>
              <el-button @click="create = false">关 闭</el-button>
            </div>
          </el-dialog>
        </div>
      </div>
      <div>
        <template>
          <el-table stripe :data="tableData" style="width: 100%">
            <el-table-column type="expand">
              <template slot-scope="props">
                <el-form label-position="left" inline class="demo-table-expand">
                  <el-form-item label="用户名">
                    <span>{{ props.row.username }}</span>
                  </el-form-item>
                  <el-form-item label="昵称">
                    <span>{{ props.row.nickname }}</span>
                  </el-form-item>
                  <el-form-item label="姓名">
                    <span>{{ props.row.name }}</span>
                  </el-form-item>
                  <el-form-item label="联系电话">
                    <span>{{ props.row.telephone }}</span>
                  </el-form-item>
                  <el-form-item label="最大借书量">
                    <span>{{ props.row.maxborrow }}</span>
                  </el-form-item>
                  <el-form-item label="性别">
                    <span>{{ props.row.sex }}</span>
                  </el-form-item>
                  <el-form-item label="年龄">
                    <span>{{ props.row.age }}</span>
                  </el-form-item>
                </el-form>
              </template>
            </el-table-column>
            <el-table-column label="id" prop="id"></el-table-column>
            <el-table-column label="用户名" prop="username"></el-table-column>
            <el-table-column label="昵称" prop="nickname"></el-table-column>
            <el-table-column label="联系电话" prop="telephone"></el-table-column>
            <el-table-column label="借书量" prop="maxborrow"></el-table-column>
            <el-table-column fixed="right" label="操作" width="150px" align="center">
              <template slot-scope="scope">
                <el-button
                  @click="detailMsg = true;editForm = { ...scope.row };"
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

          <!-- id、姓名、年龄、性别、借书量、联系电话、操作 -->
          <!-- id、用户名、姓名、联系电话 -->
          <el-dialog title="详细信息" :visible.sync="detailMsg" width="400px">
            <template v-if="editForm !== null">
              <el-form ref="editForm" :model="editForm" label-width="120px">
                <el-form-item label="id: ">
                  <span>{{editForm.id}}</span>
                </el-form-item>
                <el-form-item label="用户名: ">
                  <span>{{editForm.username}}</span>
                </el-form-item>
                <el-form-item label="姓名: ">
                  <el-input v-model="editForm.name" style="width: 200px" placeholder="请输入姓名"></el-input>
                </el-form-item>
                <el-form-item label="昵称: ">
                  <el-input v-model="editForm.nickname" style="width: 200px" placeholder="请输入昵称"></el-input>
                </el-form-item>
                <el-form-item label="年龄: ">
                  <el-input v-model="editForm.age" style="width: 200px" placeholder="请输入年龄"></el-input>
                </el-form-item>
                <el-form-item label="联系电话: ">
                  <el-input v-model="editForm.telephone" style="width: 200px" placeholder="请输入联系电话"></el-input>
                </el-form-item>
                <el-form-item label="最大借书量: ">
                  <el-input
                    v-model="editForm.maxborrow"
                    style="width: 200px"
                    placeholder="请输入最大借书量"
                  ></el-input>
                </el-form-item>
                <el-form-item label="性别: ">
                  <el-radio v-model="editForm.sex" label="男">男</el-radio>
                  <el-radio v-model="editForm.sex" label="女">女</el-radio>
                  <el-radio v-model="editForm.sex" label="保密">保密</el-radio>
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
      detailMsg: false,
      search: "",
      create: false,
      currentPage: 1,
      pageSize: 10,
      maxPage: null,
      createForm: {
        username: "",
        name: "",
        nickname: "",
        telephone: "",
        maxborrow: "",
        sex: "",
        age: "",
      },
      tableData: null,
      editForm: {
        id: "",
        username: "",
        name: "",
        telephone: "",
        maxborrow: "",
        sex: "",
        age: "",
      },
    };
  },
  created() {
    this.getList();
  },
  methods: {
    // 清空上次的添加信息
    cleanInput() {
      this.createForm.username = "";
      this.createForm.name = "";
      this.createForm.nickname = "";
      this.createForm.age = "";
      this.createForm.telephone = "";
      this.createForm.maxborrow = "";
      this.createForm.sex = "";
    },
    // 完成编辑
    edit() {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/editUserInfo.php",
          qs.stringify({
            role: "user",
            id: _this.editForm.id,
            username: _this.editForm.username,
            name: _this.editForm.name,
            telephone: _this.editForm.telephone,
            maxborrow: _this.editForm.maxborrow,
            sex: _this.editForm.sex,
            age: _this.editForm.age,
          })
        )
        .then((res) => {
          
          if (res.data === "success") {
            _this.$message.success("修改成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            console.log(res);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getList() {
      let _this = this;
      this.$axios
        .get(
          "http://localhost/lms_api/getUserInfo.php?role=student&currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize
        )
        .then(function (data) {
          _this.tableData = data.data[0].data; // 返回的数据
          _this.maxPage = data.data[0].total; // 返回的页数
          console.log(_this.maxPage);
        });
    },
    // 获取当前页码的数据
    currentChange(currentPage) {
      this.currentPage = currentPage;
      let _this = this;
      this.$axios
        .get(
          "http://localhost/lms_api/getUserInfo.php?role=student&currentPage=" +
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
    // 显示搜索结果
    showSearch() {
      let _this = this;
      this.currentPage = 1;
      this.$axios
        .get(
          "http://localhost/lms_api/getUserInfo.php?role=student&currentPage=" +
            _this.currentPage +
            "&pageSize=" +
            _this.pageSize +
            "&search=" +
            _this.search
        )
        .then(function (data) {
          _this.tableData = data.data[0].data; // 返回的数据
          _this.maxPage = data.data[0].total; // 返回的页数
        });
    },
    // 新建学生信息
    createStudent() {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/createUser.php",
          qs.stringify({
            role: "student",
            username: _this.createForm.username,
            name: _this.createForm.name,
            nickname: _this.createForm.nickname,
            age: _this.createForm.age,
            telephone: _this.createForm.telephone,
            maxborrow: _this.createForm.maxborrow,
            sex: _this.createForm.sex,
          })
        )
        .then((res) => {
          if (res.data === "success") {
            _this.$message.success("新建学生信息成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } 
          else if(res.data === "existed") {
            _this.$message.error("请检查该学生是否已存在", 500);
          }
          else {
            console.log("新建学生信息失败");
          }
        });
    },
    // 删除教师信息
    del(row) {
      console.log(row);
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/delMsg.php",
          qs.stringify({
            id: row.id,
            role: "user",
          })
        )
        .then((res) => {
          if (res.data === "success") {
            _this.$message.success("删除教师信息成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            console.log("删除教师信息失败");
          }
        });
    },
  },
};
</script>
<style scoped>
.el-dialog .el-button + .el-button {
  margin-left: 10%;
}
.demo-table-expand {
  font-size: 0;
}
.demo-table-expand label {
  width: 90px;
  color: #99a9bf;
}
.demo-table-expand .el-form-item {
  margin-right: 0;
  margin-bottom: 0;
  width: 50%;
}
.el-form-item span {
  padding-left: 15px;
}
</style>
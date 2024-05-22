<template>
  <div class="personal">
    <el-row :gutter="20" style="margin-top: 10px">
      <el-col :span="8">
        <div class="grid-content bg-purple">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>个人中心</span>
            </div>
            <div class="name-role">
              <span class="sender">{{ user.role }} - {{ details.name }}</span>
            </div>
            <div
              class="registe-info"
              v-if="this.$route.path === '/admin/personal'"
            >
              <span class="registe-info">
                注册时间:
                <i class="el-icon-time"></i>
                {{ details.date }}
              </span>
            </div>
            <el-divider></el-divider>
            <div class="personal-relation">
              <div class="relation-item">
                手机号:
                <div style="float: right; padding-right: 20px">
                  {{ details.telephone }}
                </div>
              </div>
            </div>
            <div
              class="personal-relation"
              v-if="this.$route.path === '/admin/personal'"
            >
              <div class="relation-item">
                首页链接:
                <div style="float: right; padding-right: 20px">
                  {{ details.homepage }}
                </div>
              </div>
            </div>
          </el-card>
        </div>
      </el-col>
      <el-col :span="16">
        <div class="grid-content bg-purple">
          <el-card class="box-card">
            <div slot="header" class="clearfix">
              <span>基本资料</span>
            </div>
            <div>
              <el-form
                label-width="100px"
                v-model="edit"
                size="small"
                label-position="right"
              >
                <el-form-item label="用户昵称" prop="nickname">
                  <el-input
                    v-if="isEdit"
                    auto-complete="off"
                    v-model="edit.nickname"
                  ></el-input>
                  <span v-else>{{ details.nickname }}</span>
                </el-form-item>
                <el-form-item label="姓名" prop="name">
                  <el-input
                    v-if="isEdit"
                    auto-complete="off"
                    v-model="edit.name"
                  ></el-input>
                  <span v-else>{{ details.name }}</span>
                </el-form-item>
                <el-form-item label="手机号" prop="telephone">
                  <el-input
                    v-if="isEdit"
                    auto-complete="off"
                    v-model="edit.telephone"
                  ></el-input>
                  <span v-else>{{ details.telephone }}</span>
                </el-form-item>
                <el-form-item label="最多借书量" prop="maxborrow" v-if="user.role != 'admin'">
                  <el-input
                    v-if="isEdit"
                    auto-complete="off"
                    v-model="edit.maxborrow"
                  ></el-input>
                  <span v-else>{{ details.maxborrow }}</span>
                </el-form-item>
                <el-form-item
                  label="首页链接"
                  prop="homepage"
                  v-if="this.$route.path === '/admin/personal'"
                >
                  <el-input
                    v-if="isEdit"
                    maxlength="18"
                    v-model="edit.homepage"
                  ></el-input>
                  <span v-else>{{ details.homepage }}</span>
                </el-form-item>
                <el-form-item
                  label="个人简介"
                  v-if="this.$route.path === '/admin/personal'"
                >
                  <el-input
                    v-if="isEdit"
                    type="textarea"
                    :rows="2"
                    placeholder="请输入内容"
                    v-model="edit.introduction"
                  ></el-input>
                  <span v-else>{{ details.introduction }}</span>
                </el-form-item>
                <el-form-item label="性别" prop="sex" v-if="user.role != 'admin'">
                  <el-input
                    v-if="isEdit"
                    auto-complete="off"
                    v-model="edit.sex"
                  ></el-input>
                  <span v-else>{{ details.sex }}</span>
                </el-form-item>
                <el-form-item label="年龄" prop="age" v-if="user.role != 'admin'">
                  <el-input
                    v-if="isEdit"
                    auto-complete="off"
                    v-model="edit.age"
                  ></el-input>
                  <span v-else>{{ details.age }}</span>
                </el-form-item>
              </el-form>
              <div slot="footer" class="dialog-footer" align="center">
                <template v-if="isEdit">
                  <el-button size="mini" type="success" @click="submit()"
                    >保存</el-button
                  >
                  <el-button size="mini" type="warning" @click="isEdit = false"
                    >关闭</el-button
                  >
                </template>
                <el-button
                  size="mini"
                  type="primary"
                  @click="
                    edit = { ...details };
                    isEdit = true;
                  "
                  v-else
                  >编辑</el-button
                >
              </div>
            </div>
          </el-card>
        </div>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import qs from "qs";
export default {
  data() {
    return {
      // role: null,
      // 控制是否显示输入框
      isShow: false,
      dataForm: null,
      user: "",
      details: "",
      edit: "",
      isEdit: false,
    };
  },
  created() {
    this.getUser();
  },
  methods: {
    getUser() {
      this.user = JSON.parse(window.sessionStorage.getItem("User"));
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/personal.php",
          qs.stringify({
            role: _this.user.role,
            username: _this.user.username,
          })
        )
        .then((res) => {
          console.log(res.data[0]);
          _this.details = res.data[0];
          _this.edit = { ...res.data[0] };
        })
        .catch((err) => {
          console.log(err);
          
        });
        
    },
    submit() {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/editPersonal.php",
          qs.stringify({
            name: _this.edit.name,
            username: _this.edit.username,
            role: _this.user.role,
            nickname: _this.edit.nickname,
            telephone: _this.edit.telephone,
            homepage: _this.edit.homepage,
            introduction: _this.edit.introduction,
            maxborrow: _this.edit.maxborrow,
            sex: _this.edit.sex,
            age: _this.edit.age,
          })
        )
        .then((res) => {
          // console.log(res.data);
          if (res.data==="success") {
            _this.$message.success("修改成功", 500);
            setTimeout(() => {
              window.location.reload();
            }, 500);
          } else {
            console.log(res);
            console.log("修改失败");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
};
</script>
<style scoped>
.el-divider {
  margin: 30px 0;
}
.el-button + .el-button {
  margin-left: 50px;
}
.el-form-item span {
  padding: 15px;
}
</style>
<template>
  <div class="login">
    <div class="panel">
      <div class="title">登录</div>
      <div class="line"></div>
      <div class="input">
        <el-form :model="loginForm" :rules="loginRules" ref="loginForm">
          <el-form-item prop="username">
            <span>用户名</span>
            <el-input v-model="loginForm.username" placeholder="请输入账号"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <span>密码</span>
            <el-input v-model="loginForm.password" placeholder="请输入密码" show-password></el-input>
          </el-form-item>
          <el-form-item prop="role">
            <span>身份</span>
            <el-select v-model="loginForm.role" placeholder="请选择身份登录">
              <el-option
                v-for="item in roleList"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              ></el-option>
            </el-select>
          </el-form-item>
        </el-form>
      </div>
      <div class="input"></div>
      <div class="operate">
        <el-checkbox v-model="isRemember">记住我</el-checkbox>
        <el-link href="/forget" :underline="false" type="primary">忘记密码？</el-link>
      </div>
      <div class="submit" @click="login()">Login</div>
      <div class="register-link">
        <el-link href="/register" :underline="false">注册账号</el-link>
      </div>
    </div>
  </div>
</template>
<script>
import qs from "qs";
export default {
  data() {
    var checkRole = (rule, value, callback) => {
      if (!value) {
        callback(new Error("请选择身份"));
      } else {
        callback();
      }
    };
    return {
      // 登录表单
      loginForm: {
        username: "",
        password: "",
        role: "",
      },
      roleList: [
        {
          label: "管理员",
          value: "admin",
        },
        {
          label: "用户",
          value: "user",
        },
      ],
      isRemember: false,
      // 登录规则
      loginRules: {
        username: [
          {
            required: true,
            message: "请输入账号",
            trigger: "blur",
          },
        ],
        password: [
          {
            required: true,
            message: "请输入密码",
            trigger: "blur",
          },
        ],
        role: [
          {
            validator: checkRole,
            trigger: "blur",
          },
        ],
      },
    };
  },
  methods: {
    login() {
      let _this = this;
      this.$refs.loginForm.validate((valid) => {
        if (valid) {
          this.$axios
            .post(
              "http://localhost/lms_api/checkPwd.php",
              qs.stringify({
                username: _this.loginForm.username,
                password: _this.loginForm.password,
                role: _this.loginForm.role,
              })
            )
            .then(function (res) {
              console.log(res);
              if (res.data==="success") {
                const info = {
                  username: _this.loginForm.username,
                  password: _this.loginForm.password,
                  role: _this.loginForm.role,
                };
                sessionStorage.setItem("User", JSON.stringify(info));
                _this.$notify({
                  type: "success",
                  message: "欢迎你，" + _this.loginForm.username + "!",
                  duration: 2000,
                });
                setTimeout(function () {
                  window.location.href = "/" + _this._data.loginForm.role;
                }, 2000);
              } else {
                _this.$message({
                  type: "error",
                  message: "用户名或密码错误",
                  showClose: true,
                });
              }
            })
            .catch(function (err) {
              console.log(err);
            });
        } else {
          return false;
        }
      });
    },
  },
};
</script>
<style>
* {
  margin: 0;
  padding: 0;
  list-style: none;
  font-family: "Courier New", Courier, monospace;
}
.operate .el-checkbox__input.is-checked + .el-checkbox__label {
  color: #184e83;
}
</style>
<style scoped>
/* 整个页面 */
.login {
  background-image: linear-gradient(
      to bottom,
      rgba(9, 37, 72, 0.5),
      rgba(62, 102, 136, 0.3),
      rgba(255, 255, 255, 0.1),
      rgba(114, 170, 195, 0.3),
      rgba(13, 37, 77, 0.5)
    ),
    url(../assets/img/17.jpg);
  /* background-image: url("../assets/img/79422437_p0.jpg"); */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

/* 登录面板 */
.panel {
  width: 60%;
  max-width: 500px;
  border-radius: 6px;
  background: rgba(255, 255, 255, 0.192);
  box-shadow: 3px 3px 5px 3px #184e83;
  display: flex;
  flex-direction: column;
}

/* 登录标题 */
.title {
  text-align: center;
  color: #fff;
  font-size: 30px;
  font-weight: 600;
  padding: 20px 0 10px 0;
}

/* 分隔符 */
.line {
  /* margin: 0 auto; */
  border-bottom: 1px solid #fff;
  width: 80%;
  margin: 5px auto 15px auto;
}

/* 输入部分 */
.input {
  width: 80%;
  margin: 0 auto;
}

/* 输入框标签 */
.input span {
  color: #fff;
}

/* 输入框 */
.input .el-input {
  /* margin: 5px 0 15px 0; */
}

/* 选择框 */
.input .el-select {
  width: 100%;
  /* margin: 5px 0 15px 0; */
}

/* 操作部分 */
.operate {
  width: 80%;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
}

/* 记住我 */
.operate .el-checkbox {
  color: #fff;
}

/* .el-checkbox__input.is-checked .el-checkbox__label */
/* 跳转链接 */
.operate .el-link {
  color: #fff;
}
.operate .el-link:hover {
  color: #184e83;
}

/* 提交按钮 */
.submit {
  cursor: pointer;
  color: #fff;
  border: 3px solid #fff;
  width: 40%;
  padding: 10px 0;
  text-align: center;
  font-size: 30px;
  font-weight: 600;
  margin: 15px auto 10px auto;
  border-radius: 6px;
  transition: 0.3s ease;
}
.submit:hover {
  color: #87bed7;
  background: #fff;
}

.register-link .el-link {
  color: #fff;
  /* justify-content: flex-end; */
  float: right;
  margin: 0 20px 10px 0;
}
.register-link .el-link:hover {
  color: #184e83;
}
</style>
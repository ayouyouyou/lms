<template>
  <div class="register">
    <div class="panel">
      <div class="title">注册</div>
      <div class="line"></div>
      <div class="input">
        <el-form :model="registerForm" :rules="loginRules" ref="registerForm">
          <el-form-item prop="username">
            <span>用户名</span>
            <el-input v-model="registerForm.username" placeholder="请输入账号"></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <span>密码</span>
            <el-input v-model="registerForm.password" placeholder="请输入密码" show-password></el-input>
          </el-form-item>
          <el-form-item prop="secpassword">
            <span>再次输入密码</span>
            <el-input v-model="registerForm.secpassword" placeholder="请再次输入密码" show-password></el-input>
          </el-form-item>
          <el-form-item prop="role">
            <span>请选择身份</span>
            <el-select v-model="registerForm.role" placeholder="请选择身份登录">
              <el-option
                v-for="item in roleList"
                :key="item.value"
                :label="item.label"
                :value="item.value"
              ></el-option>
            </el-select>
          </el-form-item>
          <el-form-item prop="no">
            <span>请输入工号/学号</span>
            <el-input v-model="registerForm.no" maxlength="12" placeholder="请输入工号/学号"></el-input>
          </el-form-item>
        </el-form>
      </div>
      <div class="input"></div>
      <div class="submit" @click="register()">Register</div>
      <div class="login-link">
        <el-link href="/login" :underline="false">返回登录</el-link>
      </div>
    </div>
  </div>
</template>
<script>
import qs from "qs";
export default {
  data() {
    // 检查用户名
    var checkUsername = (rule, value, callback) => {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/checkUsername.php",
          qs.stringify({
            username: _this.registerForm.username,
          })
        )
        .then(function (res) {
          if (res.data === "existed") {
            callback(new Error("该用户名已存在"));
          } else {
            callback();
          }
        });
    };
    // 检查密码
    var checkPass = (rule, value, callback) => {
      if (!value) {
        callback(new Error("请再次输入密码"));
      } else if (value !== this.registerForm.password) {
        callback(new Error("两次输入的密码不一致"));
      } else {
        callback();
      }
    };
    // 检查工号 / 学号
    var checkNo = (rule, value, callback) => {
      let _this = this;
      if (value.toString().length != 12) {
        callback(new Error("工号/学号一共为12个字符"));
      } else {
        this.$axios
          .post(
            "http://localhost/lms_api/checkNo.php",
            qs.stringify({
              username: _this.registerForm.username,
              no: _this.registerForm.no,
              role: _this.registerForm.role,
            })
          )
          .then((res) => {
            if (res.data === "existed") {
              callback(new Error("该工号/学号已存在"));
            } else {
              callback();
            }
          });
      }
    };
    return {
      // 登录表单
      registerForm: {
        username: "",
        password: "",
        secpassword: "",
        role: "",
        no: "",
      },
      // 记住密码
      isRemember: false,
      // 用户列表
      roleList: [
        {
          label: "教师",
          value: "teacher",
        },
        {
          label: "用户",
          value: "student",
        },
      ],
      // 登录规则
      loginRules: {
        username: [
          {
            required: true,
            message: "请输入账号",
            trigger: "blur",
          },
          {
            min: 5,
            max: 12,
            message: "长度在 5 到 12 个字符",
            trigger: "change",
          },
          {
            validator: checkUsername,
            trigger: ["change", "blur"],
          },
        ],
        password: [
          {
            required: true,
            message: "请输入密码",
            trigger: "blur",
          },
          {
            min: 6,
            max: 12,
            message: "长度在 6 到 12 个字符",
            trigger: "change",
          },
        ],
        secpassword: [
          {
            validator: checkPass,
            trigger: ["blur", "change"],
          },
        ],
        no: [
          {
            required: true,
            message: "工号/学号不能为空",
            trigger: "blur",
          },
          {
            validator: checkNo,
            trigger: ["change", "blur"],
          },
          {
            pattern: /^[0-9|\.\-]{1,12}$/,
            message: "工号/学号为数字",
            trigger: ["change", "blur"],
          },
        ],
      },
    };
  },
  methods: {
    // 检查用户名是否被使用
    isUsernameUsed() {
      console.log("no");
    },
    // 注册
    register() {
      let _this = this;
      this.$refs.registerForm.validate((valid) => {
        if (valid) {
          this.$axios
            .post(
              "http://localhost/lms_api/register.php",
              qs.stringify({
                role: "user",
                username: _this.registerForm.username,
                password: _this.registerForm.password,
              })
            )
            .then((res) => {
              if (res.data === "success") {
                console.log("注册成功");
                _this.$notify({
                  type: "success",
                  message: "注册成功，即将返回登录页面(●ˇ∀ˇ●)!~",
                  duration: 2000,
                });
                setTimeout(function () {
                  window.location.href = "/login";
                }, 2000);
              }
            })
            .catch(function (err) {
              console.log(err);
            });
        } else {
          console.log("error submit");
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
  color: #cd78a9;
}
</style>
<style scoped>
/* 整个页面 */
.register {
  background-image: linear-gradient(
      to bottom,
      rgba(9, 37, 72, 0.5),
      rgba(62, 102, 136, 0.3),
      rgba(255, 255, 255, 0.1),
      rgba(114, 170, 195, 0.3),
      rgba(13, 37, 77, 0.5)
    ),
    url(../assets/img/79422437_p0.jpg);
  /* background-image: url("../assets/img/79422437_p0.jpg"); */
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  overflow: auto;
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

.login-link .el-link {
  color: #fff;
  /* justify-content: flex-end; */
  float: right;
  margin: 0 20px 10px 0;
}
.login-link .el-link:hover {
  color: #184e83;
}
</style>
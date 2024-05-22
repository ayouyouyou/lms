<template>
  <div class="forget">
    <div class="panel">
      <div class="title">忘记密码</div>
      <div class="line"></div>
      <div class="input">
        <el-form :model="forgetForm" :rules="forgetRules" ref="forgetForm">
          <el-form-item prop="username">
            <span>用户名</span>
            <el-input
              v-model="forgetForm.username"
              placeholder="请输入账号"
            ></el-input>
          </el-form-item>
          <el-form-item prop="password">
            <span>修改密码</span>
            <el-input
              v-model="forgetForm.password"
              placeholder="请输入密码"
              show-password
            ></el-input>
          </el-form-item>
          <el-form-item prop="secpassword">
            <span>再次输入密码</span>
            <el-input
              v-model="forgetForm.secpassword"
              placeholder="请再次输入密码"
              show-password
            ></el-input>
          </el-form-item>
          <el-form-item prop="no">
            <span>请输入工号/学号</span>
            <el-input
              v-model="forgetForm.no"
              placeholder="请输入工号 / 学号"
            ></el-input>
          </el-form-item>
        </el-form>
      </div>
      <div class="input"></div>
      <div class="submit" @click="modify()">Modify</div>
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
    // 检查两次输入的密码是否相同
    var checkPass = (rule, value, callback) => {
      if (!value) {
        callback(new Error("请再次输入密码"));
      } else if (value !== this.forgetForm.password) {
        callback(new Error("两次输入的密码不一致"));
      } else {
        callback();
      }
    };
    // 检查工号/学号位数
    var checkNo = (rule, value, callback) => {
      if (value.toString().length != 12) {
        callback(new Error("工号/学号一共为12个字符"));
      } else {
        callback();
      }
    };
    return {
      // 忘记密码表单
      forgetForm: {
        username: "",
        password: "",
        secpassword: "",
        no: "",
      },
      isRemember: false,
      // 登录规则
      forgetRules: {
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
    modify() {
      // console.log(this.forgetForm);
      let _this = this;
      this.$refs.forgetForm.validate((valid) => {
        if (valid) {
          this.$axios
            .post(
              "http://localhost/lms_api/forget.php",
              qs.stringify({
                username: _this.forgetForm.username,
                password: _this.forgetForm.password,
                no: _this.forgetForm.no,
              })
            )
            .then((res) => {
              if (res.data === "success") {
                _this.$message({
                  type: "success",
                  message: "修改成功，将回到登陆页面",
                  showClose: true,
                  duration: 2000,
                });
                setTimeout(() => {
                  window.location.href = "/login";
                }, 2000);
              } else if (res.data === "failed") {
                _this.$message({
                  type: "error",
                  message: "请检查各项信息是否输入正确",
                  showClose: true,
                });
              } else {
                console.log(res);
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
}
</style>
<style scoped>
/* 整个页面 */
.forget {
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
  min-height: 100vh;
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
  margin: 20px 0;
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
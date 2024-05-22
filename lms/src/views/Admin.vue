<template>
  <div class="admin">
  <div class="user">
  
  <h3>欢迎，管理员{{ this.user.username}}进入图书借阅管理系统！</h3></div><br>
  <div class="notice">
  <div class="no-title"><h3>用户须知</h3></div>
  <div class="no-body">1、图书借阅管理系统开放对象为全校师生。</div>
  <div class="no-body">2、图书借阅管理系统开放时间为每周一至周五上午 8：00－12：00 下午 2：30 － 19：30 非上述时间网络不通，图书借阅管理系统无法使用。</div>
  <div class="no-body">3、图书借阅管理系统为开放式系统，图书馆任何一台终端电脑都可以使用。</div>
  <div class="no-body">4、用户密码为：学号，默认密码为：学号后6位。</div>
  <div class="no-body">5、在桌面找到浏览器快捷方式，双击打开浏览器，再单击收藏夹的图书借阅管理系统即可看到学校图书借阅管理系统平台，输入账号密码就可登陆。</div>
  <div class="no-body">6、若系统不能正常使用，请联系图书馆管理员。</div>
  </div></div>

</template>
<script>
export default {
  data() {
    return {
      user: null,
    };
  },
  created() {
    this.showSession();
  },
  methods: {
    showSession() {
      this.user = JSON.parse(window.sessionStorage.getItem("User"));
      console.log(this.user.username);

    },
  },
};
</script>
<style scoped>
.no-body{
  margin-top:15px;
}
</style>
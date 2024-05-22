<template>
  <div class="navbar">
    <div class="sidebar">
      <!-- 
        Admin
        公告管理
        成员管理 : 教师管理、学生管理
        图书管理 : 录入书籍、下架书籍
        借阅管理 : 图书借阅、图书归还
      -->
      <el-menu
        :default-active="active"
        class="el-menu-vertical-demo"
        :collapse="collapseStatus"
        background-color="#495466"
        text-color="#fff"
        router
      >
        <el-menu-item index="/admin" class="management-title">
          <i class="el-icon-s-management"></i>
          <span slot="title">图书借阅管理系统</span>
        </el-menu-item>
        <el-menu-item index="/admin/notice">
          <i class="el-icon-message-solid"></i>
          <span slot="title">公告管理</span>
        </el-menu-item>
        <el-menu-item index="/admin/personal">
          <i class="el-icon-user-solid"></i>
          <span slot="title">个人信息</span>
        </el-menu-item>
        <el-submenu index="3">
          <template slot="title">
            <i class="el-icon-s-custom"></i>
            <span slot="title">用户管理</span>
          </template>
          <el-menu-item index="/admin/teacher">教师管理</el-menu-item>
          <el-menu-item index="/admin/student">学生管理</el-menu-item>
        </el-submenu>
        <el-submenu index="4">
          <template slot="title">
            <i class="el-icon-notebook-2"></i>
            <span slot="title">图书管理</span>
          </template>
          <el-menu-item index="/admin/store">图书入库</el-menu-item>
          <el-menu-item index="/admin/book">图书信息</el-menu-item>
        </el-submenu>
        <el-submenu index="5">
          <template slot="title">
            <i class="el-icon-sort"></i>
            <span slot="title">借阅管理</span>
          </template>
          <el-menu-item index="/admin/borrow">图书借阅</el-menu-item>
          <el-menu-item index="/admin/return">图书归还</el-menu-item>
        </el-submenu>
      </el-menu>
    </div>

<div class="content">
  <div class="mainHeader">
    <!-- 侧边导航栏控制按钮 -->
    <span>
      <i class="el-icon-s-fold" @click="handleFold()"></i>
    </span>
    
    <div class="userCenter" @click="showDialog">
      <!-- 点击用户名和头像触发弹出框 -->
           <el-link
        :underline="false"
        href="#"
        class="username"
        >{{username}}</el-link
      >
      <el-avatar :size="40" :src="avaUrl ? avaUrl : avaUrls"></el-avatar>

       <el-dialog
        :visible.sync="dialogVisible"
        title="用户操作"
        width="400px"  
        :modal-append-to-body="false"  
        :close-on-click-modal="false"  
        @close="cancelDialog"
      >
        
          
            <!-- 图片上传组件 -->
          <el-upload
            class="upload-demo"
             action="http://localhost/lms_api/editPersonal.php"
            :show-file-list="true"
            :on-success="handleAvatarUploadSuccess"
            :on-error="handleAvatarUploadError"
            drag
          >
            <i class="el-icon-picture-outline" slot="trigger"></i>
            <div class="el-upload__text">将文件拖到此处，或<em>点击上传</em></div>
          </el-upload>
          <span slot="footer" class="dialog-footer">
          <el-button @click="handleLogout" type="danger">退出管理系统</el-button>
        </span>
      </el-dialog>
    </div>
  </div>
  <div class="mainContent">
    <router-view></router-view>
  </div>
</div>
</div>
</template>
<script>
import qs from "qs";
export default {
  name: "AdminNavbar",
  data() {
    return {
      active: "/admin",
      isCollapse: false,
      collapseStatus: false,
      username: '',
      avaUrls: "https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png",
      avaUrl:"",
      dialogVisible: false,
    };
  },
  created() {
    this.getUserMsg();
    this.activeMenuItem();
  },
  methods: {
      // 点击用户名和头像触发弹出框
      showDialog() {
      this.dialogVisible = !this.dialogVisible;
    },
    // 点击退出执行的操作
    handleLogout() {
      window.sessionStorage.removeItem("User");
      this.$message.success("退出成功，即将回到登录页面", 500);
      setTimeout(() => {
        window.location.reload();
      }, 500);
    },
    handleAvatarUploadSuccess(res,file) {
      if (res && res.success && res.imageUrl) {
        this.avaUrl = res.imageUrl; // 更新头像路径
        console.log("1",res)
        this.saveImageUrlToDatabase(res.imageUrl); // 将头像路径存入数据库
        this.$message.success("上传头像成功");
      } else {
        this.$message.error("上传头像失败");
      }
    },
    // 上传头像失败后的处理
    handleAvatarUploadError(err,file) {
      console.error("上传头像失败", err,file);
      this.$message.error("上传头像失败");
    },
    // 将头像路径存入数据库
    saveImageUrlToDatabase(imageUrl) {
      const user = JSON.parse(window.sessionStorage.getItem("User"));
      console.log("获取user",user);
      // 发送请求将图片路径存储到数据库
      console.log(imageUrl)
      this.$axios.post(
        "http://localhost/lms_api/editPersonal.php", 
        qs.stringify({
          imageUrl: imageUrl,
          username:user.username,
          role:user.role,
        })
      ).then(res => {
        console.log("图片路径保存成功", res);
      }).catch(error => {
        console.error("图片路径保存失败", error);
      });
    },
 
    cancelDialog() {
      this.dialogVisible = true; // 关闭弹出框
      
    },
    
    getAvatarUrl(imageUrl){
      return `${imageUrl}`;
    },


    handleFold() {
      this.collapseStatus = !this.collapseStatus;
    },
    goTo(path) {
      this.$router.replace(path);
    },
    activeMenuItem() {
      var url = this.$route.path;
      url = url.split("/");
      this.active = "/" + url[1] + "/" + url[2];
    },
    getUserMsg() {
      this.username = JSON.parse(window.sessionStorage.getItem("User")).username;
      const user = JSON.parse(window.sessionStorage.getItem("User"));
      console.log("user：",user)
      this.$axios.post(
        "http://localhost/lms_api/getAvaUrl.php", 
        qs.stringify({
          username:user.username,
          role:user.role,
        })
      ).then((res)=>{
          console.log("获取图片:",res.data)
          this.avaUrl=res.data.imageUrl;
        }).catch((err) => {
          console.log(err);
        });
    },
    logout() {
      window.sessionStorage.removeItem("User");
      this.$message.success("退出成功，即将回到登录页面", 500);
        setTimeout(() => {
          window.location.reload();
        }, 1000);
    }
  },
};
</script>
<style scoped>
/* 折叠侧边栏按钮动画 */
.el-icon-s-fold:hover {
  color: #409eff;
  cursor: pointer;
  transition: 0.3s ease;
}
/* 取消下划线 */
.router-link-active {
  text-decoration: none;
}
.navbar {
  display: flex;
  flex-direction: row;
}
.management-title {
  background: #2d384a !important;
}
.sidebar {
  /*设置侧边栏导航高度*/
  min-height: 100vh;
}
.el-menu-vertical-demo:not(.el-menu--collapse) {
  /*设置侧边栏不折叠的宽度*/
  width: 250px;
  height: 100%;
}
.el-menu--collapse {
  /*设置侧边栏折叠后的高度*/
  height: 100%;
}
.el-menu-item.is-active {
  background: #409eff !important;
  color: #fff;
}
.el-menu-vertical-demo > .el-menu-item.is-active:first-child {
  background: #2d384a !important;
  color: #fff;
}
.indexPage .el-aside {
  width: 300px; /*设置侧边导航栏宽度*/
  overflow-x: hidden;
  overflow-y: hidden;
}
.content {
  /*设置内容区包裹样式*/
  flex: 1;
  min-height: 100vh;
}
.mainHeader {
  /*头部样式设置*/
  height: 56px;
  padding: 0 10px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  background-color: #e3eaf4;
}
.mainContent {
  /*内容区样式设置*/
  padding: 20px 20px;
  background: #fff;
}
.userCenter {
  /*头部右侧个人中心*/
  display: flex;
  align-items: center;
  cursor: pointer;
}
.userCenter:hover .el-link {
  color: #409eff;
}
.userCenter .username {
  margin-right: 15px;
}

.dialog-content {
  display: flex;
  align-items: center;
}
.dialog-content .el-button {
  margin-right: 10px;
}
</style>
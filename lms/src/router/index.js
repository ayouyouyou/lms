import Vue from "vue";
import VueRouter from "vue-router";

import Test from "../views/Test";

import AdminNavbar from "../components/AdminNavbar";
import UserNavbar from "../components/UserNavbar";

import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import Forget from "../views/Forget.vue";
import Admin from "../views/Admin.vue";
import User from "../views/User.vue";

import Notice from "../views/Notice.vue";
import Personal from "../views/Personal.vue";
import TeacherManage from "../views/TeacherManage.vue";
import StudentManage from "../views/StudentManage.vue";
import Book from "../views/Book.vue";
import Store from "../views/Store.vue";
import Borrow from "../views/Borrow.vue";
import Return from "../views/Return.vue";
//
import AllBook from "../views/AllBook.vue";
import UserReturn from "../views/UserReturn.vue";
import UserBorrow from "../views/UserBorrow.vue";
import avatars from "../views/avatars.vue";

Vue.use(VueRouter);

// 跳转同一页面多次报错;
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch((err) => err);
};

const routes = [
  // 重定向到login页面
  {
    path: "/",
    redirect: "login",
  },
  {
    path: "/login",
    name: "用户登录",
    component: Login,
  },
  {
    path: "/register",
    name: "用户注册",
    component: Register,
  },
  {
    path: "/forget",
    name: "忘记密码",
    component: Forget,
  },
  {
    path: "/admin",
    name: "管理员页面",
    component: AdminNavbar,
    children: [
      {
        path: "/admin",
        name: "管理员页面",
        component: Admin,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/notice",
        name: "公告管理",
        component: Notice,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/personal",
        name: "个人信息",
        component: Personal,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/teacher",
        name: "教师管理",
        component: TeacherManage,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/student",
        name: "学生管理",
        component: StudentManage,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/store",
        name: "图书入库",
        component: Store,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/book",
        name: "图书信息",
        component: Book,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/borrow",
        name: "借阅管理",
        component: Borrow,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/admin/return",
        name: "归还管理",
        component: Return,
        meta: {
          login_required: true,
        },
      },
    ],
  },
  {
    path: "/user",
    // name: "用户页面",
    component: UserNavbar,
    meta: {
      login_required: true,
    },
    children: [
      {
        path: "/user",
        name: "用户页面",
        component: User,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/user/notice",
        name: "Notice",
        component: Notice,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/user/personal",
        name: "Personal",
        component: Personal,
        meta: {
          login_required: true,
        },
      },

      {
        path: "/user/allbook",
        name: "AllBook",
        component: AllBook,
        meta: {
          login_required: true,
        },
      },
      
      {
        path: "/user/Userreturn",
        name: "UserReturn",
        component: UserReturn,
        meta: {
          login_required: true,
        },
      },
      {
        path: "/user/Userborrow",
        name: "UserBorrow",
        component: UserBorrow,
        meta: {
          login_required: true,
        },
      },
    ],
  },
  {
    path: "/test",
    name: Test,
    component: Test,
  },
  {
      path: "/avatars",
      name: avatars,
      component: avatars,
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

router.beforeEach(function (to, from, next) {
  // 获取用户登录信息
  var logged_in = window.sessionStorage.getItem("User");
  // 解析成json对象
  var data = JSON.parse(logged_in);
  // 获取所取对象role属性
  // 获取目标路径
  var url = to.path;
  url = url.split("/");
  document.title = to.name;
  // 各种登录情况
  // 情况1. 页面无需登录
  // 情况2. 页面需登录 但未登录
  // 情况3. 页面需登录 且已登录登陆
  // 情况3.1 已登录 但身份不符
  // 情况3.2 已登录 且身份符合

  // 情况1
  if (to.meta.login_required == null) {
    next();
  } else {
    // 情况2
    if (!logged_in) {
      // console.log("你还没登陆呢");
      next("/login");
    } else {
      // 情况3
      if (url[1] !== data.role) {
        // console.log("身份不符呢");
        next("/login");
      } else {
        // console.log("身份符合呢");
        next();
      }
    }
  }
});

export default router;

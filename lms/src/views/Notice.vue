<template>
  <div class="notice">
    <div v-if="this.$route.path === '/admin/notice'">
      <el-card class="box-card" shadow="hover">
        <div slot="header" class="clearfix">
          <span>公告管理</span>
          <!-- 查看往期公告 -->
          <el-button
            style="float: right; padding: 3px 0"
            @click="previousAnnouncements = true"
            type="text"
            >查看往期公告</el-button
          >
          <el-dialog title="往期公告" :visible.sync="previousAnnouncements">
            <template>
              <el-timeline>
                <el-timeline-item
                  v-for="item in notice"
                  :key="item.id"
                  :timestamp="item.date"
                  placement="top"
                >
                  <el-card>
                    <h4>{{ item.title }}</h4>
                    <p>{{ item.content }}</p>
                  </el-card>
                </el-timeline-item>
              </el-timeline>
            </template>
            <div slot="footer" class="dialog-footer">
              <el-button @click="previousAnnouncements = false"
                >确 定</el-button
              >
            </div>
          </el-dialog>
        </div>
        <div class="content">
          <div v-if="thisTimeNotice != null">
            <h3 class="content-title" align="center">
              {{ thisTimeNotice.title }}
            </h3>
            <p class="content-text">{{ thisTimeNotice.content }}</p>
            <p align="right">--{{ thisTimeNotice.date }}</p>
          </div>
          <div v-else>
            <p class="content-text">暂无数据，请添加公告</p>
          </div>
        </div>
        <el-divider></el-divider>

        <div align="right">
          <!-- 功能 -->
          <el-button type="primary" @click="createAnnouncements = true"
            >新建</el-button
          >
          <el-button v-if="thisTimeNotice" @click="editAnnouncements = true"
            >修改</el-button
          >
          <!-- 新建 -->
          <el-dialog
            title="新建公告"
            :visible.sync="createAnnouncements"
            :append-to-body="true"
            center
          >
            <el-form :model="form">
              <el-form-item label="时间" :label-width="formLabelWidth">
                <el-date-picker
                  v-model="form.date"
                  type="date"
                  :editable="false"
                  placeholder="选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                  style="width: 70%"
                ></el-date-picker>
              </el-form-item>
              <el-form-item label="标题" :label-width="formLabelWidth">
                <el-input
                  v-model="form.title"
                  type="text"
                  placeholder="请输入标题"
                  autocomplete="off"
                  style="width: 70%"
                ></el-input>
              </el-form-item>
              <el-form-item label="正文" :label-width="formLabelWidth">
                <el-input
                  v-model="form.content"
                  type="textarea"
                  :rows="5"
                  placeholder="请输入正文内容"
                  maxlength="140"
                  autocomplete="off"
                  show-word-limit
                  style="width: 70%"
                ></el-input>
              </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
              <el-button @click="editAnnouncements = false">取 消</el-button>
              <el-button type="primary" @click="createNotice">确 定</el-button>
            </div>
          </el-dialog>
          <!-- ?? 修改 ?? -->
          <el-dialog
            v-if="thisTimeNotice"
            title="修改公告"
            :visible.sync="editAnnouncements"
            :append-to-body="true"
            center
          >
            <el-form :model="form">
              <el-form-item label="时间" :label-width="formLabelWidth">
                <el-date-picker
                  v-model="thisTimeNotice.date"
                  type="date"
                  :editable="false"
                  placeholder="选择日期"
                  format="yyyy 年 MM 月 dd 日"
                  value-format="yyyy-MM-dd"
                  style="width: 70%"
                ></el-date-picker>
              </el-form-item>
              <el-form-item label="标题" :label-width="formLabelWidth">
                <el-input
                  v-model="thisTimeNotice.title"
                  type="text"
                  placeholder="请输入标题"
                  autocomplete="off"
                  style="width: 70%"
                ></el-input>
              </el-form-item>
              <el-form-item label="正文" :label-width="formLabelWidth">
                <el-input
                  v-model="thisTimeNotice.content"
                  type="textarea"
                  :rows="5"
                  placeholder="请输入正文内容"
                  maxlength="140"
                  autocomplete="off"
                  show-word-limit
                  style="width: 70%"
                ></el-input>
              </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
              <el-button @click="editAnnouncements = false">取 消</el-button>
              <el-button type="primary" @click="editNotice">确 定</el-button>
            </div>
          </el-dialog>
        </div>
      </el-card>
    </div>
    <div v-else-if="this.$route.path === '/user/notice'">
      <el-card class="box-card" shadow="hover">
        <div slot="header" class="clearfix">
          <span>查看公告</span>
          <!-- 查看往期公告 -->
          <el-button
            style="float: right; padding: 3px 0"
            @click="previousAnnouncements = true"
            type="text"
            >查看往期公告</el-button
          >
          <el-dialog title="往期公告" :visible.sync="previousAnnouncements">
            <template>
              <el-timeline>
                <el-timeline-item
                  v-for="item in notice"
                  :key="item.id"
                  :timestamp="item.date"
                  placement="top"
                >
                  <el-card>
                    <h4>{{ item.title }}</h4>
                    <p>{{item.content }}</p>
                  </el-card>
                </el-timeline-item>
              </el-timeline>
            </template>
            <div slot="footer" class="dialog-footer">
              <el-button @click="previousAnnouncements = false"
                >确 定</el-button
              >
            </div>
          </el-dialog>
        </div>
        <div class="content">
          <div v-if="thisTimeNotice != null">
            <h3 class="content-title" align="center">
              {{ thisTimeNotice.title }}
            </h3>
            <p class="content-text">{{ thisTimeNotice.content }}</p>
            <p align="right">{{thisTimeNotice.date }}</p>
          </div>
          <div v-else>
            <p class="content-text">暂无公告</p>
          </div>
        </div>
        <!-- <el-divider></el-divider> -->
      </el-card>
    </div>
  </div>
</template>
<script>
import qs from "qs";
export default {
  data() {
    return {
      role: null,
      notice: null,
      thisTimeNotice: null,
      createAnnouncements: false,
      editAnnouncements: false,
      previousAnnouncements: false,
      formLabelWidth: "30%",
      form: {
        date: "",
        title: "",
        content: "",
      },
    };
  },
  created() {
    this.getNotice();
    this.role = JSON.parse(window.sessionStorage.getItem("User")).role;
    console.log(this.role);
  },
  methods: {
    getNotice() {
      let _this = this;
      this.$axios
        .post("http://localhost/lms_api/getNotice.php")
        .then((data) => {
          _this.notice = data.data;
          // var length = _this.notice.length;
          _this.thisTimeNotice = _this.notice[0];
          console.log(data.data)
        })
        .catch((err) => {
          console.log(err);
        });
    },
    createNotice() {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/createNotice.php",
          qs.stringify({
            date: _this.form.date,
            title: _this.form.title,
            content: _this.form.content,
          })
        )
        .then((res) => {
          if (res.data === "success") {
            this.$message.success("插入成功(๑´ㅂ`๑)");
            setTimeout(() => {
              location.reload();
            }, 2000);
          }
        });
    },
    editNotice() {
      let _this = this;
      this.$axios
        .post(
          "http://localhost/lms_api/editNotice.php",
          qs.stringify({
            id: _this.thisTimeNotice.id,
            date: _this.thisTimeNotice.date,
            title: _this.thisTimeNotice.title,
            content: _this.thisTimeNotice.content,
          })
        )
        .then((res) => {
          if (res.data === "success") {
            this.$message.success("修改成功(●'◡'●)");
            setTimeout(() => {
              location.reload();
            }, 2000);
          }
        });
    },
  },
};
</script>
<style scoped>
</style>
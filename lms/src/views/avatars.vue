<template>
    <div>
      <img :src="avaUrl" alt="Avatar">
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        avaUrl: '', // 在获取到用户头像的 URL 后，将其赋值给 avaUrl
      };
    },
    created() {
      // 在组件创建时，获取用户头像的 URL
      this.fetchUserAvatar();
    },
    methods: {
      fetchUserAvatar() {
        // 发送请求获取用户头像的 URL
        axios.get('http://localhost/lms_api/editPersonal.php')
          .then(response => {
            if (response.data && response.data.success && response.data.imageUrl) {
              // 将获取到的用户头像 URL 赋值给 avaUrl
              console.log("图片数据",res)
              this.avaUrl = response.data.imageUrl;
              
            } else {
              console.error('Failed to fetch user avatar.');
            }
          })
          .catch(error => {
            console.error('Failed to fetch user avatar.', error);
          });
      }
    }
  };
  </script>
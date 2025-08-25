<template>
  <a-layout class="full-height-layout">
    <a-layout-header class="header-area">
      <div class="header-content">
        <span>読書記録</span>
        <a-button type="primary" class="logout-btn" @click="logout"
          >ログアウト</a-button
        >
      </div>
    </a-layout-header>
    <a-layout-content class="content-area">
      <Nuxt />
    </a-layout-content>
  </a-layout>
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  name: 'AuthLayout',
  methods: {
    async logout() {
      await this.$auth.logout()
    },
  },
})
</script>

<style scoped>
.full-height-layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.header-area {
  height: 64px;
  color: white;
  padding: 0 24px;
}

.header-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  height: 100%;
}

.logout-btn {
  margin-left: auto;
}

.content-area {
  flex: 1;
  padding: 24px 50px;
  overflow: auto;
}
</style>

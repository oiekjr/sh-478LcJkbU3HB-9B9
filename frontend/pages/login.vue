<template>
  <div class="container">
    <div class="form-wrapper">
      <div class="title">ログイン</div>
      <a-form-model
        :model="form"
        :rules="rules"
        @submit="handleSubmit"
        @submit.native.prevent
      >
        <a-form-model-item prop="email">
          <a-input v-model="form.email" placeholder="メールアドレス">
            <template #prefix>
              <a-icon type="mail" style="color: rgba(0, 0, 0, 0.25)" />
            </template>
          </a-input>
        </a-form-model-item>
        <a-form-model-item prop="password">
          <a-input
            v-model="form.password"
            type="password"
            placeholder="パスワード"
          >
            <template #prefix>
              <a-icon type="lock" style="color: rgba(0, 0, 0, 0.25)" />
            </template>
          </a-input>
        </a-form-model-item>
        <a-form-model-item>
          <a-button
            block
            type="primary"
            html-type="submit"
            :disabled="form.email === '' || form.password === ''"
          >
            ログイン
          </a-button>
        </a-form-model-item>
      </a-form-model>
      <NuxtLink to="/signup">アカウントをお持ちでない方はこちら</NuxtLink>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  name: 'LoginPage',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      rules: {
        email: [
          {
            required: true,
            message: 'メールアドレスを入力してください',
            trigger: 'blur',
          },
          {
            type: 'email',
            message: '正しいメールアドレス形式で入力してください',
            trigger: 'blur',
          },
        ],
        password: [
          {
            required: true,
            message: 'パスワードを入力してください',
            trigger: 'blur',
          },
        ],
      },
    }
  },
  methods: {
    handleSubmit(_: Event) {
      console.log(this.form)
    },
  },
})
</script>

<style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f0f2f5;
}

.form-wrapper {
  width: 400px;
  padding: 40px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.title {
  font-size: 24px;
  margin-bottom: 32px;
  font-weight: bold;
}
</style>
